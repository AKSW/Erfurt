<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2010-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */



/**
 * This wrapper extension provides functionality for gathering linked data.
 *
 * @package   Erfurt_Wrapper
 * @copyright Copyright (c) 2012 {@link http://aksw.org aksw}
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
