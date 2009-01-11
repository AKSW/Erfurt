<?php
require_once 'test_base.php';

require_once 'Erfurt/Sparql/Parser.php';

class Erfurt_Sparql_ParserParseTest implements PHPUnit_Framework_Test
{
    const RAP_TEST_DIR = 'resources/sparql/rap/';
    const OW_TEST_DIR = 'resources/sparql/ontowiki/';
    const DAWG_DATA_DIR = 'resources/sparql/w3c-dawg2/data-r2/';
    
    protected $_sparqlQueries = array();
    protected $disabledQueries = array(); // TODO
    
    public function __construct()
    {
        // 1. ow tests 
        $this->_importFromManifest(self::OW_TEST_DIR . 'manifest.ttl');
        
        // 2. rap tests
        $this->_importFromManifest(self::RAP_TEST_DIR . 'manifest.ttl');
    
        // 3. dawg2
        require_once 'Erfurt/Syntax/RdfParser.php';
        $parser = new Erfurt_Syntax_RdfParser();
        $parser->initializeWithFormat('turtle');
        
        $result = $parser->parse(self::DAWG_DATA_DIR . 'manifest-syntax.ttl', null);
        $keys = array_keys($result);
        $subject = $keys[0];
        $base = $subject;
        $predicate = 'http://www.w3.org/2001/sw/DataAccess/tests/test-manifest#include';
        $object = $result["$subject"]["$predicate"][0]['value'];
        
        while (true) {
            $p = EF_RDF_NS . 'first';
            $filename = $result["$object"]["$p"][0]['value'];
            
            $filename = self::DAWG_DATA_DIR . substr($filename, strlen($base)+1);
            
            $this->_importFromManifest($filename);
            
            $p = EF_RDF_NS . 'rest';
            $nil = EF_RDF_NS . 'nil';
            if ($result["$object"]["$p"][0]['value'] === $nil) {
                break;
            } else {
                $object = $result["$object"]["$p"][0]['value'];
            }
        }   
    }
    
    protected function _importFromManifest($filename)
    {
        require_once 'Erfurt/Syntax/RdfParser.php';
        $parser = new Erfurt_Syntax_RdfParser();
        $parser->initializeWithFormat('turtle');
        
        $manifestResult = $parser->parse($filename, null);
        $mfAction = 'http://www.w3.org/2001/sw/DataAccess/tests/test-manifest#action';
        
        // file auslesen...
        foreach ($manifestResult as $s=>$pArray) {
            if (isset($pArray[EF_RDF_TYPE]) && 
                $pArray[EF_RDF_TYPE][0]['value'] ===
                 'http://www.w3.org/2001/sw/DataAccess/tests/test-manifest#PositiveSyntaxTest') {
                
                $queryFileName = substr($filename, 0, strrpos($filename, '/')) .
                                substr($pArray["$mfAction"][0]['value'], 
                                strrpos($pArray["$mfAction"][0]['value'], '/'));
                                
                     
                $queryArray = array();
                $queryArray['name']     = $s;
                $queryArray['group']    = 'Positive syntax tests';
                $queryArray['type']     = 'positive';
                
                $handle = fopen($queryFileName, "r");
                $queryArray['query']    = fread($handle, filesize($queryFileName));
                fclose($handle);
                array_push($this->_sparqlQueries, $queryArray);
            } else if (isset($pArray[EF_RDF_TYPE]) &&
                    $pArray[EF_RDF_TYPE][0]['value'] ===
                    'http://www.w3.org/2001/sw/DataAccess/tests/test-manifest#NegativeSyntaxTest') {
                
                $queryFileName = substr($filename, 0, strrpos($filename, '/')) .
                                substr($pArray["$mfAction"][0]['value'], 
                                strrpos($pArray["$mfAction"][0]['value'], '/'));


                $queryArray = array();
                $queryArray['name']     = $s;
                $queryArray['group']    = 'Negative syntax tests';
                $queryArray['type']     = 'negative';

                $handle = fopen($queryFileName, "r");
                $queryArray['query']    = fread($handle, filesize($queryFileName));
                fclose($handle);
                array_push($this->_sparqlQueries, $queryArray);
            } else {
                continue;
            }
        }
    }
    
    public function count()
    {
        return count($this->_sparqlQueries);
    }
        
    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        if ($result === null) {
            $result = new PHPUnit_Framework_TestResult();
        }
        
        $result->startTest($this);
        
        foreach ($this->_sparqlQueries as $i => $query) {
            $parser = new Erfurt_Sparql_Parser();
            
            try {
                $queryObject = $parser->parse($query['query']);
                
                // If query type is negative, we should not reach this code...
                if ($query['type'] === 'negative') {
                    $e = new Exception('Query parsing should fail.');
                    $result->addFailure($this, 
                        new PHPUnit_Framework_AssertionFailedError($this->_createErrorMsg($i, $query, $e)), time());
                }
            } catch (Exception $e) {
                if ($query['type'] === 'positive') {
                    $result->addFailure($this, 
                        new PHPUnit_Framework_AssertionFailedError($this->_createErrorMsg($i, $query, $e)), time());
                    
                } 
            } 
        }
        
        $result->endTest($this, time());
        
        return $result;
    }
    
    // ------------------------------------------------------------------------
    
    protected function _createErrorMsg($i, $query, $e) 
    {
        $msg =  'No.: ' . $i . PHP_EOL .
                'Group: ' . $query['group'] . PHP_EOL .
                #'Filename: ' . $query['file_name'] . PHP_EOL .
                'Name: ' . $query['name'] . PHP_EOL;
                #'Query: ' . $query['query'] . PHP_EOL;
                
        if ($e instanceof PHPUnit_Framework_AssertionFailedError) {
            $msg .= 'Error: ' . $e->getDescription();
        } else {
            $msg .= 'Error: ' . $e->getMessage();
        }
                
        return $msg;
    }
}