<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @package     Erfurt
 * @copyright   Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @author      Stefan Berger <berger@intersolut.de>
 */
class Erfurt_Exception extends Exception
{

    /*
     * All Erfurt Error Codes are saved in this file.
     * The DEFAULT_ERROR should only be used to get
     * access to the third Exception parameter
     * The NON_FATAL_ERROR is not handled in Erfurt,
     * but OntoWiki handles Exceptions with errorcodes
     * greater than 0 (and smaller than equal 2000) differently
     * The SYSTEM_MODELS_IMPORTED is thrown when 1 or more System
     * Models are importet into the Store (it's a Store_Exception
     * Code)
     */
    const DEFAULT_ERROR = 0;
    const NON_FATAL_ERROR = 1;
    const SYSTEM_MODELS_IMPORTED = 20;

    function display($pre = true)
    {
        if ($pre) print '<pre>';
        echo "Erfurt_Exception: code $this->code ($this->message) " .
            "in line $this->line of $this->file\n";
        echo $this->getTraceAsString(), "\n";
        if ($pre) print '</pre>';
    }

}
