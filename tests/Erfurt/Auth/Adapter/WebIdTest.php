<?php
require_once 'Erfurt/TestCase.php';

//require_once 'Erfurt/Auth/Adapter/WebId.php';
//require_once 'Erfurt/WebId/Consumer/Storage/Test.php';

class Erfurt_Auth_Adapter_WebIdTest extends Erfurt_TestCase
{
    private $_object = null;
    
    private $_consumerStorageTest = null;

    public function setUp()
    {
        // Certificate infos: (2048 Bit RSA)
        //   - CN: Max Tester
        //   - Email: pfrischmuth@googlemail.com
        //   - Org: AKSW
        //   - Unit: OW
        //   - City: Leipzig
        //   - State: Sachsen
        //   - Country: DE
        //   - Valid from: 2012-05-22
        //   - Valid until: 2017-11-12
        //   - SAN: URI:https://ontowiki.net/id/erfurtTestId
    
        $certData = <<<EOF
-----BEGIN CERTIFICATE-----
MIID8DCCAtigAwIBAgIBATALBgkqhkiG9w0BAQswgY0xEzARBgNVBAMMCk1heCBU
ZXN0ZXIxDTALBgNVBAoMBEFLU1cxCzAJBgNVBAsMAk9XMRAwDgYDVQQIDAdTYWNo
c2VuMQswCQYDVQQGEwJERTEQMA4GA1UEBwwHTGVpcHppZzEpMCcGCSqGSIb3DQEJ
ARYacGZyaXNjaG11dGhAZ29vZ2xlbWFpbC5jb20wHhcNMTIwNTIyMDgxMDA5WhcN
MTcxMTEyMDgxMDA5WjCBjTETMBEGA1UEAwwKTWF4IFRlc3RlcjENMAsGA1UECgwE
QUtTVzELMAkGA1UECwwCT1cxEDAOBgNVBAgMB1NhY2hzZW4xCzAJBgNVBAYTAkRF
MRAwDgYDVQQHDAdMZWlwemlnMSkwJwYJKoZIhvcNAQkBFhpwZnJpc2NobXV0aEBn
b29nbGVtYWlsLmNvbTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBANu3
i0DkzdKt/DyfSjCSRm/2aJ7Exlm3TBUaSm7oahIHZd8lihauetxHXrJt6Gm87lli
qGLOlk9OQ/1retPYouITMHVMy37PpVUzAERPMAvtotulInxiqMkM1GU/WFygpzd6
jidw0V9PsXPAPCFuVNniPgZu282RXJK0gaWYyhSIp1b3YLIUFIYzt9PwDA6pyDZk
3onFSWUNbSbezTFkqn70yZBYPSXT/TsW/I0JZF6WP78oTZ0Ck0wJ0mji69DxGTrW
5tfcKHqrdRf9uc0Ot5H51EQTS/qh3E8t7qrypKeyyFTsolkYH5Ihlx4qKKHeinLK
KkICasC+Se7uaEvIFjECAwEAAaNbMFkwDgYDVR0PAQH/BAQDAgeAMBYGA1UdJQEB
/wQMMAoGCCsGAQUFBwMCMC8GA1UdEQQoMCaGJGh0dHBzOi8vb250b3dpa2kubmV0
L2lkL2VyZnVydFRlc3RJZDANBgkqhkiG9w0BAQsFAAOCAQEAjR6XQdFtw6qTFlGW
/+5D0pnzC4o612X6F/gKkPzWjs325R5Y77Gfa5moIKan9lnOJiTtZAzzbIPolypK
GBGo6LEw9OmCoyuq2MwqPzGEv2k0hxF0ewJYlx6EaQxeJ+xsZrPGpF4y/D8uPISw
S7SEFhKL4t62/go5A4NmzqlAnp4hU4rDbGBdJ4x7KfA8W4UN/SvTG2YEiFa8bqx2
eK6/C0KYA7CW/efq0R16LZtkugZAlkwtEktmVVyzGsFAbItk47uaY1Qeiwu8PeCb
JT9zq/k3+w0SROZAS9qgz0ub7JA43yfbZ+0S7d2wq2o3m7XrUH1zfXI6/3l8J6cF
P3M7/w==
-----END CERTIFICATE-----
EOF;
        
        $webId = 'https://ontowiki.net/id/erfurtTestId';
    
        $this->_consumerStorageTest = new Erfurt_WebId_Consumer_Storage_Test();
    
        $this->_object = new Erfurt_Auth_Adapter_WebId(
            $certData,
            $this->_consumerStorageTest
        );
        
        // Set HTTP client + responses
        $adapter = new Zend_Http_Client_Adapter_Test();

        // Redirect response
        $adapter->setResponse(
            "HTTP/1.1 303 See Other\r\n" .
            "Location: /resource/export?r=" . urlencode($webId) . "\r\n" .
            "Content-Type: text/html\r\n" .
            "\r\n"
        );

        $adapter->addResponse(
            "HTTP/1.1 200 OK\r\n" .
            "Content-Type: application/rdf+xml\r\n" .
            "\r\n" .
            '<?xml version="1.0" encoding="UTF-8" ?>' . "\r\n" .
            "<rdf:RDF\r\n" .
            '  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"' . "\r\n" .
            '  xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"' . "\r\n" .
            '  xmlns:cert="http://www.w3.org/ns/auth/cert#"' . "\r\n" .
            '  xmlns:xsd="http://www.w3.org/2001/XMLSchema#"' . "\r\n" .
            '  xmlns:foaf="http://xmlns.com/foaf/0.1/">' . "\r\n" .
            '<foaf:Person rdf:about="' . $webId . '" foaf:name="Max Tester">' . "\r\n" .
            '  <foaf:mbox rdf:resource="mailto:pfrischmuth@googlemail.com" />' . "\r\n" .
            "  <cert:key>\r\n" .
            "    <cert:RSAPublicKey>\r\n" .
            '      <cert:modulus rdf:datatype="http://www.w3.org/2001/XMLSchema#hexBinary">dbb78b40e4cdd2adfc3c9f4a3092466ff6689ec4c659b74c151a4a6ee86a120765df258a16ae7adc475eb26de869bcee5962a862ce964f4e43fd6b7ad3d8a2e21330754ccb7ecfa5553300444f300beda2dba5227c62a8c90cd4653f585ca0a7377a8e2770d15f4fb173c03c216e54d9e23e066edbcd915c92b481a598ca1488a756f760b214148633b7d3f00c0ea9c83664de89c549650d6d26decd3164aa7ef4c990583d25d3fd3b16fc8d09645e963fbf284d9d02934c09d268e2ebd0f1193ad6e6d7dc287aab7517fdb9cd0eb791f9d444134bfaa1dc4f2deeaaf2a4a7b2c854eca259181f9221971e2a28a1de8a72ca2a42026ac0be49eeee684bc81631</cert:modulus>' . "\r\n" .
            '      <cert:exponent rdf:datatype="http://www.w3.org/2001/XMLSchema#integer">65537</cert:exponent>' . "\r\n" .
            "    </cert:RSAPublicKey>\r\n" .
            "  </cert:key>\r\n" .
            "</foaf:Person>\r\n" .
            '</rdf:RDF>'
        );


        $client = new Zend_Http_Client($webId, array(
            'adapter' => $adapter
        ));
        
        $this->_object->setHttpClient($client);
    }
    
    public function testAuthenticateNoAc()
    {
        $result = $this->_object->authenticate();
        
        $this->assertInstanceOf('Zend_Auth_Result', $result);
        $this->assertEquals(Zend_Auth_Result::SUCCESS, $result->getCode());
        $this->assertInstanceOf('Erfurt_Auth_Identity', $result->getIdentity());
    }
    
    public function testAuthenticateWithAc()
    {
        $ac = new Erfurt_Ac_Default();
        $this->_object->setAc($ac);
        
        $result = $this->_object->authenticate();
        $this->assertInstanceOf('Zend_Auth_Result', $result);
        $this->assertFalse($result->isValid());
    }
    
    public function testAuthenticateFailWithNoUserUri()
    {
        $this->_consumerStorageTest->setUserUriForProfileWillReturnNull(true);
        
        $result = $this->_object->authenticate();
        $this->assertInstanceOf('Zend_Auth_Result', $result);
        $this->assertFalse($result->isValid());
    }
    
    public function testAuthenticateFailLoginDeniedForUser()
    {
        $ac = new Erfurt_Ac_Test();
        $ac->setAllowedActions(array(Erfurt_Ac::ACTION_REGISTER));
        $this->_object->setAc($ac);
        
        $result = $this->_object->authenticate();
        $this->assertInstanceOf('Zend_Auth_Result', $result);
        $this->assertFalse($result->isValid());
    }
}
