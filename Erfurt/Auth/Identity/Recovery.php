<?php

/**
 * This file is part of the {@link http://ontowiki.net OntoWiki} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version $Id$
 */

require_once 'Zend/Mail.php';

/**
 * Class to recover/reset lost user credentials like password, username
 * Templates are simple strings where %HASH% will be replaced with the recovery session id
 *
 * default options array:
 * ----------------------
 * key              value
 * ----------------------
 * method       =>  'mail'
 * template     =>  false
 * templateHtml =>  false
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package erfurt
 * @subpackage auth
 * @author Christoph Rieß <c.riess.dev@googlemail.com>
 */

class Erfurt_Auth_Identity_Recovery
{
    /**
     * @var options array
     */
    private $options = array(
        'method'    => 'mail',
        'template' => false ,
        'templateHtml' => false
    );

    /**
     * Constructor; accepts options array to overwrite default options
     */
    public function __construct( array $options = array() )
    {
        $this->options = array_merge($this->options,$options);

        $method = $this->options['method'];

        $config = Erfurt_App::getInstance()->getConfig();

        $methodConfig = $config->recovery->{$method}->toArray();

        if (!empty($methodConfig) ) {
            if ( array_key_exists($method, $this->options) && is_array($this->options[$method]) ) {
                $this->options[$method] = array_merge($methodConfig, $this->options[$method]);
            } else {
                $this->options[$method] = $methodConfig;
            }
        } else {
            // do nothing
        }
    }

    /**
     *
     */
    public function recoverWithIdentity( $identity )
    {

        switch ($this->options['method']) {
            case 'mail':
                $ret = $this->recoverWithMail( $identity );
                break;
            default:
                $ret = false;
                break;
        }

        return $ret;
    }

    /**
     *
     */
    private function recoverWithMail( $identity )
    {

        $config     = Erfurt_App::getInstance()->getConfig();
        $store      = Erfurt_App::getInstance()->getStore();

        $query      = new Erfurt_Sparql_SimpleQuery();
        $query->addFrom($config->ac->modelUri);
        $query->setProloguePart('SELECT *');
        $query->setWherePart(
            '{ ?user <' . $config->ac->user->name . '> "' . $identity . '" . 
             OPTIONAL { ?user <' . $config->ac->user->mail . '> ?mail . } }'
        );

        $resultUser  = $store->sparqlQuery($query, array('use_ac' => false));

        $query      = new Erfurt_Sparql_SimpleQuery();
        $query->addFrom($config->ac->modelUri);
        $query->setProloguePart('SELECT *');
        $query->setWherePart(
            '{ ?user <' . $config->ac->user->mail . '> <mailto:' . $identity . '> .
             OPTIONAL { ?user <' . $config->ac->user->name . '> ?name . } }'
        );

        $resultMail  = $store->sparqlQuery($query, array('use_ac' => false));

        if ( !empty($resultUser) )  {
            $userUri  = $resultUser[0]['user'];
            $username = $identity;
            $mailAddr = substr($resultUser[0]['mail'], 7);
        } elseif ( !empty($resultMail) ) {
            $userUri  = $resultMail[0]['user'];
            $username = $resultMail[0]['name'];
            $mailAddr = $identity;
        } else {
            require_once 'Erfurt/Auth/Identity/Exception.php';
            throw new Erfurt_Auth_Identity_Exception('Unknown user identifier.');
        }

        $hash = $this->generateHash($userUri);

        $mail = new Zend_Mail();

        if ($this->options['template']) {
            $mail-setBodyText(str_replace('%HASH%',$hash,$this->options['template']));
        } else {
            $mail->setBodyText($config->urlBase . 'application/accountrecovery/hash/' . $hash);
        }

        if ($this->options['templateHtml']) {
            $mail-setBodyHtml(str_replace('%HASH%',$hash,$this->options['templateHtml']));
        } else {
            $mail->setBodyHtml($config->urlBase . 'application/accountrecovery/hash/' . $hash);
        }

        $mail->addTo($mailAddr, $username);
        $mail->setFrom(
            $this->options['mail']['localname'] . '@' . $this->options['mail']['hostname'],
            'Identity Recovery for ' . $this->options['mail']['hostname']
        );
        $mail->setSubject('TestSubject');
        $mail->send();

        return true;

    }

    /**
     *
     */
    private function generateHash($userUri = '')
    {
        $config     = Erfurt_App::getInstance()->getConfig();
        $store      = Erfurt_App::getInstance()->getStore();

        $hash = md5($userUri . time() . rand());
        $acModel = Erfurt_App::getInstance()->getAcModel();
        // delete previous hash(es)
        $store->deleteMatchingStatements(
            $config->ac->modelUri ,
            $userUri ,
            $config->ac->user->recoveryHash ,
            null ,
            array('useAc' => false)
        );
        // create new hash statement
        $store->addStatement(
            $config->ac->modelUri ,
            $userUri ,
            $config->ac->user->recoveryHash ,
            array('value' => $hash, 'type' => 'literal') , 
            false
        );
        //var_dump($hash);
        return $hash;
    }

    /**
     *
     */
    public function validateHash($hash)
    {
        $config     = Erfurt_App::getInstance()->getConfig();
        $store      = Erfurt_App::getInstance()->getStore();

        $query      = new Erfurt_Sparql_SimpleQuery();
        $query->addFrom($config->ac->modelUri);
        $query->setProloguePart('SELECT ?user');
        $query->setWherePart('{ ?user <' . $config->ac->user->recoveryHash . '> "' . $hash . '" . }');

        $resultUser  = $store->sparqlQuery($query, array('use_ac' => false));

        if ( !empty($resultUser) ) {
            return $resultUser[0]['user'];
        } else {
            require_once 'Erfurt/Auth/Identity/Exception.php';
            throw new Erfurt_Auth_Identity_Exception('Invalid recovery session identifier.');
        }

    }

    /**
     *
     */
    public function resetPassword( $hash, $password1, $password2)
    {

        $config       = Erfurt_App::getInstance()->getConfig();
        $store        = Erfurt_App::getInstance()->getStore();
        $actionConfig = Erfurt_App::getInstance()->getActionConfig('RegisterNewUser');

        $userUri = $this->validateHash($hash);

        $ret = false;

        if ($password1 !== $password2) {
            require_once 'Erfurt/Auth/Identity/Exception.php';
            throw new Erfurt_Auth_Identity_Exception('Passwords do not match.');
        } else if (strlen($password1) < 5) {
            require_once 'Erfurt/Auth/Identity/Exception.php';
            throw new Erfurt_Auth_Identity_Exception('Password needs at least 5 characters.');
        } else if (
            isset($actionConfig['passregexp']) &&
            $actionConfig['passregexp'] != '' &&
            !@preg_match($actionConfig['passregexp'], $password1)
        ) {
            require_once 'Erfurt/Auth/Identity/Exception.php';
            throw new Erfurt_Auth_Identity_Exception('Password does not match regular expression set in system configuration');
        } else {
            // Set new password.
            
            $store->deleteMatchingStatements(
                $config->ac->modelUri, 
                $userUri,
                $config->ac->user->pass, 
                null, 
                array('use_ac' => false)
            );

            $store->addStatement(
                $config->ac->modelUri,
                $userUri, 
                $config->ac->user->pass, 
                array(
                    'value' => sha1($password1),
                    'type'  => 'literal'
                ),
                false
            );

            // delete hash(es)
            $store->deleteMatchingStatements(
                $config->ac->modelUri ,
                $userUri ,
                $config->ac->user->recoveryHash ,
                null ,
                array('useAc' => false)
            );

            $ret = true;
        }

        return $ret;
    }
}

