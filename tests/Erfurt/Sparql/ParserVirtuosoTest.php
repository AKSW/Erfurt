<?php
ini_set('error_reporting', E_ALL | E_STRICT);
set_include_path(get_include_path() . PATH_SEPARATOR . '../../ontowiki/src/libraries/');
require_once 'Erfurt/TestCase.php';

require_once 'Erfurt/Sparql/Parser/Virtuoso.php';
class Erfurt_Sparql_ParserVirtuosoTest extends Erfurt_TestCase
{
    const RAP_TEST_DIR = 'resources/sparql/rap/';
    const OW_TEST_DIR = 'resources/sparql/ontowiki/';
    const EF_TEST_DIR = 'resources/sparql/erfurt/';
    const DAWG_DATA_DIR = 'resources/sparql/w3c-dawg2/data-r2/';
    
	protected function tearDown()
	{
		gc_collect_cycles();
	}

    /**
     * @dataProvider providerTestParse
     */
   	public function testParse($querySpec)
    {
		$parser = new Erfurt_Sparql_Parser_Virtuoso();
		try {
			$q= $parser->initFromString($querySpec["query"]);			
			// If query type is negative, we should not reach this code...
			if ($querySpec['type'] === 'negative') {
				echo $querySpec['type'] . "\n";				
			    $e = new Exception('Query parsing should fail.');
			    $this->fail($this->_createErrorMsg($querySpec, $e));
			}
			$this->assertTrue($q instanceof Erfurt_Sparql_Query2);			
		} catch (Exception $e) {
			if ($querySpec['type'] === 'positive') {
			    $this->fail($this->_createErrorMsg($querySpec, $e));			
		}
    }
}


    public function providerTestParse()
    {
        $queryArray = array();
        
        // // 1. ow tests 
        // $this->_importFromManifest(self::OW_TEST_DIR . 'manifest.ttl', $queryArray);
        // 
        // // 2. erfurt tests
        // $this->_importFromManifest(self::EF_TEST_DIR . 'manifest.ttl', $queryArray);
        // // 
        // // 3. rap tests
        // $this->_importFromManifest(self::RAP_TEST_DIR . 'manifest.ttl', $queryArray);
            
        // 4. dawg2
        require_once 'Erfurt/Syntax/RdfParser.php';
        $parser = new Erfurt_Syntax_RdfParser();
        $parser->initializeWithFormat('turtle');
        
        $result = $parser->parse(self::DAWG_DATA_DIR . 'manifest-syntax.ttl', Erfurt_Syntax_RdfParser::LOCATOR_FILE);
        $keys = array_keys($result);
        $subject = $keys[0];
        $base = $subject;
        $predicate = 'http://www.w3.org/2001/sw/DataAccess/tests/test-manifest#include';
        $object = $result["$subject"]["$predicate"][0]['value'];
        
        while (true) {
            $p = EF_RDF_NS . 'first';
            $filename = $result["$object"]["$p"][0]['value'];
        
            $filename = self::DAWG_DATA_DIR . substr($filename, strlen($base));
            
            $this->_importFromManifest($filename, $queryArray);
            
            $p = EF_RDF_NS . 'rest';
            $nil = EF_RDF_NS . 'nil';
            if ($result["$object"]["$p"][0]['value'] === $nil) {
                break;
            } else {
                $object = $result["$object"]["$p"][0]['value'];
            }
        }

        return $queryArray;
    }


    protected function _importFromManifest($filename, &$queryResultArray)
    {
        require_once 'Erfurt/Syntax/RdfParser.php';
        $parser = new Erfurt_Syntax_RdfParser();
        $parser->initializeWithFormat('turtle');
        
        $manifestResult = $parser->parse($filename, Erfurt_Syntax_RdfParser::LOCATOR_FILE);
        $mfAction = 'http://www.w3.org/2001/sw/DataAccess/tests/test-manifest#action';
        
        // file auslesen...
        foreach ($manifestResult as $s=>$pArray) {
            if (isset($pArray[EF_RDF_TYPE]) && 
                $pArray[EF_RDF_TYPE][0]['value'] ===
                 'http://www.w3.org/2001/sw/DataAccess/tests/test-manifest#PositiveSyntaxTest') {
                
                $queryFileName = substr($filename, 0, strrpos($filename, '/')+1) .
                                substr($pArray["$mfAction"][0]['value'], 
                                strrpos($pArray["$mfAction"][0]['value'], '/'));
                                
                     
                $queryArray = array();
                $queryArray['name']     = $s;
                $queryArray['file_name']     = $queryFileName;
                $queryArray['group']    = 'Positive syntax tests';
                $queryArray['type']     = 'positive';
                
                $handle = fopen($queryFileName, "r");
                $queryArray['query']    = fread($handle, filesize($queryFileName));
                fclose($handle);
                $queryResultArray[] = array($queryArray);
            } else if (isset($pArray[EF_RDF_TYPE]) &&
                    $pArray[EF_RDF_TYPE][0]['value'] ===
                    'http://www.w3.org/2001/sw/DataAccess/tests/test-manifest#NegativeSyntaxTest') {
                
                $queryFileName = substr($filename, 0, strrpos($filename, '/')+1) .
                                substr($pArray["$mfAction"][0]['value'], 
                                strrpos($pArray["$mfAction"][0]['value'], '/'));


                $queryArray = array();
                $queryArray['name']     = $s;
                $queryArray['file_name']     = $queryFileName;
                $queryArray['group']    = 'Negative syntax tests';
                $queryArray['type']     = 'negative';

                $handle = fopen($queryFileName, "r");
                $queryArray['query']    = fread($handle, filesize($queryFileName));
                fclose($handle);
                $queryResultArray[] = array($queryArray);
            } else {
                continue;
            }
        }
    }
    
    protected function _createErrorMsg($query, $e) 
    {
        $msg =  'Group: ' . $query['group'] . PHP_EOL .
                'Filename: ' . $query['file_name'] . PHP_EOL .
                'Name: ' . $query['name'] . PHP_EOL;
                #'Query: ' . $query['query'] . PHP_EOL;
                
        $msg .= 'Error: ' . $e->getMessage();
                
        return $msg;
    }


}

?>