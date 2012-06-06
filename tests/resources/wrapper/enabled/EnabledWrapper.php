<?php
require_once 'Erfurt/Wrapper.php';

class EnabledWrapper extends Erfurt_Wrapper
{
    public function getDescription()
    {
        return 'A Wrapper used for testing only.';
    }
    
    public function getName()
    {
        return 'Enabled Test Wrapper';
    }
    
    public function isAvailable($uri, $graphUri)
    {
        return true;
    }
    
    public function isHandled($uri, $graphUri)
    {
        return true;
    }
    
    public function run($uri, $graphUri)
    {
        return array();
    }
    
    
}
