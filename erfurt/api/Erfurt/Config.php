<?php
/**
  * class providing special configs 
  *
  * @author Stefan Berger <berger@intersolut.de>
  * @copyright AKSW Team
  * @version $Id$
  */
class Erfurt_Config extends Zend_Config {
	protected $_nestSeparator= '.';
	/**
	 * Loads the section $section from the config files $filenames for
   * access facilitated by nested object properties.
   * 
   * @see Zend_Config_ini::__construct
	 */
	public function __construct($filenames, $section, $config = false) {
        if (!is_array($filenames) and empty($filenames)) {
            throw new Zend_Config_Exception('Filename is not set');
        } else if (!is_array($filenames)) {
        	$filenames = array(!is_array($filenames));
    		}
        
        $allowModifications = false;
        if (is_bool($config)) {
            $allowModifications = $config;
        } elseif (is_array($config)) {
            if (isset($config['allowModifications'])) {
                $allowModifications = (bool)$config['allowModifications'];
            }
            if (isset($config['nestSeparator'])) {
                $this->_nestSeparator = $config['nestSeparator'];
            }
        }
				
        try {
        	$iniArray = Erfurt_Util::mergeIniFiles($filenames);
        } catch (Exception $e) {
        	throw $e;
        }
        
        $preProcessedArray = array();
        foreach ($iniArray as $key => $data)
        {
            $bits = explode(':', $key);
            $numberOfBits = count($bits);
            $thisSection = trim($bits[0]);
            switch (count($bits)) {
                case 1:
                    $preProcessedArray[$thisSection] = $data;
                    break;

                case 2:
                    $extendedSection = trim($bits[1]);
                    if (isset($preProcessedArray[$extendedSection])) 
                    	$preProcessedArray[$thisSection] = array_merge(array(';extends'=>$extendedSection), $data);
                    else
                    	$preProcessedArray[$thisSection] = $data;
                    break;

                default:
                    throw new Zend_Config_Exception("Section '$thisSection' may not extend multiple sections in $filename");
            }
        }
        if (null === $section) {
            $dataArray = array();
            foreach ($preProcessedArray as $sectionName => $sectionData) {
                $dataArray[$sectionName] = $this->_processExtends($preProcessedArray, $sectionName);
            }
            parent::__construct($dataArray, $allowModifications);
        } elseif (is_array($section)) {
            $dataArray = array();
            foreach ($section as $sectionName) {
                if (!isset($preProcessedArray[$sectionName])) {
                    throw new Zend_Config_Exception("Section '$sectionName' cannot be found in files");
                }
                $dataArray = array_merge($this->_processExtends($preProcessedArray, $sectionName), $dataArray);

            }
            parent::__construct($dataArray, $allowModifications);
        } else {
            if (!isset($preProcessedArray[$section])) {
                throw new Zend_Config_Exception("Section '$section' cannot be found in $filename");
            }
            parent::__construct($this->_processExtends($preProcessedArray, $section), $allowModifications);
        }

        $this->_loadedSection = $section;
    }
    
/**
     * Helper function to process each element in the section and handle
     * the "extends" inheritance keyword. Passes control to _processKey()
     * to handle the "dot" sub-property syntax in each key.
     *
     * @param array $iniArray
     * @param string $section
     * @param array $config
     * @throws Zend_Config_Exception
     * @return array
     */
    protected function _processExtends($iniArray, $section, $config = array())
    {
        $thisSection = $iniArray[$section];

        foreach ($thisSection as $key => $value) {
            if (strtolower($key) == ';extends') {
                if (isset($iniArray[$value])) {
                    $this->_assertValidExtend($section, $value);
                    $config = $this->_processExtends($iniArray, $value, $config);
                } else {
                    throw new Zend_Config_Exception("Section '$section' cannot be found");
                }
            } else {
                $config = $this->_processKey($config, $key, $value);
            }
        }
        return $config;
    }

    /**
     * Assign the key's value to the property list. Handle the "dot"
     * notation for sub-properties by passing control to
     * processLevelsInKey().
     *
     * @param array $config
     * @param string $key
     * @param string $value
     * @throws Zend_Config_Exception
     * @return array
     */
    protected function _processKey($config, $key, $value)
    {
        if (strpos($key, $this->_nestSeparator) !== false) {
            $pieces = explode($this->_nestSeparator, $key, 2);
            if (strlen($pieces[0]) && strlen($pieces[1])) {
                if (!isset($config[$pieces[0]])) {
                    $config[$pieces[0]] = array();
                } elseif (!is_array($config[$pieces[0]])) {
                    throw new Zend_Config_Exception("Cannot create sub-key for '{$pieces[0]}' as key already exists");
                }
                $config[$pieces[0]] = $this->_processKey($config[$pieces[0]], $pieces[1], $value);
            } else {
                throw new Zend_Config_Exception("Invalid key '$key'");
            }
        } else {
            $config[$key] = $value;
        }
        return $config;
    }
}
?>