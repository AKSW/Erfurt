<?php
require_once 'Erfurt/TestCase.php';
require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfJson.php';

class Erfurt_Syntax_RdfParser_Adapter_RdfJsonTest extends Erfurt_TestCase
{
    const SYNTAX_TEST_DIR = 'resources/syntax/valid/';
    
    /**
     * @var Erfurt_Syntax_RdfParser_Adapter_RdfXml
     * @access protected
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->_object = new Erfurt_Syntax_RdfParser_Adapter_RdfJson();    
    }
    
    /**
     * @dataProvider providerTestParseFromFileName
     */
    public function testParseFromFileName($fileName)
    {   
        $fileHandle = fopen($fileName, 'r');
        $data = fread($fileHandle, filesize($fileName));
        fclose($fileHandle);
        
        try {
            $result = $this->_object->parseFromDataString($data);
            $this->assertTrue(is_array($result));
        } catch (Erfurt_Syntax_RdfParserException $e) {
            $this->fail($e->getMessage());
        }
    }
    
    public function providerTestParseFromFileName()
    {
        $dataArray = array();
        
        if (is_readable(self::SYNTAX_TEST_DIR)) {
            $dirIterator = new DirectoryIterator(self::SYNTAX_TEST_DIR);
            
            foreach ($dirIterator as $file) {
                if (!$file->isDot() && !$file->isDir()) {
                    $fileName = $file->getFileName();
                    
                    if ((substr($fileName, -5) === '.json') && is_readable(self::SYNTAX_TEST_DIR . $fileName)) {
                        $dataArray[] = array((self::SYNTAX_TEST_DIR . $fileName));
                    }
                }
            }
        }
        
        return $dataArray;
    }
}
