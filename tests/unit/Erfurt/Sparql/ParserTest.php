<?php
class Erfurt_Sparql_ParserTest extends Erfurt_TestCase
{
    const RAP_TEST_DIR = 'rap/';
    const OW_TEST_DIR = 'ontowiki/';
    const EF_TEST_DIR = 'erfurt/';
    const DAWG_DATA_DIR = 'w3c-dawg2/data-r2/';

    protected $_parser = null;

    public function setUp()
    {
        $this->_parser = new Erfurt_Sparql_Parser();
    }

    // ------------------------------------------------------------------------

    public function testTokenize()
    {
        $tokens = array(
            'ABC', 'abc', '0123456789', '(', ')', '[', ']', '"', '"', "'", "'", '{', '}', 'x', 'x', 'x',
            '?$', '.', ',', '#', '#', '#', ';', '#'
        );

        $tokenString = "ABC abc 0123456789 \n () \t [] \"\" '' {} x\nx\tx ?$ ., # \r # #;#";

        $this->assertEquals($tokens, Erfurt_Sparql_Parser::tokenize($tokenString));
    }

    public function testTokenizeFilter()
    {
        $tokensA = array(
            'WHERE', '{', '?a', 'p1:p', '?b', ',', '?c', '.', 'FILTER', "(", "xsd:dateTime", '(',
            '?a', ')', '=', 'xsd:dateTime', '(', '"', '1978-01-08T00:00:00Z', '"', ')', ')', '.',
            '}'
        );

        $tokensB = array(
            'WHERE', '{', '?a', 'p1:p', '?b', ',', '?c', '.', 'FILTER', "(", "xsd:dateTime", '(',
            '?a', ')', '<=', 'xsd:dateTime', '(', '"', '1978-01-08T00:00:00Z', '"', ')', ')', '.',
             '}'
        );

        $queryStringA = '
            WHERE {
                ?a p1:p ?b, ?c.
                FILTER (xsd:dateTime(?a) = xsd:dateTime("1978-01-08T00:00:00Z")).
            }';

        $queryStringB = '
            WHERE {
                ?a p1:p ?b, ?c.
                FILTER (xsd:dateTime(?a) <= xsd:dateTime("1978-01-08T00:00:00Z")).
            }';

        $this->assertEquals($tokensA, Erfurt_Sparql_Parser::tokenize($queryStringA));
        $this->assertEquals($tokensB, Erfurt_Sparql_Parser::tokenize($queryStringB));
    }

    public function testUncomment()
    {
        $queryString = '# bla
                        ## bla bla
                        ### bla bla bla';

        $this->assertEquals('', trim(Erfurt_Sparql_Parser::uncomment($queryString)));
    }

    /**
     * @dataProvider providerTestParse
     */
    public function testParse($querySpec)
    {
        $queryObject = null;
        try {
            $queryObject = $this->_parser->parse($querySpec['query']);

            // If query type is negative, we should not reach this code...
            if ($querySpec['type'] === 'negative') {
                $this->fail($this->_createErrorMsg($querySpec, 'Query parsing should fail.'));
            }

            $this->assertTrue($queryObject instanceof Erfurt_Sparql_Query);
        } catch (Exception $e) {
            if ($querySpec['type'] === 'positive') {
                $this->fail($this->_createErrorMsg($querySpec, $e));
            } else {
                $this->assertNull($queryObject);
            }
        }

    }

    public function providerTestParse()
    {
        $cacheFullPath = realpath(dirname(__FILE__)) .'/_cache/_sparql_parserTest_testParse';
        if (file_exists($cacheFullPath)) {
            return unserialize(file_get_contents($cacheFullPath));
        }

        $queryArray = array();

        $resourceFileBase = realpath(dirname(__FILE__)) .'/_files/';

        // 1. ow tests
        $this->_importFromManifest($resourceFileBase . self::OW_TEST_DIR . 'manifest.ttl', $queryArray);

        // 2. erfurt tests
        $this->_importFromManifest($resourceFileBase . self::EF_TEST_DIR . 'manifest.ttl', $queryArray);

        // 3. rap tests
        $this->_importFromManifest($resourceFileBase . self::RAP_TEST_DIR . 'manifest.ttl', $queryArray);

        // 4. dawg2
        require_once 'Erfurt/Syntax/RdfParser.php';
        $parser = new Erfurt_Syntax_RdfParser();
        $parser->initializeWithFormat('turtle');

        $result = $parser->parse($resourceFileBase . self::DAWG_DATA_DIR . 'manifest-syntax.ttl', Erfurt_Syntax_RdfParser::LOCATOR_FILE);
        $keys = array_keys($result);
        $subject = $keys[0];
        $base = $subject;
        $predicate = 'http://www.w3.org/2001/sw/DataAccess/tests/test-manifest#include';
        $object = $result["$subject"]["$predicate"][0]['value'];

        while (true) {
            $p = EF_RDF_NS . 'first';
            $filename = $result["$object"]["$p"][0]['value'];

            $filename = $resourceFileBase . self::DAWG_DATA_DIR . substr($filename, strlen($base));

            $this->_importFromManifest($filename, $queryArray);

            $p = EF_RDF_NS . 'rest';
            $nil = EF_RDF_NS . 'nil';
            if ($result["$object"]["$p"][0]['value'] === $nil) {
                break;
            } else {
                $object = $result["$object"]["$p"][0]['value'];
            }
        }

        // cache for faster loading next time
        file_put_contents($cacheFullPath, serialize($queryArray));

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

                $queryFileName = substr(urldecode($pArray[$mfAction][0]['value']), 7);

                $queryArray = array();
                $queryArray['name']     = $s;
                $queryArray['file_name']     = $queryFileName;
                $queryArray['group']    = 'Positive syntax tests';
                $queryArray['type']     = 'positive';

                $handle = fopen($queryFileName, "r");
                if ($handle) {
                    $queryArray['query']    = fread($handle, filesize($queryFileName));
                    fclose($handle);
                }


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

        if ($e instanceof Exception) {
            $msg .= 'Error: ' . $e->getMessage();
        } else {
            $msg .= 'Error: ' . $e;
        }

        return $msg;
    }
}



