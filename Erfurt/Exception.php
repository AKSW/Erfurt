<?php
// vim: sw=4:sts=4:expandtab
/**
 * @package   erfurt
 * @subpackage    exception
 * @copyright  AKSW team 2007
 * @author Stefan Berger <berger@intersolut.de>
 */
class Erfurt_Exception extends Exception {

    function display($pre = true) {
        if ($pre) print '<pre>';  
        echo "Erfurt_Exception: code $this->code ($this->message) " .
            "in line $this->line of $this->file\n";
        echo $this->getTraceAsString(), "\n";
        if ($pre) print '</pre>';
    }

}
?>
