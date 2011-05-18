<?php
require_once 'Erfurt/TestCase.php';
require_once 'Erfurt/Store/Adapter/Virtuoso.php';

class Erfurt_Store_Adapter_VirtuosoTest extends Erfurt_TestCase
{
    public $fixture = null;
    
    public function setUp()
    {   
        // $this->markTestNeedsVirtuoso();
        // $config = $this->getTestConfig()->store->virtuoso->toArray();
        
        $config = array(
            'dsn' => 'VOS',
            'username' => 'dba',
            'password' => 'dba'
        );
        
        $this->fixture = new Erfurt_Store_Adapter_Virtuoso($config);
    }
    
    public function testInstantiation()
    {
        $this->assertSame('Erfurt_Store_Adapter_Virtuoso', get_class($this->fixture));
    }
    
    public function testListTables()
    {
        $this->assertEquals(true, in_array('RDF_QUAD', $this->fixture->listTables()));
    }
    
    public function testAddStatementWithUriObject()
    {
        $g = 'http://example.com/';
        $s = 'http://example.com/';
        $p = 'http://example.com/property1';
        
        $oSpec = array(
            'value' => 'http:/example.com/resource1', 
            'type' => 'uri'
        );
        
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $oSpec));
    }
    
    public function testAddStatementsWithLiteralObject()
    {
        $g = 'http://example.com/';
        $s = 'http://example.com/';
        $p = 'http://example.com/property1';
        
        require_once 'Erfurt/Store.php';
        $options = array();
        $o = array('type' => 'literal');
        
        // short literal
        $o['value'] = 'short literal';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // short literal containing double quote
        $o['value'] = 'short "literal"';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // short literal containing escaped double quote
        $o['value'] = 'short \"literal\"';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // short literal containing single quote
        $o['value'] = "short 'literal'";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // short literal containing escaped single quote
        $o['value'] = "short \'literal\'";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // long literal 1
        $o['value'] = "long \n literal 1";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // long literal 2
        $o['value'] = "long
        literal 2";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // long literal 3
        $o['value'] = "long \r\n literal 2";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // Unix path literal
        $o['value'] = '/usr/local/bin/virtuoso-t';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // Windows path literal
        $o['value'] = "C:\\\\Programme\\\\Conficker\\\\FormatHardDrive.exe";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // Windows path literal
        $o['value'] = '"C:\\\\Program Files\\\\Conficker\\\\FormatHardDrive.exe"';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        
        // boolean literal with numerical representation
        $o['value']  = '1';
        $p2 = 'http://example.com/booleanProperty1';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p2, $o, array_merge(
            $options, 
            array('literal_datatype' => 'http://www.w3.org/2001/XMLSchema#boolean'))));
        
        // boolean literal with string representation
        $o['value']  = 'true';
        $p2 = 'http://example.com/booleanProperty2';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p2, $o, array_merge(
            $options, 
            array('literal_datatype' => 'http://www.w3.org/2001/XMLSchema#boolean'))));
        
        
        // Vakantieland tests
        
        // vakantieland string 1 (unescaped)
        $o['value'] = 'verhuisd onder ? dak, nu "Apeldoorns Museum"';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // vakantieland string 1 (escaped) -- Virtuoso will remove escaping
        $o['value'] = 'verhuisd onder ? dak, nu \"Apeldoorns Museum\"';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // vakantieland string 2
        $o['value'] = "per persoon: 113.45 &euro;<br/>CJP: 0 &euro;";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // vakantieland string 3
        $o['value'] = "van.reekum";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // vakantieland string 4
        $o['value'] = "http://www.apeldoorn.org/vanreekum/";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // vakantieland string 5
        $o['value'] = '"In de Tinnen Wonderwereld" is niet langer wegens het overlijden van E. Spandauw (5-10-2000), de oprichter en uitbater van het museum. http://members.tripod.com/~tingieten/';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
    }
    
    public function testBuildLiteralString()
    {
        $value    = 'Literal';
        $datatype = 'http://www.w3.org/2001/XMLSchema#string';
        $expected = '"""Literal"""^^<http://www.w3.org/2001/XMLSchema#string>';
        $this->assertEquals($expected, $this->fixture->buildLiteralString($value, $datatype, null));
        
        $value    = "Literal \n with newline";
        $datatype = 'http://www.w3.org/2001/XMLSchema#string';
        $expected = "\"\"\"Literal \n with newline\"\"\"^^<http://www.w3.org/2001/XMLSchema#string>";
        $this->assertEquals($expected, $this->fixture->buildLiteralString($value, $datatype, null));
        
        $value    = 'Literal';
        $lang     = 'de';
        $expected = '"""Literal"""@de';
        $this->assertEquals($expected, $this->fixture->buildLiteralString($value, null, $lang));
        
        $value    = <<<EOT
Over the past 3 years, the semantic web activity has gained momentum with the widespread publishing of structured data as RDF. The Linked Data paradigm has therefore evolved from a practical research idea into a very promising candidate for addressing one of the biggest challenges in the area of intelligent information management: the exploitation of the Web as a platform for data and information integration in addition to document search. To translate this initial success into a world-scale disruptive reality, encompassing the Web 2.0 world and enterprise data alike, the following research challenges need to be addressed: improve coherence and quality of data published on the Web, close the performance gap between relational and RDF data management, establish trust on the Linked Data Web and generally lower the entrance barrier for data publishers and users. With partners among those who initiated and strongly supported the Linked Open Data initiative, the LOD2 project aims at tackling these challenges by developing:
<ol>
<li>enterprise-ready tools and methodologies for exposing and managing very large amounts of structured information on the Data Web,</li>
<li>a testbed and bootstrap network of high-quality multi-domain, multi-lingual ontologies from sources such as Wikipedia and OpenStreetMap.</li>
<li>algorithms based on machine learning for automatically interlinking and fusing data from the Web.</li>
<li>standards and methods for reliably tracking provenance, ensuring privacy and data security as well as for assessing the quality of information.</li>
<li>adaptive tools for searching, browsing, and authoring of Linked Data.</li>
</ol>
We will integrate and syndicate linked data with large-scale, existing applications and showcase the benefits in the three application scenarios of media & publishing, corporate data intranets and eGovernment. The resulting tools, methods and data sets have the potential to change the Web as we know it today.
EOT;
        $expected = <<<EOT
"""Over the past 3 years, the semantic web activity has gained momentum with the widespread publishing of structured data as RDF. The Linked Data paradigm has therefore evolved from a practical research idea into a very promising candidate for addressing one of the biggest challenges in the area of intelligent information management: the exploitation of the Web as a platform for data and information integration in addition to document search. To translate this initial success into a world-scale disruptive reality, encompassing the Web 2.0 world and enterprise data alike, the following research challenges need to be addressed: improve coherence and quality of data published on the Web, close the performance gap between relational and RDF data management, establish trust on the Linked Data Web and generally lower the entrance barrier for data publishers and users. With partners among those who initiated and strongly supported the Linked Open Data initiative, the LOD2 project aims at tackling these challenges by developing:
<ol>
<li>enterprise-ready tools and methodologies for exposing and managing very large amounts of structured information on the Data Web,</li>
<li>a testbed and bootstrap network of high-quality multi-domain, multi-lingual ontologies from sources such as Wikipedia and OpenStreetMap.</li>
<li>algorithms based on machine learning for automatically interlinking and fusing data from the Web.</li>
<li>standards and methods for reliably tracking provenance, ensuring privacy and data security as well as for assessing the quality of information.</li>
<li>adaptive tools for searching, browsing, and authoring of Linked Data.</li>
</ol>
We will integrate and syndicate linked data with large-scale, existing applications and showcase the benefits in the three application scenarios of media & publishing, corporate data intranets and eGovernment. The resulting tools, methods and data sets have the potential to change the Web as we know it today."""
EOT;
        $this->assertEquals($expected, $this->fixture->buildLiteralString($value));
    }
    
    public function testBuildTripleString()
    {
        $statements = array(
            'http://example.com/1' => array(
                'http://example.com/2' => array(
                    array('type' => 'uri', 'value' => 'http://example.com/3'), 
                    array('type' => 'literal', 'value' => 'literal 1'), 
                    array('type' => 'literal', 'value' => 'literal 2', 'lang' => 'en'), 
                    array('type' => 'literal', 'value' => 'literal 3', 'datatype' => 'http://example.com/4'), 
                    array('type' => 'literal', 'value' => "literal\n4")
                )
            )
        );
        $expected = <<<EOT
<http://example.com/1> <http://example.com/2> <http://example.com/3> .
<http://example.com/1> <http://example.com/2> """literal 1""" .
<http://example.com/1> <http://example.com/2> """literal 2"""@en .
<http://example.com/1> <http://example.com/2> "literal 3"^^<http://example.com/4> .
<http://example.com/1> <http://example.com/2> """literal\n4""" .

EOT;
        $this->assertEquals($expected, $this->fixture->buildTripleString($statements));
        
        $value    = <<<EOT
Over the past 3 years, the semantic web activity has gained momentum with the widespread publishing of structured data as RDF. The Linked Data paradigm has therefore evolved from a practical research idea into a very promising candidate for addressing one of the biggest challenges in the area of intelligent information management: the exploitation of the Web as a platform for data and information integration in addition to document search. To translate this initial success into a world-scale disruptive reality, encompassing the Web 2.0 world and enterprise data alike, the following research challenges need to be addressed: improve coherence and quality of data published on the Web, close the performance gap between relational and RDF data management, establish trust on the Linked Data Web and generally lower the entrance barrier for data publishers and users. With partners among those who initiated and strongly supported the Linked Open Data initiative, the LOD2 project aims at tackling these challenges by developing:
<ol>
<li>enterprise-ready tools and methodologies for exposing and managing very large amounts of structured information on the Data Web,</li>
<li>a testbed and bootstrap network of high-quality multi-domain, multi-lingual ontologies from sources such as Wikipedia and OpenStreetMap.</li>
<li>algorithms based on machine learning for automatically interlinking and fusing data from the Web.</li>
<li>standards and methods for reliably tracking provenance, ensuring privacy and data security as well as for assessing the quality of information.</li>
<li>adaptive tools for searching, browsing, and authoring of Linked Data.</li>
</ol>
We will integrate and syndicate linked data with large-scale, existing applications and showcase the benefits in the three application scenarios of media & publishing, corporate data intranets and eGovernment. The resulting tools, methods and data sets have the potential to change the Web as we know it today.
EOT;
        $statements2 = array(
            'http://example.com/1' => array(
                'http://example.com/2' => array(
                    array('type' => 'literal', 'value' => $value)
                )
            )
        );
        $expected2 = <<<EOT
<http://example.com/1> <http://example.com/2> """Over the past 3 years, the semantic web activity has gained momentum with the widespread publishing of structured data as RDF. The Linked Data paradigm has therefore evolved from a practical research idea into a very promising candidate for addressing one of the biggest challenges in the area of intelligent information management: the exploitation of the Web as a platform for data and information integration in addition to document search. To translate this initial success into a world-scale disruptive reality, encompassing the Web 2.0 world and enterprise data alike, the following research challenges need to be addressed: improve coherence and quality of data published on the Web, close the performance gap between relational and RDF data management, establish trust on the Linked Data Web and generally lower the entrance barrier for data publishers and users. With partners among those who initiated and strongly supported the Linked Open Data initiative, the LOD2 project aims at tackling these challenges by developing:
<ol>
<li>enterprise-ready tools and methodologies for exposing and managing very large amounts of structured information on the Data Web,</li>
<li>a testbed and bootstrap network of high-quality multi-domain, multi-lingual ontologies from sources such as Wikipedia and OpenStreetMap.</li>
<li>algorithms based on machine learning for automatically interlinking and fusing data from the Web.</li>
<li>standards and methods for reliably tracking provenance, ensuring privacy and data security as well as for assessing the quality of information.</li>
<li>adaptive tools for searching, browsing, and authoring of Linked Data.</li>
</ol>
We will integrate and syndicate linked data with large-scale, existing applications and showcase the benefits in the three application scenarios of media & publishing, corporate data intranets and eGovernment. The resulting tools, methods and data sets have the potential to change the Web as we know it today.""" .

EOT;

        $this->assertEquals($expected2, $this->fixture->buildTripleString($statements2));
    }
}

