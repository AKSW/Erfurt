<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

require_once 'Erfurt/Sparql/Query.php';

/**
 * This class was originally adopted from rdfapi-php (@link http://sourceforge.net/projects/rdfapi-php/).
 * It was modified and extended in order to fit into Erfurt.
 *
 * @package Erfurt_Sparql
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 */
class Erfurt_Sparql_QueryResultVariable
{
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    protected $_variable = null;
    protected $_datatype = null;
    protected $_language = null;
    protected $_alias    = null;
    protected $_func     = null;

    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------

    public function __construct($variable)
    {
        $this->_variable = $variable;
        $this->_language = Erfurt_Sparql_Query::getLanguageTag($variable);
    }
    
    public function __toString()
    {
        return $this->getName();
    }

    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    public function getDatatype()
    {
        return $this->_datatype;
    }
    
    public function getFunc()
    {
        return $this->_func;
    }

    public function getId()
    {
        return $this->_variable;
    }
    
    public function getLanguage()
    {
        return $this->_language;
    }
    
    public function getName()
    {
        if (null !== $this->_alias) {
            return $this->_alias;
        }
        
        return $this->_variable;
    }
    
    public function getVariable()
    {
        return $this->_variable;
    }

    public function setAlias($alias)
    {
        $this->_alias = $alias;
    }
    
    public function setDatatype($datatype)
    {
        $this->_datatype = $datatype;
    }

    public function setFunc($func)
    {
        $this->_func = $func;
    }
}
