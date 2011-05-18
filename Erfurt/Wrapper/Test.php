<?php
/**
 * This file is part of the {@link http://ontowiki.net OntoWiki} project.
 *
 * @category  OntoWiki
 * @package   OntoWiki_extensions_wrapper
 * @copyright Copyright (c) 2010, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

require_once 'Erfurt/Wrapper.php';

/**
 * This wrapper extension provides functionality for gathering linked data.
 *
 * @category  OntoWiki
 * @package   OntoWiki_extensions_wrapper
 * @copyright Copyright (c) 2009 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Wrapper_Test extends Erfurt_Wrapper
{    
    static $isAvailableResult = false;
    static $isHandledResult = false;
    static $runResult = false;
    
    public function getDescription()
    {
        return 'This wrapper is a wrapper for testing purposes only.';
    }
    
    public function getName()
    {
        return 'Test Wrapper';
    }
    
    public function isAvailable($r, $graphUri)
    { 
        return self::$isAvailableResult;
    }
    
    public function isHandled($r, $graphUri)
    {
        return self::$isHandledResult;
    }
    
    public function run($r, $graphUri)
    { 
        return self::$runResult;
    }
}
