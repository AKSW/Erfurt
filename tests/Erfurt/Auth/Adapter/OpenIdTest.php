<?php
require_once 'Erfurt/TestCase.php';

require_once 'Erfurt/Auth/Adapter/OpenId.php';

class Erfurt_Auth_AdapterOPenIdTest extends Erfurt_TestCase
{
    public function testObjectCreation()
    {
        $instance = new Erfurt_Auth_Adapter_OpenId();
        
        $this->assertTrue($instance instanceof Erfurt_Auth_Adapter_OpenId);
    }
}