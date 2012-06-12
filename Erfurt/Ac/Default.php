<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2010-2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

require_once 'Erfurt/Ac.php';

/**
 * A class providing support for access control.
 * 
 * This class provides support for model and action based access control.
 * The access control informations are stored in a triple store.
 *
 * @copyright Copyright (c) 2010-2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package Erfurt_Ac
 * @author Stefan Berger <berger@intersolut.de>
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Ac_Default extends Erfurt_Ac
{
    /**
     * Contains the combinded action configurations extracted from the defaultActionConfig as well
     * as the ac model.
     *
     * @var array
     */
    private $_actionConfig = null;
    
    /**
     * Contains configuration values like URIs, etc.
     * 
     * There exists a default value for each supported key, which can be overwritten in the
     * constructor.
     *
     * @var array
     */
    private $_config = array(
        'acGraphUri'         => 'http://localhost/OntoWiki/Config/',
        'acBaseUri'          => 'http://ns.ontowiki.net/SysOnt/',
        'actionClassUri'     => 'http://ns.ontowiki.net/SysOnt/Action',
        'groupMemberProp'    => 'http://rdfs.org/sioc/ns#has_member',
        'rawConfigPropUri'   => 'http://ns.ontowiki.net/SysOnt/rawConfig',
        'groupClassUri'      => 'http://rdfs.org/sioc/ns#Usergroup',
        'userClassUri'       => 'http://rdfs.org/sioc/ns#User',
        'anyGraphUri'        => 'http://ns.ontowiki.net/SysOnt/AnyModel',
        'grantAccessProp'    => 'http://ns.ontowiki.net/SysOnt/grantAccess',
        'anyActionUri'       => 'http://ns.ontowiki.net/SysOnt/AnyAction',
        'denyAccessProp'     => 'http://ns.ontowiki.net/SysOnt/denyAccess',
        'grantAccessProp'    => 'http://ns.ontowiki.net/SysOnt/grantAccess',
        'grantModelViewProp' => 'http://ns.ontowiki.net/SysOnt/grantModelView',
        'denyModelViewProp'  => 'http://ns.ontowiki.net/SysOnt/denyModelView',
        'grantModelEditProp' => 'http://ns.ontowiki.net/SysOnt/grantModelEdit',
        'denyModelEditProp'  => 'http://ns.ontowiki.net/SysOnt/denyModelEdit',
        'autoAddActions'     => true,
        'allowDbUser'        => false,
    );
    
    /**
     * Contains default action configurations, which will be overwritten by values from the ac model.
     *
     * The default action configuration can also be overwritten by using setDefaultActionConfig.
     *
     * @var array
     */
    private $_defaultActionConfig = array(
        self::ACTION_LOGIN => array(
            'type' => 'RDF'
        ),
        self::ACTION_REGISTER => array(
            'defaultGroup'   => 'http://localhost/OntoWiki/Config/DefaultUserGroup',
            'mailValidation' => true,
            'uidRegexp'      => '/^[[:alnum:]]+$/',
            'passRegexp'     => ''
        )
    );
    
    /**
     * Contains default user rights, which will be overwritten by values from the ac model.
     *
     * The default user rights can also be overwritten by using setDefaultUserRights. By default
     * there are no default user rights configured.
     *
     * @var array
     */
    private $_defaultUserRights = array();
    
    /**
     * The store to use for querying the ac model.
     *
     * Use setStore to configure the store to use. When no store is set, querying the ac model will
     * be skipped. 
     *
     * @var Erfurt_Store
     */
    private $_store = null;

    /**
     * Contains the user rights for all fetched users.
     *
     * @var array
     */
    private $_userRights = array();
    
    /**
     * Contains a template for the default permissions of a user.
     *
     * @var array
     */
    private $_userRightsTemplate = array(
        Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED => false,
        Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED => false,
        Erfurt_Ac::AC_ANY_ACTION_ALLOWED     => false,
        Erfurt_Ac::AC_GRANT_ACCESS           => array(),
        Erfurt_Ac::AC_DENY_ACCESS            => array(),
        Erfurt_Ac::AC_GRANT_MODEL_VIEW       => array(),
        Erfurt_Ac::AC_DENY_MODEL_VIEW        => array(),
        Erfurt_Ac::AC_GRANT_MODEL_EDIT       => array(),
        Erfurt_Ac::AC_DENY_MODEL_EDIT        => array()
    );

    /**
     * Creates a new instance with an optional configuration.
     *
     * @param array $config An optional configuration array that is merged with the default configuration.
     * @return void
     */
    public function __construct(array $config = array())
    {
        $this->_config = array_merge($this->_config, $config);
    }

    /**
     * @see Erfurt_Ac::addUserModelRule
     * @inheritdoc
     */
    public function addUserModelRule($modelUri, $type = Erfurt_Ac::ACCESS_TYPE_VIEW, $perm = Erfurt_Ac::ACCESS_PERM_GRANT) 
    {
        $userUri = $this->getUser()->getUri();
        $type    = strtolower($type);
        $perm    = strtolower($perm);
        
        // is type supported?
        if (!in_array($type, array(Erfurt_Ac::ACCESS_TYPE_VIEW, Erfurt_Ac::ACCESS_TYPE_EDIT))) {
            require_once 'Erfurt/Ac/Exception.php';
            throw new Erfurt_Ac_Exception('Wrong access type submitted');
        }

        // is permission supported?
        if (!in_array($perm, array(Erfurt_Ac::ACCESS_PERM_GRANT, Erfurt_Ac::ACCESS_PERM_DENY))) {
            require_once 'Erfurt/Ac/Exception.php';
            throw new Erfurt_Ac_Exception('Wrong permission type submitted');
        }

        // set the property for the right to add...
        if ($type === Erfurt_Ac::ACCESS_TYPE_VIEW) {
            if ($perm === Erfurt_Ac::ACCESS_PERM_GRANT) {
                $prop = $this->_config['grantModelViewProp'];
            } else {
                // else the permission is deny
                $prop = $this->_config['denyModelViewProp'];
            }
        } else {
            // else the type is edit
            if ($perm === Erfurt_Ac::ACCESS_PERM_GRANT) {
                $prop = $this->_config['grantModelEditProp'];
            } else {
                // else the permission is deny
                $prop = $this->_config['denyModelEditProp'];
            }
        }

        // Update the array that contains the right for the user.
        unset($this->_userRights[$userUri]);

        // Add the right
        $result = false;
        if (null !== $this->_store) {
            $result = $this->_store->addStatement(
                $this->_config['acGraphUri'], 
                $userUri, 
                $prop, 
                array('type' => 'uri', 'value' => $modelUri), 
                false
            );
        }
        
        return $result;
    }

    /**
     * @see Erfurt_Ac
     */
    public function getActionConfig($action, $isUri = true)
    {   
        $this->_fetchActionConfig();
        
        $actionUri = $action;
        if (!$isUri) {
            $actionUri = $this->_config['acBaseUri'] . $action;
        }
        
        if (isset($this->_actionConfig[$actionUri])) {
            return $this->_actionConfig[$actionUri];
        } else {
            return false;
        }
    }

    /**
     * @see Erfurt_Ac
     */
    public function isActionAllowed($action, $isUri = true)
    {
        $userRights = $this->_getUserModelRights();
    
        $actionUri = $action;
        if (!$isUri) {
            $actionUri = $this->_config['acBaseUri'] . $action;
        }

        if (isset($this->_actionConfig[$actionUri])) {
            // Action exists
            if (in_array($actionUri, $userRights[Erfurt_Ac::AC_DENY_ACCESS])) {
                // Action explicitly forbidden
                return false;
            } else if (in_array($actionUri, $userRights[Erfurt_Ac::AC_GRANT_ACCESS])) {
                // Action explicitly allowed
                return true;
            } else if ($this->isAnyActionAllowed()) {
                // Every Action allowed
                return true;
            }
        } else {
            if (((bool)$this->_config['autoAddActions'] === true) && (null !== $this->_store)) {
                // We create action instance, such that it can be configured in AC model.
                // Array for new statements (an action instance plus label)
                $statementArray = array(
                    $actionUri => array ( 
                        EF_RDF_TYPE => array(array(
                            'type'  => 'uri',
                            'value' => $this->_config['actionClassUri']
                        ))
                    )
                );
                
                // Label
                if (!$isUri) {
                    $statementArray[$actionUri][EF_RDFS_LABEL] = array(array(
                        'type'  => 'literal',
                        'value' => $action
                    ));
                }
            
                $this->_store->addMultipleStatements(
                    $this->_config['acGraphUri'], 
                    $statementArray, 
                    false
                );
            }
        }
        
        // Also the action may was added at this point, we return false here, since
        // access to this action needs to be configured first. 
        return false;
    }

    /**
     * @see Erfurt_Ac
     */
    public function isAnyActionAllowed() 
    {
        $userRights = $this->_getUserModelRights();
    
        return $userRights[Erfurt_Ac::AC_ANY_ACTION_ALLOWED];
    }

    /**
     * @see Erfurt_Ac
     */
    public function isAnyModelAllowed($type = Erfurt_Ac::ACCESS_TYPE_VIEW)
    {
        $userRights = $this->_getUserModelRights();
        $type       = strtolower($type);
        
        if ($type === Erfurt_Ac::ACCESS_TYPE_VIEW) {
            // any model view allowed?
            if ($userRights[Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED] === true) {
                return true;
            } else if ($userRights[Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED] === true) {
                // any model edit allowed? (implies view right)
                return true;
            } else {
                // not allowed!
                return false;
            }
        }
        
        if ($type === Erfurt_Ac::ACCESS_TYPE_EDIT) {
            // any model edit allowed?
            if ($userRights[Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED] === true) {
                return true;
            } else {
                // not allowed!
                return false;
            }           
        }
        
        // deny everything else => false
        return false;
    }

    /**
     * @see Erfurt_Ac
     */
    public function isModelAllowed($type, $modelUri)
    {
        $modelUri   = (string)$modelUri;
        $userRights = $this->_getUserModelRights();
        $type       = strtolower($type);

        // type = view; check whether allowed
        if ($type === Erfurt_Ac::ACCESS_TYPE_VIEW) {
            // explicit forbidden
            if (in_array($modelUri, $userRights[Erfurt_Ac::AC_DENY_MODEL_VIEW])) {
                return false;
            } else if (in_array($modelUri, $userRights[Erfurt_Ac::AC_GRANT_MODEL_VIEW])) {
                // view explicit allowed and not denied
                return true;
            } else if (in_array($modelUri, $userRights[Erfurt_Ac::AC_GRANT_MODEL_EDIT]) 
                       && !in_array($modelUri, $userRights[Erfurt_Ac::AC_DENY_MODEL_EDIT])) {
                
                // view access type contained in edit and edit allowed and not denied
                return true;
            } else if ($this->isAnyModelAllowed(Erfurt_Ac::ACCESS_TYPE_VIEW)) {
                // any model view allowed
                return true;
            }
        } else if ($type === Erfurt_Ac::ACCESS_TYPE_EDIT) { // type = edit; check whether allowed
            // explicit forbidden
            if (in_array($modelUri, $userRights[Erfurt_Ac::AC_DENY_MODEL_EDIT])) {
                return false;
            } else if (in_array($modelUri, $userRights[Erfurt_Ac::AC_GRANT_MODEL_EDIT])) {
                // edit allowed and not denied
                return true;
            } else if ($this->isAnyModelAllowed(Erfurt_Ac::ACCESS_TYPE_EDIT)) {
                // any model edit allowed
                return true;
            }
        }
        
        // deny everything else => false
        return false;
    }

    /**
     * Sets the default action configuration.
     *
     * By calling this method the default action configuration, which is used for merging with
     * the results from querying the ac model is overwritten.
     * 
     * @param array $defaultActionConfig An array containing the new default action config
     * @return void
     */
    public function setDefaultActionConfig(array $defaultActionConfig)
    {
        // Initial config for actions provided as a static config.
        // This will be overwritten by the results of SPARQL queries iff a store is set.
        $this->_defaultActionConfig = $defaultActionConfig;
    }

    /**
     * Sets the default user rights.
     *
     * By calling this method the default user rights, which are used for merging with
     * the results from querying the ac model are overwritten.
     * 
     * @param array $defaultUserRights An array containing the new default user rights
     * @return void
     */
    public function setDefaultUserRights(array $defaultUserRights)
    {
        // Initial default rights for users provided as a static config.
        // This will be overwritten by the results of SPARQL queries iff a store is set.
        $this->_defaultUserRights = $defaultUserRights;
    }

    /**
     * Sets the store instance that is used for querying the ac model.
     * 
     * @param Erfurt_Store
     * @return void
     */
    public function setStore(Erfurt_Store $store)
    {
        // Check for AC model!
        $acModel = $store->getModel($this->_config['acGraphUri'], false);
        if (!$acModel) {
            require_once 'Erfurt/Ac/Exception.php';
            throw new Erfurt_Ac_Exception('AC model not available with URI: ' . $this->_config['acGraphUri']);
        }
    
        $this->_store = $store;
    }

    /**
     * Internal method that fetches the action configuration.
     *
     * This is done by merging the default action configuration with the result of querying the
     * ac model (if the store is set).
     *
     * @return void
     */
    protected function _fetchActionConfig()
    {
        if (null === $this->_actionConfig) {
            // Default values
            $this->_actionConfig = $this->_defaultActionConfig;
            
            if (null !== $this->_store) {
                // Overwrite with values from store
                $acGraphUri = $this->_config['acGraphUri'];
                $rdfType = EF_RDF_TYPE;
                $actionClass = $this->_config['actionClassUri'];
                $rawConfigProp = $this->_config['rawConfigPropUri'];
                
                $sparql = <<<EOF
SELECT ?s ?o
FROM <$acGraphUri>
WHERE {
    ?s <$rawConfigProp> ?o .
    ?s <$rdfType> <$actionClass> .
}
EOF;

                $result = $this->_sparql($sparql);
                if ($result) {
                    foreach ($result as $row) {
                        $s      = $row['s'];
                        $oArray = explode('=', $row['o']);
                    
                        // remove quotas
                        if (substr($oArray[1], 0, 1) === '"') {
                            $oArray[1] = substr($oArray[1], 1);
                        }
                        if (substr($oArray[1], -1) === '"') {
                            $oArray[1] = substr($oArray[1], 0, -1);
                        }
                      
                        // Check whether config for uri is already set.
                        if (!isset($this->_actionConfig[$s])) {
                            $this->_actionConfig[$s] = array();
                        } 
                    
                        $this->_actionConfig[$s][$oArray[0]] = $oArray[1];
                    }
                }
            }
        }
    }

    /**
     * Internal method that filters the SPARQL results and saves the results in $userRights var.
     * 
     * @param array $resultList A list of sparql results
     * @param array $userRights A reference to an array containing user rights
     * @return void
     */
    protected function _filterAccess($resultList, &$userRights) 
    {
        // 1. Check for anyAction/anyModel allowed + specific allowed actions/models
        foreach ($resultList as $entry) {
            $p = $entry['p'];
            $o = $entry['o'];
        
            if ($p === $this->_config['grantAccessProp']) {
                if ($o === $this->_config['anyActionUri']) {
                    $userRights[Erfurt_Ac::AC_ANY_ACTION_ALLOWED] = true;
                } else if (!in_array($o, $userRights[Erfurt_Ac::AC_GRANT_ACCESS])) {
                    $userRights[Erfurt_Ac::AC_GRANT_ACCESS][] = $o;
                }
            } else if ($p === $this->_config['grantModelViewProp']) {
                if ($o === $this->_config['anyGraphUri']) {
                    $userRights[Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED] = true;
                } else if (!in_array($o, $userRights[Erfurt_Ac::AC_GRANT_MODEL_VIEW])) {
                    $userRights[Erfurt_Ac::AC_GRANT_MODEL_VIEW][] = $o;
                }
            } else if ($p === $this->_config['grantModelEditProp']) {
                if ($o === $this->_config['anyGraphUri']) {
                    $userRights[Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED] = true;
                } else if (!in_array($o, $userRights[Erfurt_Ac::AC_GRANT_MODEL_EDIT])) {
                    $userRights[Erfurt_Ac::AC_GRANT_MODEL_EDIT][] = $o;
                }
            }
        }
        
        // 2. Check for anyAction/anyModel denied + specific denied actions/models (overwrites allow!)
        foreach ($resultList as $entry) {
            $p = $entry['p'];
            $o = $entry['o'];
            
            if ($p === $this->_config['denyAccessProp']) {
                if ($o === $this->_config['anyActionUri']) {
                    $userRights[Erfurt_Ac::AC_ANY_ACTION_ALLOWED] = false;
                } else if (!in_array($o, $userRights[Erfurt_Ac::AC_DENY_ACCESS])) {
                    $userRights[Erfurt_Ac::AC_DENY_ACCESS][] = $o;
                }
            } else if ($p === $this->_config['denyModelViewProp']) {
                if ($o === $this->_config['anyGraphUri']) {
                    $userRights[Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED] = false;
                } 
                
                if (!in_array($o, $userRights[Erfurt_Ac::AC_DENY_MODEL_VIEW])) {
                    $userRights[Erfurt_Ac::AC_DENY_MODEL_VIEW][] = $o;
                }
            } else if ($p === $this->_config['denyModelEditProp']) {
                if ($o === $this->_config['anyGraphUri']) {
                    $userRights[Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED] = false;
                }
                
                if (!in_array($o, $userRights[Erfurt_Ac::AC_DENY_MODEL_EDIT])) {
                    $userRights[Erfurt_Ac::AC_DENY_MODEL_EDIT][] = $o;
                }
            }
        }
    }

    /**
     * Internal method that gets the user rights for the current user.
     *
     * In case the user uri was not fetched already, it is fetched.
     * 
     * @return array Returns an array that contains the user rights
     */
    protected function _getUserModelRights() 
    {
        $userUri = $this->getUser()->getUri();
        
        // Also fetch action config if required.
        $this->_fetchActionConfig();
    
        if (!isset($this->_userRights[$userUri])) {
            // In this case we need to fetch the rights for the user.
            // Initialize with a fresh template.
            $userRights = $this->_userRightsTemplate;
            
            // Super admin, i.e. a user that has database rights 
            // (only for debugging purposes and only if enabled in config).
            if (((bool)$this->_config['allowDbUser'] === true) && 
                ($userUri === Erfurt_Auth::SUPERADMIN_USER)) {
                
                $userRights[Erfurt_Ac::AC_ANY_ACTION_ALLOWED]     = true;
                $userRights[Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED] = true;
                $userRights[Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED] = true;

                $this->_userRights[$userUri] = $userRights;
                return $userRights;
            }
            
            // Set values from default user rights config iff available.
            if (isset($this->_defaultUserRights[$userUri])) {
                // Overwrite template values with default values for user.
                $userRights = array_merge($userRights, $this->_defaultUserRights[$userUri]);
            }
            
            if (null !== $this->_store) {
                $acGraphUri = $this->_config['acGraphUri'];
                $memberProp = $this->_config['groupMemberProp'];
                $rdfTypeProp = EF_RDF_TYPE;
                $groupClass = $this->_config['groupClassUri'];
                
                // Group query
                $sparql = <<<EOF
SELECT ?group ?p ?o
FROM <$acGraphUri>
WHERE {
    ?group ?p ?o .
    ?group <$rdfTypeProp> <$groupClass> .
    ?group <$memberProp> <$userUri> .
}
EOF;

                $result = $this->_sparql($sparql);
                if ($result) {
                    $this->_filterAccess($result, $userRights);
                }
                
                // User query
                $userClass = $this->_config['userClassUri'];
                
                $sparql = <<<EOF
SELECT ?p ?o
FROM <$acGraphUri>
WHERE {
    <userUri> ?p ?o .
    <userUri> <$rdfTypeProp> <$userClass> .
}
EOF;

                $result = $this->_sparql($sparql);
                if ($result) {
                    $this->_filterAccess($result, $userRights);
                }
            }
                      
            // Now check for forbidden anyModel.
            $anyGraphUri = $this->_config['anyGraphUri'];
            if (in_array($anyGraphUri, $userRights[Erfurt_Ac::AC_DENY_MODEL_VIEW])) {
                // view
                $userRights[Erfurt_Ac::AC_ANY_MODEL_VIEW_ALLOWED] = false;
                $userRights[Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED] = false;
                $userRights[Erfurt_Ac::AC_GRANT_MODEL_VIEW]       = array();
                $userRights[Erfurt_Ac::AC_GRANT_MODEL_EDIT]       = array();
            } else if (in_array($anyGraphUri, $userRights[Erfurt_Ac::AC_DENY_MODEL_EDIT])) {
                // edit
                $userRights[Erfurt_Ac::AC_ANY_MODEL_EDIT_ALLOWED] = false;
                $userRights[Erfurt_Ac::AC_GRANT_MODEL_EDIT]       = array();
            }
            
            $this->_userRights[$userUri] = $userRights;
        }
        
        return $this->_userRights[$userUri];
    }

    /**
     * Internal method that executes a sparql query against the store. 
     * 
     * @param string SPARQL query
     * @return array Returns an array containig the results
     */
    protected function _sparql($sparqlQuery) 
    {
        if (null !== $this->_store) {
            return $this->_store->sparqlQuery($sparqlQuery, array(STORE_USE_AC => false));
        }
        
        // @codeCoverageIgnoreStart
        return array();
        // @codeCoverageIgnoreEnd
    }
}
