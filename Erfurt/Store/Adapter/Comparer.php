<?php

/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/** Erfurt_Store_Adapter_Interface */
require_once 'Erfurt/Store/Adapter/Interface.php';

/** Erfurt_Store_Sql_Interface */
require_once 'Erfurt/Store/Sql/Interface.php';

class Erfurt_Store_Adapter_Comparer_Exception extends Erfurt_Store_Exception{
    function  __construct($method, $ref, $actual) {
        parent::__construct('comparer detected a difference at method "'.$method.'": return should be '.self::mydumpStr($ref).' but is '.self::mydumpStr($actual));
    }

    static function mydumpStr($var){
        $str = '<p>'; // This is for correct handling of newlines
        ob_start();
        self::dump($var);
        $a=ob_get_contents();
        ob_end_clean();
        $str .= $a; // Escape every HTML special chars (especially > and < )
        $str .= '</p>';
        return $str;
    }

    static function dump($value,$level=0)
    {
        if ($level==-1)
        {
            $trans[' ']='&there4;';
            $trans["\t"]='&rArr;';
            $trans["\n"]='&para;;';
            $trans["\r"]='&lArr;';
            $trans["\0"]='&oplus;';
            return strtr(htmlspecialchars($value),$trans);
        }
        if ($level==0) echo '<pre>';
        $type= gettype($value);
        echo $type;
        if ($type=='string')
        {
            echo '('.strlen($value).')';
            $value= self::dump($value,-1);
        }
        elseif ($type=='boolean') $value= ($value?'true':'false');
        elseif ($type=='object')
        {
            $props= get_class_vars(get_class($value));
            echo '('.count($props).') <u>'.get_class($value).'</u>';
            foreach($props as $key=>$val)
            {
                echo "\n".str_repeat("  ",$level+1).$key.' => ';
                self::dump($value->$key,$level+1);
            }
            $value= '';
        }
        elseif ($type=='array')
        {
            echo '('.count($value).')';
            foreach($value as $key=>$val)
            {
                echo "\n".str_repeat("  ",$level+1).self::dump($key,-1).' => ';
                self::dump($val,$level+1);
            }
            $value= '';
        }
        echo " <b>$value</b>";
        if ($level==0) echo '</pre>';
    }
}

/**
 * A dummy Adapter for the Erfurt Semantic Web Framework.
 *
 * compares the result of two adapters and throws errors if they are different
 *
 * @category Erfurt
 * @package Store_Adapter
 * @author Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Store_Adapter_Comparer
{

    /**
     * Adapter option array
     * @var array
     */
    protected $_adapterOptions = null;
    
    /**
     *
     * @var Erfurt_Store_Adapter_Interface 
     */
    protected $_candidate = null;
    /**
     *
     * @var Erfurt_Store_Adapter_Interface
     */
    protected $_reference = null;


    // ------------------------------------------------------------------------
    // --- Magic Methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Constructor.
     *
     * @throws Erfurt_Store_Adapter_Exception
     */
    public function __construct($adapterOptions)
    {
        $this->_adapterOptions = $adapterOptions;

        $config = Erfurt_App::getInstance()->getConfig();
        $candidateName = $adapterOptions['candidate'];
        if(isset($config->store->$candidateName)){
            $candidateConf = $config->store->get($adapterOptions['candidate']);
        }
        $referenceName = $adapterOptions['reference'];
        if(isset($config->store->$referenceName)){
            $referenceConf = $config->store->get($adapterOptions['reference']);
        }

        if(!isset($candidateConf) || !isset ($referenceConf)){
            throw new Erfurt_Store_Exception("the requested adapters to be compared have no options set in config.ini");
        }
        if($candidateName == "zenddb"){
            $candidateClassName = 'Erfurt_Store_Adapter_EfZendDb';
        } else {
            $candidateClassName = 'Erfurt_Store_Adapter_'.ucfirst($adapterOptions['candidate']);
            if(!class_exists($candidateClassName)){
                throw new Erfurt_Store_Exception("the requested adapter class ".$candidateClassName." does not exist");
            }
        }
        if($referenceName == "zenddb"){
            $referenceClassName = 'Erfurt_Store_Adapter_EfZendDb';
        } else {
            $referenceClassName = 'Erfurt_Store_Adapter_'.ucfirst($adapterOptions['reference']);
            if(!class_exists($referenceClassName)){
                throw new Erfurt_Store_Exception("the requested adapter class ".$referenceClassName." does not exist");
            }
        }

        $this->_candidate = new $candidateClassName($candidateConf->toArray());
        $this->_reference = new $referenceClassName($referenceConf->toArray());

        if (isset($adapterOptions['ignoredMethods'])) {
            self::$_ignoredMethods = $adapterOptions['ignoredMethods'];
        } 
    }

    protected static $_strictMethods = array('isModelAvailable');
    protected static $_setMethods = array('sparqlQuery');
    protected static $_ignoredMethods = array();

    static function nestedArrayMutualInclusion($arr1, $arr2){
        foreach($arr1 as $key => $val){
            if(!isset ($arr2[$key])){
                return false;
            } else {
                if(gettype($arr1[$key]) != gettype($arr2[$key])){
                    return false;
                } else {
                    if(is_array($arr1[$key])){
                        if(!self::nestedArrayMutualInclusion($arr1[$key], $arr2[$key])){
                            return false;
                        }
                    } else {
                        if($arr1[$key] != $arr2[$key]){
                            return false;
                        }
                    }
                }
            }
        }
        foreach($arr2 as $key => $val){
            if(!isset ($arr1[$key])){
                return false;
            } else {
                if(gettype($arr1[$key]) != gettype($arr2[$key])){
                    return false;
                } else {
                    if(is_array($arr1[$key])){
                        if(!self::nestedArrayMutualInclusion($arr1[$key], $arr2[$key])){
                            return false;
                        }
                    } else {
                        if($arr1[$key] != $arr2[$key]){
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }


    public function  __call($name, $arguments) {
        $candThrowed = false;
        try {
            $candRet = call_user_func_array(array($this->_candidate, $name), $arguments);
            if(in_array($name, self::$_ignoredMethods)){
                return $candRet;
            }
        } catch (Exception $e){
            if(in_array($name, self::$_ignoredMethods)){
                throw $e;
            }
            $candThrowed = $e;
        }

        $refThrowed = false;
        try {
            $refRet = call_user_func_array(array($this->_reference, $name), $arguments);
        } catch (Exception $e){
            $refThrowed = $e;
        }
        
        if($candThrowed != false && $refThrowed == false){
            throw new Erfurt_Store_Exception("Candidate throwed an exception but reference didn't".PHP_EOL.$candThrowed->getTraceAsString());
        }
        if($candThrowed == false && $refThrowed != false){
            throw new Erfurt_Store_Exception("Reference throwed an exception but Candidate didn't".PHP_EOL.$candThrowed->getTraceAsString());
        }

        if(in_array($name, self::$_strictMethods)){
            if($refRet !== $candRet){
                throw new Erfurt_Store_Adapter_Comparer_Exception($name, $refRet, $candRet);
            }
        } else  if(in_array($name, self::$_setMethods)){
            if(!self::nestedArrayMutualInclusion($refRet, $candRet)){
                throw new Erfurt_Store_Adapter_Comparer_Exception($name, $refRet, $candRet);
            }
        }

        return $candRet;
    }
}
