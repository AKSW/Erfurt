<?php
class Erfurt_Syntax_RdfParser_Adapter_RdfJsonTest extends Erfurt_TestCase
{
    const SYNTAX_TEST_DIR = 'valid/';
    
    /**
     * @var Erfurt_Syntax_RdfParser_Adapter_RdfXml
     * @access protected
     */
    protected $_object = null;

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
        
        $dirName = realpath(dirname(dirname(dirname(__FILE__)))) . '/_files/' . self::SYNTAX_TEST_DIR;
        if (is_readable($dirName)) {
            $dirIterator = new DirectoryIterator($dirName);
            
            foreach ($dirIterator as $file) {
                if (!$file->isDot() && !$file->isDir()) {
                    $fileName = $file->getFileName();
                    
                    if ((substr($fileName, -5) === '.json') && is_readable($dirName . $fileName)) {
                        $dataArray[] = array(($dirName . $fileName));
                    }
                }
            }
        }
        
        return $dataArray;
    }
    
    public function testCorrectness()
    {
        $triples = array(
            'http://example.com/s' => array(
                'http://example.com/p' => array(
                    array(
                        'type' => 'uri',
                        'value'=> 'http://example.com/o'
                    )
                )
            )
        );
        $json = json_encode($triples);
        $result = $this->_object->parseFromDataString($json); //decode
        $this->assertEquals($triples, $result);
    }
}
