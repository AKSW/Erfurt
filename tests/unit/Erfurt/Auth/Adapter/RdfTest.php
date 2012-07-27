<?php
class Erfurt_Auth_Adapter_RdfTest extends Erfurt_TestCase
{
    public function testObjectCreation()
    {
        $instance = new Erfurt_Auth_Adapter_Rdf();
        
        $this->assertTrue($instance instanceof Erfurt_Auth_Adapter_Rdf);
    }
    
    public function testAuthenticateAnonymous()
    {
        $instance = new Erfurt_Auth_Adapter_Rdf('Anonymous');
        $result = $instance->authenticate();
        $id = $result->getIdentity();

        $this->assertTrue($result->isValid());
        $this->assertEquals('Anonymous', $id->getUsername());
        $this->assertTrue($id->isAnonymousUser());
    }
}
