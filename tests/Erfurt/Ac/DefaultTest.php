<?php
require_once 'Erfurt/TestCase.php';

require_once 'Erfurt/Ac/Default.php';

class Erfurt_Ac_DefaultTest extends Erfurt_TestCase
{
    private $_object = null;

    public function setUp()
    {
        $this->_object = new Erfurt_Ac_Default();
    }
    
    public function testObjectCreation()
    {
        $object = new Erfurt_Ac_Default();
    }
    
    public function testSetUser()
    {
        $identityObject = new Erfurt_Auth_Identity(array(
            'username'  => 'SuperAdmin',
            'uri'       => Erfurt_Auth::SUPERADMIN_USER,
            'anonymous' => false,
            'dbuser'    => true,
            'email'     => ''
        ));
        
        $this->assertNotEquals($identityObject, $this->_object->getUser());
        $this->_object->setUser($identityObject);
        $this->assertEquals($identityObject, $this->_object->getUser());
    }
    
    public function testSetDefaultActionConfig()
    {
        $this->_object->setDefaultActionConfig(array()); // empty default config, such that e.g. LOGIN does not exist anymore
        
        $result = $this->_object->isActionAllowed(Erfurt_Ac::ACTION_LOGIN);
        $this->assertFalse($result);
    }
    
    public function testGetUserNoPreviousSetUser()
    {
        $identity = $this->_object->getUser();
        $this->assertInstanceOf('Erfurt_Auth_Identity', $identity);
    }
    
    public function testGetUserWithPreviousSetUser()
    {
        $identityObject = new Erfurt_Auth_Identity(array(
            'username'  => 'SuperAdmin',
            'uri'       => Erfurt_Auth::SUPERADMIN_USER,
            'anonymous' => false,
            'dbuser'    => true,
            'email'     => ''
        ));
        
        $this->_object->setUser($identityObject);
        $acIdentity = $this->_object->getUser();
        $this->assertInstanceOf('Erfurt_Auth_Identity', $acIdentity);
        $this->assertEquals($identityObject, $acIdentity);
    }
    
    public function testIsActionAllowedNoUserRights()
    {
        $result = $this->_object->isActionAllowed(Erfurt_Ac::ACTION_LOGIN);
        $this->assertFalse($result);
    }
    
    public function testIsActionAllowedEmptyDefaultUserRights()
    {   
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isActionAllowed(Erfurt_Ac::ACTION_LOGIN);
        $this->assertFalse($result);
    }
    
    public function testIsActionAllowedAnyActionAllowed()
    {
        // any action allowed
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => true,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isActionAllowed(Erfurt_Ac::ACTION_LOGIN);
        $this->assertTrue($result, 'If any action is allowed also login action should be allowed.');
    }
    
    public function testIsActionAllowedSpecificActionAllowed()
    {
        // only LOGIN_ACTION allowed
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(Erfurt_Ac::ACTION_LOGIN),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isActionAllowed(Erfurt_Ac::ACTION_LOGIN);
        $this->assertTrue($result);
    }
    
    public function testIsActionAllowedSpecificActionAllowedAndDisallowed()
    {
        // only LOGIN_ACTION allowed and disalowed
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(Erfurt_Ac::ACTION_LOGIN),
                Erfurt_Ac::AC_DENY_ACCESS            => array(Erfurt_Ac::ACTION_LOGIN),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isActionAllowed(Erfurt_Ac::ACTION_LOGIN);
        $this->assertFalse($result);
    }
    
    public function testIsActionAllowedWithInvalidNoUriAction()
    {
        $result = $this->_object->isActionAllowed('someInvalidActionThatisNotAUri', false);
        $this->assertFalse($result);
    }
    
    public function testIsActionAllowedWithInvalidActionAutoAddAndWithStore()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $actionUri = 'http://example.org/someNewAction';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        
        $this->_object->setStore($store);
        
        $result = $this->_object->isActionAllowed($actionUri);
        $this->assertFalse($result);
        
        $newStatements = $storeAdapter->getStatementsForGraph($acGraphUri);
        $this->assertTrue(isset($newStatements[$actionUri]));
    }
    
    public function testIsActionAllowedWithInvalidActionNoUriAutoAddAndWithStore()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $action = 'someNewAction';
        $actionUri = 'http://ns.ontowiki.net/SysOnt/' . $action;
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        
        $this->_object->setStore($store);
        
        $result = $this->_object->isActionAllowed($action, false);
        $this->assertFalse($result);
        
        $newStatements = $storeAdapter->getStatementsForGraph($acGraphUri);
        $this->assertTrue(isset($newStatements[$actionUri]));
    }
    
    public function testIsActionAllowedWithStoreAndActionFromStore()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $actionUri = 'http://example.org/someNewAction';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array(
            array(
                's' => 'http://example.org/someCustomActionXyz',
                'o' => 'someKey=someValue'
            ),
            array(
                's' => 'http://example.org/someCustomActionXyz',
                'o' => 'someKey2="someValue2"'
            ),
            array(
                's' => 'http://example.org/someCustomActionAbc',
                'o' => 'someKey3=someValue3'
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isActionAllowed($actionUri);
        $this->assertFalse($result);
        
        $newStatements = $storeAdapter->getStatementsForGraph($acGraphUri);
        $this->assertTrue(isset($newStatements[$actionUri]));
    }
    
    public function testIsActionAllowedWithStoreGroupAllowed()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $actionUri = 'http://example.org/someCustomActionXyz';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array(
            array(
                's' => $actionUri,
                'o' => 'someKey=someValue'
            ),
            array(
                's' => $actionUri,
                'o' => 'someKey2="someValue2"'
            )
        ));
        $storeAdapter->addQueryResult(array(
            array(
                'group' => 'http://example.org/groupXyz',
                'p'     => 'http://ns.ontowiki.net/SysOnt/grantAccess',
                'o'     => $actionUri
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isActionAllowed($actionUri);
        $this->assertTrue($result);
    }
    
    public function testIsActionAllowedWithStoreUserAllowed()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $actionUri = 'http://example.org/someCustomActionXyz';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array(
            array(
                's' => $actionUri,
                'o' => 'someKey=someValue'
            ),
            array(
                's' => $actionUri,
                'o' => 'someKey2="someValue2"'
            )
        ));
        $storeAdapter->addQueryResult(array()); // group query
        $storeAdapter->addQueryResult(array(
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/grantAccess',
                'o'     => $actionUri
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isActionAllowed($actionUri);
        $this->assertTrue($result);
    }
    
    public function testIsActionAllowedWithStoreAnyActionAllowed()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $actionUri = 'http://example.org/someCustomActionXyz';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array(
            array(
                's' => $actionUri,
                'o' => 'someKey=someValue'
            ),
            array(
                's' => $actionUri,
                'o' => 'someKey2="someValue2"'
            )
        ));
        $storeAdapter->addQueryResult(array()); // group query
        $storeAdapter->addQueryResult(array(
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/grantAccess',
                'o'     => 'http://ns.ontowiki.net/SysOnt/AnyAction'
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isActionAllowed($actionUri);
        $this->assertTrue($result);
    }
    
    public function testIsActionAllowedWithStoreAnyActionDenies()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $actionUri = 'http://example.org/someCustomActionXyz';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array(
            array(
                's' => $actionUri,
                'o' => 'someKey=someValue'
            ),
            array(
                's' => $actionUri,
                'o' => 'someKey2="someValue2"'
            )
        ));
        $storeAdapter->addQueryResult(array()); // group query
        $storeAdapter->addQueryResult(array(
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/denyAccess',
                'o'     => 'http://ns.ontowiki.net/SysOnt/AnyAction'
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isActionAllowed($actionUri);
        $this->assertFalse($result);
    }
    
    public function testIsActionAllowedWithStoreActionDenied()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $actionUri = 'http://example.org/someCustomActionXyz';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array(
            array(
                's' => $actionUri,
                'o' => 'someKey=someValue'
            ),
            array(
                's' => $actionUri,
                'o' => 'someKey2="someValue2"'
            )
        ));
        $storeAdapter->addQueryResult(array()); // group query
        $storeAdapter->addQueryResult(array(
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/denyAccess',
                'o'     => $actionUri
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isActionAllowed($actionUri);
        $this->assertFalse($result);
    }
    
    public function testIsActionAllowedWithSuperUserNoDbUserAllowed()
    {        
        $identityObject = new Erfurt_Auth_Identity(array(
            'username'  => 'SuperAdmin',
            'uri'       => Erfurt_Auth::SUPERADMIN_USER,
            'anonymous' => false,
            'dbuser'    => true,
            'email'     => ''
        ));
        $this->_object->setUser($identityObject);
        
        $result = $this->_object->isActionAllowed(Erfurt_Ac::ACTION_LOGIN);
        $this->assertFalse($result);
    }
    
    public function testIsActionAllowedWithSuperUserValidAction()
    {
        $object = new Erfurt_Ac_Default(array(
            'allowDbUser' => true
        ));
        
        $identityObject = new Erfurt_Auth_Identity(array(
            'username'  => 'SuperAdmin',
            'uri'       => Erfurt_Auth::SUPERADMIN_USER,
            'anonymous' => false,
            'dbuser'    => true,
            'email'     => ''
        ));
        $object->setUser($identityObject);
        
        $result = $object->isActionAllowed(Erfurt_Ac::ACTION_LOGIN);
        $this->assertTrue($result);
    }
    
    public function testIsActionAllowedWithSuperUserInvalidAction()
    {
        $object = new Erfurt_Ac_Default(array(
            'allowDbUser' => true
        ));
        
        $identityObject = new Erfurt_Auth_Identity(array(
            'username'  => 'SuperAdmin',
            'uri'       => Erfurt_Auth::SUPERADMIN_USER,
            'anonymous' => false,
            'dbuser'    => true,
            'email'     => ''
        ));
        $object->setUser($identityObject);
        
        $result = $this->_object->isActionAllowed('http://exmaple.org/someNonExistingActionXyz');
        $this->assertFalse($result);
    }
    
    public function testIsAnyActionAllowedNoUserRights()
    {
        $result = $this->_object->isAnyActionAllowed();
        $this->assertFalse($result);
    }
    
    public function testIsAnyActionAllowedEmptyDefaultUserRights()
    {
        // any action allowed
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
    
        $result = $this->_object->isAnyActionAllowed();
        $this->assertFalse($result);
    }
    
    public function testIsAnyActionAllowedAnyActionAllowed()
    {
        // any action allowed
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => true,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
    
        $result = $this->_object->isAnyActionAllowed();
        $this->assertTrue($result);
    }
    
    public function testIsAnyModelAllowedViewNoActionAllowed()
    {
        $result = $this->_object->isAnyModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW);
        $this->assertFalse($result);
    }
    
    public function testIsAnyModelAllowedEditNoActionAllowed()
    {
        $result = $this->_object->isAnyActionAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT);
        $this->assertFalse($result);
    }
    
    public function testIsAnyModelAllowedViewEmptyDefaultUserRights()
    {
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
    
        $result = $this->_object->isAnyModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW);
        $this->assertFalse($result);
    }
    
    public function testIsAnyModelAllowedEditEmptyDefaultUserRights()
    {
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isAnyModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT);
        $this->assertFalse($result);
    }
    
    public function testIsAnyModelAllowedViewAnyModelViewAllowed()
    {
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => true,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isAnyModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW);
        $this->assertTrue($result);
    }
    
    public function testIsAnyModelAllowedViewAnyModelEditAllowed()
    {
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => true,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isAnyModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW);
        $this->assertTrue($result);
    }
    
    public function testIsAnyModelAllowedEditAnyModelViewAllowed()
    {
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => true,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isAnyModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT);
        $this->assertFalse($result);
    }
    
    public function testIsAnyModelAllowedEditAnyModelEditAllowed()
    {
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => true,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isAnyModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT);
        $this->assertTrue($result);
    }
    
    public function testIsAnyModelAllowedInvalidType()
    {
        $result = $this->_object->isAnyModelAllowed('somethingInvalid123');
        $this->assertFalse($result);
    }
    
    public function testIsModelAllowedViewNoUserRights()
    {
        $graphUri = 'http://example.org/testModel1';
            
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW, $graphUri);
        $this->assertFalse($result);
    }
    
    public function testIsModelAllowedEditNoUserRights()
    {
        $graphUri = 'http://example.org/testModel1';
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT, $graphUri);
        $this->assertFalse($result);
    }
    
    public function testIsModelAllowedViewEmptyDefaultUserRights()
    {
        $graphUri = 'http://example.org/testModel1';
        
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW, $graphUri);
        $this->assertFalse($result);
    }
    
    public function testIsModelAllowedEditEmptyDefaultUserRights()
    {
        $graphUri = 'http://example.org/testModel1';
        
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT, $graphUri);
        $this->assertFalse($result);
    }
    
    public function testIsModelAllowedViewAnyModelViewAllowed()
    {
        $graphUri = 'http://example.org/testModel1';
        
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => true,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW, $graphUri);
        $this->assertTrue($result);
    }
    
    public function testIsModelAllowedViewAnyModelEditAllowed()
    {
        $graphUri = 'http://example.org/testModel1';
        
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => true,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW, $graphUri);
        $this->assertTrue($result);
    }
    
    public function testIsModelAllowedEditAnyModelEditAllowed()
    {
        $graphUri = 'http://example.org/testModel1';
        
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => true,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT, $graphUri);
        $this->assertTrue($result);
    }
    
    public function testIsModelAllowedViewSpecificModelViewAllowed()
    {
        $graphUri = 'http://example.org/testModel1';
        
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array($graphUri),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW, $graphUri);
        $this->assertTrue($result);
    }
    
    public function testIsModelAllowedViewSpecificModelEditAllowed()
    {
        $graphUri = 'http://example.org/testModel1';
        
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array($graphUri),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW, $graphUri);
        $this->assertTrue($result);
    }
    
    public function testIsModelAllowedEditSpecificModelViewAllowed()
    {
        $graphUri = 'http://example.org/testModel1';
        
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array($graphUri),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT, $graphUri);
        $this->assertFalse($result);
    }
    
    public function testIsModelAllowedEditSpecificModelEditAllowed()
    {
        $graphUri = 'http://example.org/testModel1';
        
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array($graphUri),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT, $graphUri);
        $this->assertTrue($result);
    }
    
    public function testIsModelAllowedViewSpecificModelViewAllowedAndDisallowed()
    {
        $graphUri = 'http://example.org/testModel1';
        
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array($graphUri),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array($graphUri),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
            )
        ));
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW, $graphUri);
        $this->assertFalse($result);
    }
    
    public function testIsModelAllowedEditSpecificModelEditAllowedAndDisallowed()
    {
        $graphUri = 'http://example.org/testModel1';
        
        $this->_object->setDefaultUserRights(array(
            Erfurt_Auth::ANONYMOUS_USER => array(
                Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
                Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
                Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
                Erfurt_Ac::AC_GRANT_ACCESS           => array(),
                Erfurt_Ac::AC_DENY_ACCESS            => array(),
                Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
                Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
                Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array($graphUri),
                Erfurt_Ac::AC_DENY_MODEL_EDIT        => array($graphUri)
            )
        ));
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT, $graphUri);
        $this->assertFalse($result);
    }
    
    public function testIsModelAllowedViewWithStoreModelAllowed()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $graphUri = 'http://example.org/someGraph';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array()); // action query
        $storeAdapter->addQueryResult(array(
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/grantModelView',
                'o'     => $graphUri
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW, $graphUri);
        $this->assertTrue($result);
    }
    
    public function testIsModelAllowedEditWithStoreModelAllowed()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $graphUri = 'http://example.org/someGraph';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array()); // action query
        $storeAdapter->addQueryResult(array(
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/grantModelEdit',
                'o'     => $graphUri
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT, $graphUri);
        $this->assertTrue($result);
    }
    
    public function testIsModelAllowedViewWithStoreModelDenied()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $graphUri = 'http://example.org/someGraph';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array()); // action query
        $storeAdapter->addQueryResult(array(
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/denyModelView',
                'o'     => $graphUri
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW, $graphUri);
        $this->assertFalse($result);
    }
    
    public function testIsModelAllowedEditWithStoreModelDenied()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $graphUri = 'http://example.org/someGraph';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array()); // action query
        $storeAdapter->addQueryResult(array(
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/denyModelEdit',
                'o'     => $graphUri
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT, $graphUri);
        $this->assertFalse($result);
    }
    
    public function testIsModelAllowedViewWithStoreAnyModelAllowed()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $anyModelUri = 'http://ns.ontowiki.net/SysOnt/AnyModel';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array()); // action query
        $storeAdapter->addQueryResult(array(
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/grantModelView',
                'o'     => $anyModelUri
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW, $anyModelUri);
        $this->assertTrue($result);
    }
    
    public function testIsModelAllowedEditWithStoreAnyModelAllowed()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $anyModelUri = 'http://ns.ontowiki.net/SysOnt/AnyModel';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array()); // action query
        $storeAdapter->addQueryResult(array(
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/grantModelEdit',
                'o'     => $anyModelUri
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT, $anyModelUri);
        $this->assertTrue($result);
    }
    
    public function testIsModelAllowedViewWithStoreAnyModelDenied()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $someGraphUri = 'http://example.org/someGraph';
        $anyModelUri = 'http://ns.ontowiki.net/SysOnt/AnyModel';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array()); // action query
        $storeAdapter->addQueryResult(array(
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/grantModelView',
                'o'     => $someGraphUri
            ),
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/denyModelView',
                'o'     => $anyModelUri
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW, $someGraphUri);
        $this->assertFalse($result);
    }
    
    public function testIsModelAllowedEditWithStoreAnyModelDenied()
    {
        $acGraphUri = 'http://localhost/OntoWiki/Config/';
        $someGraphUri = 'http://example.org/someGraph';
        $anyModelUri = 'http://ns.ontowiki.net/SysOnt/AnyModel';
        
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $storeAdapter->addQueryResult(array()); // action query
        $storeAdapter->addQueryResult(array(
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/grantModelEdit',
                'o'     => $someGraphUri
            ),
            array(
                'p'     => 'http://ns.ontowiki.net/SysOnt/denyModelEdit',
                'o'     => $anyModelUri
            )
        ));
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);
        
        $result = $this->_object->isModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT, $someGraphUri);
        $this->assertFalse($result);
    }
    
    public function testGetActionConfigActionLogin()
    {
        $result = $this->_object->getActionConfig(Erfurt_Ac::ACTION_LOGIN);
        $this->assertTrue(is_array($result));
        $this->assertTrue(count($result) > 0);
    }
    
    public function testGetActionConfigNewActionNoUri()
    {
        $result = $this->_object->getActionConfig('someNewActionNoUri', false);
        $this->assertFalse($result);
    }
    
    public function testAddUserModelRuleWrongType()
    {
        $modelUri = 'http://example.org/exampleModel';
        
        $this->setExpectedException('Erfurt_Ac_Exception');
        $this->_object->addUserModelRule($modelUri, 'somethingXyz', 'somethingXyz');
    }
    
    public function testAddUserModelRuleWrongPermission()
    {
        $modelUri = 'http://example.org/exampleModel';
        
        $this->setExpectedException('Erfurt_Ac_Exception');
        $this->_object->addUserModelRule($modelUri, Erfurt_Ac::ACCESS_TYPE_VIEW, 'somethingXyz');
    }
    
    public function testAddUserModelRuleNoStore()
    {
        $modelUri = 'http://example.org/exampleModel';

        $result = $this->_object->addUserModelRule($modelUri, Erfurt_Ac::ACCESS_TYPE_VIEW, Erfurt_Ac::ACCESS_PERM_GRANT);
        $this->assertFalse($result);
    }
    
    public function testAddUserModelRuleWithStoreGrantView()
    {
        $modelUri = 'http://example.org/exampleModel';
        
        $acGraphUri = 'http://localhost/OntoWiki/Config/';    
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);

        $result = $this->_object->addUserModelRule($modelUri, Erfurt_Ac::ACCESS_TYPE_VIEW, Erfurt_Ac::ACCESS_PERM_GRANT);
        $this->assertTrue($result);
    }
    
    public function testAddUserModelRuleWithStoreDenyView()
    {
        $modelUri = 'http://example.org/exampleModel';
        
        $acGraphUri = 'http://localhost/OntoWiki/Config/';    
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);

        $result = $this->_object->addUserModelRule($modelUri, Erfurt_Ac::ACCESS_TYPE_VIEW, Erfurt_Ac::ACCESS_PERM_DENY);
        $this->assertTrue($result);
    }
    
    public function testAddUserModelRuleWithStoreGrantEdit()
    {
        $modelUri = 'http://example.org/exampleModel';
        
        $acGraphUri = 'http://localhost/OntoWiki/Config/';    
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);

        $result = $this->_object->addUserModelRule($modelUri, Erfurt_Ac::ACCESS_TYPE_EDIT, Erfurt_Ac::ACCESS_PERM_GRANT);
        $this->assertTrue($result);
    }
    
    public function testAddUserModelRuleWithStoreDenyEdit()
    {
        $modelUri = 'http://example.org/exampleModel';
        
        $acGraphUri = 'http://localhost/OntoWiki/Config/';    
        $storeAdapter = new Erfurt_Store_Adapter_Test();
        $storeAdapter->createModel($acGraphUri); // needs to be available as existing model
        $store = new Erfurt_Store(array('adapterInstance' => $storeAdapter), 'Test');
        $this->_object->setStore($store);

        $result = $this->_object->addUserModelRule($modelUri, Erfurt_Ac::ACCESS_TYPE_EDIT, Erfurt_Ac::ACCESS_PERM_DENY);
        $this->assertTrue($result);
    }
}
