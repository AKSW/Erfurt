<?php
class Erfurt_Store_Adapter_Virtuoso_ResultConverter_SparqlResultsCsvTest extends Erfurt_TestCase
{
    protected $_fixture = null;

    public function setUp()
    {
        $this->_fixture = new Erfurt_Store_Adapter_Virtuoso_ResultConverter_CSV();
    }

    public function testSimple()
    {
        $extended = array(
              0 => array(
                's' => 'http://example.org/',
                'p' => 'http://www.w3.org/1999/02/22-rdf-syntax-ns#type',
                'o' => 'http://www.w3.org/2002/07/owl#Ontology',
              ),
              1 => array(
                's' => 'http://example.org/person/1741209351',
                'p' => 'http://www.w3.org/2000/01/rdf-schema#label',
                'o' => 'äää',
              ),
        );

        $expected = <<<EOT
s,p,o
http://example.org/,http://www.w3.org/1999/02/22-rdf-syntax-ns#type,http://www.w3.org/2002/07/owl#Ontology
http://example.org/person/1741209351,http://www.w3.org/2000/01/rdf-schema#label,äää
EOT;
        $actual = $this->_fixture->convert($extended);

        $this->assertSame(
            preg_replace('/\s/', '', $expected),
            preg_replace('/\s/', '', $actual));
    }
}
