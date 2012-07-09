<?php
class Erfurt_Store_Adapter_EfZendDbTest extends Erfurt_TestCase
{
    public $fixture = null;
    
    public function setUp()
    {    
        $this->markTestNeedsDatabase();
    
        $config = array(
            'dbname' => 'ow',
            'username'   => "owuser",
            'password' => 'owpass',
            'dbtype' => 'mysql'
        );
        
        $this->fixture = new Erfurt_Store_Adapter_EfZendDb($config);
    }
    
    public function testSerialization()
    {
        ob_start();
        $a = $this->fixture->sparqlQuery("SELECT * WHERE {?s ?p ?o} LIMIT 1");
        $this->fixture = unserialize(serialize($this->fixture));
        $b = $this->fixture->sparqlQuery("SELECT * WHERE {?s ?p ?o} LIMIT 1");
        $o = ob_get_contents();
        ob_end_clean();
        $this->assertTrue(empty($o)); //no warnings
    }
}
