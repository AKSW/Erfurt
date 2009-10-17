<?php

require_once 'Erfurt/TestCase.php';
require_once 'Erfurt/Uri.php';

class Erfurt_UriTest extends Erfurt_TestCase
{
    public function testCheck()
    {
        $validUris = array(
            'http://example.com/Test', 
            'urn:isbn:978-3-86680-192-9', 
            'ftp://ftp.is.co.za/rfc/rfc1808.txt', 
            'gopher://spinaltap.micro.umn.edu/00/Weather/California/Los%20Angeles', 
            'http://www.math.uio.no/faq/compression-faq/part1.html', 
            'mailto:mduerst@ifi.unizh.ch', 
            'news:comp.infosystems.www.servers.unix', 
            'telnet://melvyl.ucop.edu/', 
            'http://User:pass@example.com/test/cat?foo=ba%7C'
        );
        
        foreach ($validUris as $uri) {
            $this->assertEquals(true, Erfurt_Uri::check($uri));
        }
        
        $invalidUris = array(
            'Literal value', 
            'http://example.com /Test', 
            "http://example.com/T\nest", 
            'http://example.[com]/{test}/cat?foo=ba%7C'
        );
        
        foreach ($invalidUris as $uri) {
            $this->assertEquals(false, Erfurt_Uri::check($uri));
        }
    }
    
    public function testNormalize()
    {
        $uri        = 'HTtP://User:pA:897@ExaMPLe.COM/test/cat?foo=ba%7C';
        $normalized = 'http://User:pA:897@example.com/test/cat?foo=ba%7C';
        
        $this->assertEquals($normalized, Erfurt_Uri::normalize($uri));
    }
    
    public function testNormalizeWithNonUri()
    {
        $this->setExpectedException('Erfurt_Uri_Exception');
        
        $nonUri = "HTtP://User:pA:89\t7@ExaMPLe.COM/test/cat?foo=ba%7C";
        Erfurt_Uri::normalize($nonUri);
    }
}

