<?php
class Erfurt_Auth_Adapter_OpenIdTest extends Erfurt_TestCase
{
    public function setUp()
    {
        $this->markTestNeedsTestConfig();
    }

    public function testObjectCreation()
    {
        $instance = new Erfurt_Auth_Adapter_OpenId();
        
        $this->assertTrue($instance instanceof Erfurt_Auth_Adapter_OpenId);
    }
    
    public function testOpenIdNormalizationGithubOntoWikiIssue21()
    {
        // null openID should stay null!
        $openId = null;
        $instance = new Erfurt_Auth_Adapter_OpenId($openId);
        $this->assertInstanceOf('Erfurt_Auth_Adapter_OpenId', $instance);
        $this->assertNull($instance->getId());

        $openId = 'example.com';
        $expectedNormalized = 'http://example.com/';
        $instance = new Erfurt_Auth_Adapter_OpenId($openId);
        $this->assertInstanceOf('Erfurt_Auth_Adapter_OpenId', $instance);
        $this->assertEquals($expectedNormalized, $instance->getId());

        $openId = 'http://example.com';
        $instance = new Erfurt_Auth_Adapter_OpenId($openId);
        $this->assertInstanceOf('Erfurt_Auth_Adapter_OpenId', $instance);
        $this->assertEquals($expectedNormalized, $instance->getId());

        $openId = 'https://example.com/';
        $expectedNormalized = 'https://example.com/';
        $instance = new Erfurt_Auth_Adapter_OpenId($openId);
        $this->assertInstanceOf('Erfurt_Auth_Adapter_OpenId', $instance);
        $this->assertEquals($expectedNormalized, $instance->getId());

        $openId = 'http://example.com/user';
        $expectedNormalized = 'http://example.com/user';
        $instance = new Erfurt_Auth_Adapter_OpenId($openId);
        $this->assertInstanceOf('Erfurt_Auth_Adapter_OpenId', $instance);
        $this->assertEquals($expectedNormalized, $instance->getId());

        $openId = 'http://example.com/user/';
        $expectedNormalized = 'http://example.com/user/';
        $instance = new Erfurt_Auth_Adapter_OpenId($openId);
        $this->assertInstanceOf('Erfurt_Auth_Adapter_OpenId', $instance);
        $this->assertEquals($expectedNormalized, $instance->getId());

        $openId = 'http://example.com/';
        $expectedNormalized = 'http://example.com/';
        $instance = new Erfurt_Auth_Adapter_OpenId($openId);
        $this->assertInstanceOf('Erfurt_Auth_Adapter_OpenId', $instance);
        $this->assertEquals($expectedNormalized, $instance->getId());

        $openId = '=example';
        $expectedNormalized = '=example';
        $instance = new Erfurt_Auth_Adapter_OpenId($openId);
        $this->assertInstanceOf('Erfurt_Auth_Adapter_OpenId', $instance);
        $this->assertEquals($expectedNormalized, $instance->getId());

        $openId = 'xri://=example';
        $expectedNormalized = '=example';
        $instance = new Erfurt_Auth_Adapter_OpenId($openId);
        $this->assertInstanceOf('Erfurt_Auth_Adapter_OpenId', $instance);
        $this->assertEquals($expectedNormalized, $instance->getId());
    }

}
