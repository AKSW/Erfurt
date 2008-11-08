<?php
require_once 'test_base.php';

require_once 'Erfurt/Sparql/Parser.php';

class Erfurt_Sparql_ParserParseTest implements PHPUnit_Framework_Test
{
    const RAP_TEST_DIR = 'resources/sparql/rap/';
    const OW_TEST_DIR = 'resources/sparql/ontowiki/';
    const DAWG_DATA_DIR = 'resources/sparql/w3c-dawg2/data_r2/';
    
    protected $_sparqlQueries = array();
    protected $disabledQueries = array(); // TODO
    
    public function __construct()
    {
// TODO put the following code into a private method... duplicate stuff :(
        $i = 0;
        // 1. collect the rap test queries... this are all correct queries... so they should get parsed
        if ($dirHandle = opendir(self::RAP_TEST_DIR)) {
            while (false !== ($fileName = readdir($dirHandle))) {
                if (($fileName !== '.') && ($fileName !== '..') && (substr($fileName, -4) === 'phpt')) {
                    $fileString = file_get_contents(self::RAP_TEST_DIR . $fileName);
                    
                    $currentQuery = eval($fileString);
                    
                    if (!isset($currentQuery['test_syntax']) || $currentQuery['test_syntax'] !== false) {
                        $this->_sparqlQueries[$i] = $currentQuery;
                        $this->_sparqlQueries[$i]['file_name'] = self::RAP_TEST_DIR . $fileName;
                        
                        ++$i;
                    }
                }
            }
            closedir($dirHandle);
        }
        
        // 2. collect the ow test queries...
        if ($dirHandle = opendir(self::OW_TEST_DIR)) {
            while (false !== ($fileName = readdir($dirHandle))) {
                if (($fileName !== '.') && ($fileName !== '..') && (substr($fileName, -4) === 'phpt')) {
                    $fileString = file_get_contents(self::OW_TEST_DIR . $fileName);
                    
                    $currentQuery = eval($fileString);
                    
                    if (!isset($currentQuery['test_syntax']) || $currentQuery['test_syntax'] !== false) {
                        $this->_sparqlQueries[$i] = $currentQuery;
                        $this->_sparqlQueries[$i]['file_name'] = self::OW_TEST_DIR . $fileName;
                        
                        ++$i;
                    }
                }
            }
            closedir($dirHandle);
        }
        
        // 3. collect all rq files from the dawg test cases... use the manifest.ttl files to determine, whether
        // quries are positive or negative
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
            } catch (Exception $e) {
                $result->addFailure($this, 
                    new PHPUnit_Framework_AssertionFailedError($this->_createErrorMsg($i, $query, $e)), time());
                continue;
            } 
            
            try {
                if (isset($query['result_form'])) {
                    PHPUnit_Framework_Assert::assertEquals($query['result_form'], $queryObject->getResultForm());
                }
                if (isset($query['result_vars'])) {
                    foreach ($queryObject->getResultVars() as $i=>$resultVar) {
                        PHPUnit_Framework_Assert::assertEquals($query['result_vars'][$i],
                                $resultVar->getVariable());
                    }
                    
                    
                }
            } catch (PHPUnit_Framework_AssertionFailedError $e) {
                $result->addFailure($this, 
                    new PHPUnit_Framework_AssertionFailedError($this->_createErrorMsg($i, $query, $e)), time());
            } catch (Exception $e) {
                $result->addError($this, 
                    new PHPUnit_Framework_AssertionFailedError($this->_createErrorMsg($i, $query, $e)), time());
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
                'Filename: ' . $query['file_name'] . PHP_EOL .
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