<?php
class Erfurt_TestHelper_Http_ClientAdapter extends Zend_Http_Client_Adapter_Test {

    protected $requestLog = array();

    public function write($method, $uri, $http_ver = '1.1', $headers = array(), $body = '')
    {
        $this->requestLog[] = $uri;
        return parent::write($method, $uri, $http_ver, $headers, $body);
    }

    public function getLastRequestUri()
    {
        return $this->requestLog[count($this->requestLog) - 1];
    }

    public function getRequestLog()
    {
        return $this->requestLog;
    }
}
