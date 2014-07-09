<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

require_once 'Erfurt/Rdf/Node.php';

/**
 * Represents a basic RDF literal.
 *
 * @category   Erfurt
 * @package    Erfurt_Rdf
 * @copyright  Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Rdf_Literal extends Erfurt_Rdf_Node {

    protected $_label = false;
    protected $_lang = null;
    protected $_datatype = null;

    protected function __construct($label) {
        $this->_label = $label;
    }

    /**
     * Returns a string representation of this resource.
     *
     * @return string
     */
    public function __toString() {
        if ( $this->getLabel() ) {
            $ret = $this->getLabel();
            if ( $this->getDatatype() ) {
                $ret .= "^^" . $this->getDatatype() ;
            }
            else if ( $this->getLanguage() ) {
                $ret .= "@" . $this->getLanguage() ;
            }
            return $ret;
        }
        else {
            return "";
        }
    }

    public function setLanguage($lang) {
        $this->_lang = $lang;
    }

    public function setDatatype($datatype) {
        $this->_datatype = $datatype;
    }

    public static function initWithLabel($label) {
        return new Erfurt_Rdf_Literal($label);
    }

    public static function initWithLabelAndLanguage($label, $lang) {
        $l = new Erfurt_Rdf_Literal($label);
        $l->setLanguage($lang);
        return $l;
    }

    public static function initWithLabelAndDatatype($label, $datatype) {
        $l = new Erfurt_Rdf_Literal($label);
        $l->setDatatype($datatype);
        return $l;
    }

    public static function initWithArray($array) {
        if ($array['type'] != 'literal') {
            throw new Erfurt_Exception('Array not a literal.');
        }
        $l = new Erfurt_Rdf_Literal($array['value']);
        if (isset($array['lang'])) {
            $l->setLanguage($array['lang']);
        } else if (isset($array['xml:lang'])) {
            $l->setLanguage($array['xml:lang']);
        } else if (isset($array['datatype'])) {
            $l->setDatatype($array['datatype']);
        }
        return $l;
    }

    public function getLabel() {
        return $this->_label;
    }

    public function getDatatype() {
        return $this->_datatype;
    }

    public function getLanguage() {
        return $this->_lang;
    }
}
