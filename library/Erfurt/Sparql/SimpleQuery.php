<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * This class models a SPARQL query that can be used within an application in order to make
 * it easier e.g. to set different parts of a query independently.
 * Currently the SimpleQurey class only supports SELECT and ASK queries.
 *
 * @package    Erfurt_Sparql
 * @author     Norman Heino <norman.heino@gmail.com>
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Sparql_SimpleQuery
{
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------

    /** @var string */
    protected $_prologuePart = null;

    /** @var string */
    protected $_selectClause = null;

    /** @var boolean */
    protected $_ask = false;

    /** @var boolean */
    protected $_oldCount = false;

    /** @var array */
    protected $_from = array();

    /** @var array */
    protected $_fromNamed = array();

    /** @var string */
    protected $_wherePart = null;

    /** @var string */
    protected $_orderClause = null;

    /** @var int */
    protected $_limit = null;

    /** @var int */
    protected $_offset = null;

    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------

    public function __toString()
    {
        $queryString = $this->_prologuePart . PHP_EOL;

        if ($this->_ask) {
            $queryString .= 'ASK' . PHP_EOL;
        } else if ($this->_oldCount) {
            $queryString .= 'COUNT' . PHP_EOL;
        } else {
            $queryString .= $this->_selectClause . PHP_EOL;
        }

        foreach (array_unique($this->_from) as $from) {
            $queryString .= 'FROM <' . $from . '>' . PHP_EOL;
        }

        foreach (array_unique($this->_fromNamed) as $fromNamed) {
            $queryString .= 'FROM NAMED <' . $fromNamed . '>' . PHP_EOL;
        }

        $queryString .= $this->_wherePart . ' ';

        if ($this->_orderClause !== null) {
            $queryString .= 'ORDER BY ' . $this->_orderClause . PHP_EOL;
        }

        if ($this->_limit !== null) {
            $queryString .= 'LIMIT ' . $this->_limit . PHP_EOL;
        }

        if ($this->_offset !== null) {
            $queryString .= 'OFFSET ' . $this->_offset . PHP_EOL;
        }

        return $queryString;
    }

    // ------------------------------------------------------------------------
    // --- Static methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Objective-C style constructor
     *
     * @param string $queryString
     */
    public static function initWithString($queryString)
    {
        $parts = array(
            'prefix'        => array(),
            'base'          => array(),
            'ask'           => array(),
            'select_clause' => array(),
            'from'          => array(),
            'from_named'    => array(),
            'where'         => array(),
            'order'         => array(),
            'limit'         => array(),
            'offset'        => array()
        );

        $var = '[?$]{1}[\w\d]+';
        $expr = '(\w*\(.*\))';
        $tokens = array(
            'prefix'        => '/((PREFIX\s+[^:\s]+:\s+<[^\s]*>\s*)+)/si',
            'base'          => '/BASE\s+<(.+?)>/i',
            'ask'           => '/(ASK)/si',
            'old_count'     => '/(COUNT\s+(FROM|WHERE))/si',
            'select_clause' => '/((SELECT\s+)(DISTINCT\s+)?)(\*|((COUNT\s*\((\?\w*|\*)\)\s+(as\s+(\?\w+\s+))?)|(\?\w+\s+))*)/si',
            'from'          => '/FROM\s+<(.+?)>/i',
            'from_named'    => '/FROM\s+NAMED\s+<(.+?)>/i',
            'where'         => '/(WHERE\s+)?\{.*\}/si',
            'order'         => '/ORDER\s+BY((\s+' . $var . '|\s+' . $expr . '|\s+(ASC|DESC)\s*' . $expr . ')+)/i',
            'limit'         => '/LIMIT\s+(\d+)/i',
            'offset'        => '/OFFSET\s+(\d+)/i'
        );

        foreach ($tokens as $key => $pattern) {
            preg_match_all($pattern, $queryString, $parts[$key]);
        }

        $queryObject = new self();
        if (isset($parts['prefix'][0][0]) || isset($parts['base'][0][0])) {
            $prologue = '';
            if (isset($parts['base'][1][0])) {
                $prologue .= 'BASE <' . $parts['base'][1][0] . '>' . PHP_EOL;
            }
            if (isset($parts['prefix'][0][0])) {
                $prologue .= $parts['prefix'][0][0];
            }
            $queryObject->setProloguePart($prologue);   // whole match
        }

        if (isset($parts['ask'][0][0])) {
            $queryObject->setAsk(true);
        }

        if (isset($parts['old_count'][0][0])) {
            $queryObject->setOldCount(true);
        }

        if (isset($parts['select_clause'][0][0])) {
            $queryObject->setSelectClause($parts['select_clause'][0][0]);
        }

        if (isset($parts['from'][1][0])) {
            $queryObject->setFrom($parts['from'][1]);
        }

        if (isset($parts['from_named'][1][0])) {
            $queryObject->setFromNamed($parts['from_named'][1]);
        }

        if (isset($parts['where'][0][0])) {
            $queryObject->setWherePart($parts['where'][0][0]);
        }

        if (isset($parts['order'][1][0])) {
            $queryObject->setOrderClause(trim($parts['order'][1][0]));
        }

        if (isset($parts['limit'][1][0])) {
            $queryObject->setLimit($parts['limit'][1][0]);
        }

        if (isset($parts['offset'][1][0])) {
            $queryObject->setOffset($parts['offset'][1][0]);
        }

        return $queryObject;
    }

    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    public function addFrom($iri)
    {
        $this->_from[] = $iri;

        return $this;
    }

    public function addFromNamed($iri)
    {
        $this->_fromNamed[] = $iri;

        return $this;
    }

    public function getFrom()
    {
        return $this->_from;
    }

    public function getFromNamed()
    {
        return $this->_fromNamed;
    }

    public function getLimit()
    {
        return $this->_limit;
    }

    public function getOffset()
    {
        return $this->_offset;
    }

    /**
     * Returns the 'ORDER BY …' part of the query
     */
    public function getOrderClause()
    {
        return $this->_orderClause;
    }


    public function getProloguePart()
    {
        return $this->_prologuePart;
    }

    public function isAsk()
    {
        return $this->_ask;
    }

    public function getSelectClause()
    {
        return $this->_selectClause;
    }

    public function getWherePart()
    {
        return $this->_wherePart;
    }

    public function resetInstance()
    {
        $this->_prologuePart = null;
        $this->_ask          = false;
        $this->_selectClause = null;
        $this->_from         = array();
        $this->_fromNamed    = array();
        $this->_wherePart    = null;
        $this->_orderClause  = null;
        $this->_limit        = null;
        $this->_offset       = null;

        return $this;
    }

    public function setFrom(array $newFromArray)
    {
        $this->_from = $newFromArray;

        return $this;
    }

    public function setFromNamed(array $newFromNamedArray)
    {
        $this->_fromNamed = $newFromNamedArray;

        return $this;
    }

    public function setLimit($limit)
    {
        $this->_limit = (int)$limit;

        return $this;
    }

    public function setOffset($offset)
    {
       $this->_offset = $offset;
       return $this;
    }

    /**
     * Set the 'ORDER BY …' part for the query
     */
    public function setOrderClause($orderString)
    {
        $this->_orderClause = $orderString;

        return $this;
    }

    public function setProloguePart($prologueString)
    {
        $this->_prologuePart = $prologueString;

        return $this;
    }

    public function setAsk($ask = true)
    {
        if ($ask === true | strtolower($ask) == 'ask') {
            $this->_ask = true;
        } else {
            $this->_ask = false;
        }

        return $this;
    }

    public function setOldCount($oldCount = true) {

        if ($oldCount === true | strtolower($oldCount) == 'count') {
            $this->_oldCount = true;
        } else {
            $this->_oldCount = false;
        }
    }

    public function setSelectClause($selectClauseString)
    {
        $this->_selectClause = $selectClauseString;

        return $this;
    }

    public function setWherePart($whereString)
    {
        if (stripos($whereString, 'where') !== false) {
            $this->_wherePart = $whereString;
        } else {
            $this->_wherePart = 'WHERE' . $whereString;
        }

        return $this;
    }
}
