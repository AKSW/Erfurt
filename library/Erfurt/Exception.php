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
class Erfurt_Exception extends Exception {

	//Used for exceptions that found invalid URI/IRI's
    const INVALID_IRI_ERROR = 7;
    
    function display($pre = true) {
        if ($pre) print '<pre>';  
        echo "Erfurt_Exception: code $this->code ($this->message) " .
            "in line $this->line of $this->file\n";
        echo $this->getTraceAsString(), "\n";
        if ($pre) print '</pre>';
    }

}
?>
