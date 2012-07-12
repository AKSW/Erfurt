<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * A set of Statements (memory model) / ARC2 index / phprdf array
 *
 * @category Erfurt
 * @package Erfurt_Rdf
 * @author {@link http://sebastian.tramp.name Sebastian Tramp}
 * @author Jonas Brekle <jonas.brekle@gmail.com>
 * @author Natanael Arndt <arndtn@gmail.com>
 */
class Erfurt_Rdf_MemoryModel
{
    protected $_statements = array();

    /*
     * model can be optionally constructed with a given array
     */
    function __construct( array $init = array())
    {
        $this->addStatements($init);
    }

    /*
     * checks if there is at least one statement for resource $s
     *
     * @param string $s - the subject IRI of searched statement
     * @return boolean
     */
    public function hasS($s)
    {
        if (!is_string($s)) {
            throw new Erfurt_Exception('need an IRI string as first parameter');
        }
        if (isset($this->_statements[$s])) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * checks if there is at least one statement with the object $o
     *
     * @param array $o - an array with the keys 'type' and 'value'
     * @param string $o['type'] - the type of the object ('uri', 'literal' or 'bnode')
     * @param string $o['value'] - the value of the object depending on the type
     */
    public function hasO(array $o)
    {
        if ($o === null) {
            throw new Erfurt_Exception('need an IRI string as first parameter');
        }

        foreach ($this->_statements as $subject => $predicates) {
            foreach ($predicates as $predicate => $objects) {
                foreach ($objects as $object) {
                    if ($object['type'] == $o[type] && $object['value'] == $o['value']) {
                        return true;
                    }
                }
            }
        }

        // sorry for the worst case costs
        return $false;
    }

    /*
     * checks if there is at least one statement for resource $s with
     * predicate $p
     *
     * @param string $s - the subject IRI of searched statement
     * @param string $p - the predicate IRI of searched statement
     * @return boolean
     */
    public function hasSP($s, $p)
    {
        if (!$this->hasS($s)) {
            return false;
        } else {
            if ($p == null) {
                throw new Erfurt_Exception('need an IRI string as second parameter');
            }
            if (isset($this->_statements[$s][$p])) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * search for statements where S, P and the value of O is fix and return
     * true if at least one statement is found and false if no statement found
     *
     * @param string $s - the subject IRI of searched statement
     * @param string $p - the predicate IRI of searched statement
     * @param string $value - the value of the object of the the searched statement
     * @param string $matchType - strict for strict match, preg for preg_match
     * @return boolean
     */
    public function hasSPvalue($s, $p, $value, $matchType = 'strict')
    {
        if ($value == null) {
            throw new Erfurt_Exception('need a value string as third parameter');
        } else {
            $values = $this->getValues($s, $p);
            foreach ($values as $key => $object) {
                switch ($matchType) {
                    case 'strict':
                        if ($object['value'] == $value) {
                            return true;
                        }
                        break;
                    case 'preg':
                        // the pattern is given by function param value
                        // the object value is tested against the pattern
                        if (preg_match($value, $object['value']) == 1) {
                            return true;
                        }
                        break;
                    default:
                        throw new Erfurt_Exception('unknown matchType, use strict or preg');
                        break;
                }
            }
            return false;
        }
    }

    /*
     * counts statements where S and P is fix
     * return 0 if no statement was found or an positive integer
     *
     * @param string $s - the subject IRI of searched statement
     * @param string $p - the predicate IRI of searched statement
     * @return int
     */
    public function countSP($s, $p)
    {
        if (!$this->hasSP($s, $p)) {
            return 0;
        } else {
            return count($this->_statements[$s][$p]);
        }
    }

    /*
     * returns all predicate/object tupel of a given subject IRI
     *
     * @param string $s - the subject IRI
     * @return array
     */
    public function getPO($s)
    {
        if (!$this->hasS($s)) {
            return array();
        } else {
            return $this->_statements[$s];
        }
    }

    /*
     * returns all subject/predicate/object tupel of a given subject IRI
     *
     * @param string $s - the subject IRI
     * @param array $o - the object array
     * @return array
     */
    public function getP($s, array $o)
    {
        $results = array();
        if ($this->hasS($s)) {
            foreach ($this->_statements[$s] as $predicate => $objects) {
                foreach ($objects as $object) {
                    if ($object['type'] == $o['type'] && $object['value'] == $o['value']) {
                        if (!isset($results[$s])) {
                            $results[$s] = array();
                        }
                        if (!isset($results[$s][$predicate])) {
                            $results[$s][$predicate] = array();
                        }
                        $results[$s][$predicate][] = $o;
                    }
                }
            }
        }

        return $results;
    }

    /*
     * returns an array of values from statements where S and P was given
     *
     * @param string $s - the subject IRI of searched statement
     * @param string $p - the predicate IRI of searched statement
     * @return array
     */
    public function getValues($s, $p)
    {
        if (!$this->hasSP($s, $p)) {
            return array();
        } else {
            return $this->_statements[$s][$p];
        }
    }

    /*
     * returns the first object value of a statement where S and P was given
     *
     * @param string $s - the subject IRI of searched statement
     * @param string $p - the predicate IRI of searched statement
     * @return string|null
     */
    public function getValue($s, $p)
    {
        if (!$this->hasSP($s, $p)) {
            return null;
        } else {
            return $this->_statements[$s][$p][0]['value'];
        }
    }

    /*
     * return the statement array, optional limited to a subject IRI
     *
     * @param string $s - the subject IRI of searched statements
     * @return array
     */
    public function getStatements($s = null)
    {
        if ($s == null) {
            return $this->_statements;
        } else {
            if ($this->hasS($s)) {
                return array( $s => $this->_statements[$s] );
            } else {
                return array();
            }
        }
    }

    /*
     * checks if there is at least one statement with the object $o
     *
     * @param array $o - an array with the keys 'type' and 'value'
     * @param string $o['type'] - the type of the object ('uri', 'literal' or 'bnode')
     * @param string $o['value'] - the value of the object depending on the type
     */
    public function getSP(array $o)
    {
        if (!is_array($o)) {
            throw new Erfurt_Exception('need an object array as first parameter');
        }

        $results = array();

        foreach ($this->_statements as $subject => $predicates) {
            foreach ($predicates as $predicate => $objects) {
                foreach ($objects as $object) {
                    if ($object['type'] == $o['type'] && $object['value'] == $o['value']) {
                        if (!isset($results[$subject])) {
                            $results[$subject] = array();
                        }
                        if (!isset($results[$subject][$predicate])) {
                            $results[$subject][$predicate] = array();
                        }
                        $results[$subject][$predicate][] = $o;
                    }
                }
            }
        }

        // sorry for the worst case costs
        return $results;
    }

    /*
     * This adds a statement array to the model by merging the arrays
     * This function is the base for all other add functions
     *
     * @param array $statements - a php statement array
     */
    public function addStatements(array $statements)
    {
        $model = $this->_statements;
        foreach ($statements as $subjectUrn => $subjectArray) {
            if (!isset($model[$subjectUrn])) {
                // new subject
                $model[$subjectUrn] = $subjectArray;
            } else {
                // existing subject
                foreach ($subjectArray as $predicateUrn => $predicateArray) {
                    if (!isset($model[$subjectUrn][$predicateUrn])) {
                        // new predicate on subject
                        $model[$subjectUrn][$predicateUrn] = $predicateArray;
                    } else {
                        // existing predicate on subject
                        foreach ($predicateArray as $objectArray) {
                            if (!in_array($objectArray, $model[$subjectUrn][$predicateUrn])) {
                                // new object for subject/predicate pattern
                                $model[$subjectUrn][$predicateUrn][] = $objectArray;
                            } else {
                                // same triple
                            }
                        }
                    }
                }
            }
        }
        $this->_statements = $model;
    }

    /*
     * adds multiple triples coming from the result of an extended SPARQL query
     */
    public function addStatementsFromSPOQuery(array $res)
    {
        foreach ($res['bindings'] as $binding) {
            $this->addStatementFromExtendedFormatArray(
                $binding['s'],
                $binding['p'],
                $binding['o']
            );
        }
    }

    /*
     * adds a triple based on the result of an extended SPARQL query
     */
    public function addStatementFromExtendedFormatArray(array $s, array $p, array $o)
    {
        $typeO = $o['type'];
        $object = array();
        $object['value'] = $o['value'];
        switch ($typeO) {
            case 'uri':
                $object['type'] = 'uri';
                break;
            case 'typed-literal':
                $object['type'] = 'literal';
                $object['datatype'] = $o['datatype'];
                break;
            case 'literal':
                $object['type'] = 'literal';
                if (isset($o['xml:lang'])) {
                    $object['lang'] = $o['xml:lang'];
                }
                break;
            case 'bnode':
                $object['type'] = 'bnode';
                break;
            default:
                return; // correct way to skip unwanted types
                break;
        }

        $statement = array();
        $s = $s['value']; // is always an IRI (or bnode)
        $p = $p['value']; // is always an IRI

        $pArray[$p] = array(0 => $object);
        $statement[$s] = $pArray;

        $this->addStatements($statement);
    }

    /*
     * add a single statement where the object is a literal
     *
     * @param string $subject   - the statement subject IRI string
     * @param string $predicate - the statement predicate IRI string
     * @param string $literal   - the literal value string
     * @param string $lang      - the optional xml:lang identifier string
     * @param string $datatype  - the optional datatype IRI string
     */
    public function addAttribute($subject, $predicate, $literal = "", $lang = null, $datatype = null)
    {
        if ($subject == null) {
            throw new Erfurt_Exception('need a subject IRI as first parameter');
        } else if ($predicate == null) {
            throw new Erfurt_Exception('need a predicate IRI as second parameter');
        }

        $statements = array();

        // create the object array
        $o = array();
        $o['type'] = 'literal';
        $o['value'] = $literal;
        if (is_string($lang)) {
            $o['lang'] = $lang;
        } else if (is_string($datatype)) {
            $o['datatype'] = $datatype;
        }

        // fill object array into predicate array
        $p =  array();
        $p[$predicate] = array();
        $p[$predicate][] = $o;

        // fill the predicate array into the statements array
        $statements[$subject] = $p;
        // add the statements array to the model
        $this->addStatements($statements);
    }

    /*
     * add a single statement where the object is a resource
     *
     * @param string $subject  - the statement subject IRI string
     * @param string $relation - the statement predicate IRI string
     * @param string $object   - the statement object IRI string
     */
    public function addRelation($subject, $relation, $object = null)
    {
        if ($subject == null) {
            throw new Erfurt_Exception('need a subject IRI as first parameter');
        } else if ($relation == null) {
            throw new Erfurt_Exception('need a predicate IRI as second parameter');
        } else if ($object == null) {
            throw new Erfurt_Exception('need an object IRI as second parameter');
        }

        $statements = array();

        // create the object array
        $o = array();
        $o['type'] = 'uri';
        $o['value'] = $object;

        // fill object array into predicate array
        $p =  array();
        $p[$relation] = array();
        $p[$relation][] = $o;

        // fill the predicate array into the statements array
        $statements[$subject] = $p;

        // add the statements array to the model
        $this->addStatements($statements);
    }

    /**
     * removes all statements of a given subject
     *
     * @param string $s
     */
    public function removeS($s)
    {
        if ($this->hasS($s)) {
            unset($this->_statements[$s]);
        }
    }

    /**
     * removes a predicate p (and its values) of a subject s
     *
     * @param string $s
     * @param string $p
     */
    public function removeSP($s, $p)
    {
        if ($this->hasSP($s, $p)) {
            unset($this->_statements[$s][$p]);

            //check if this was the last
            if (count($this->_statements[$s]) == 0) {
                unset($this->_statements[$s]);
            }
        }
    }

    /*
     * returns an array of all subjects
     */
    public function getSubjects()
    {
        return array_keys($this->_statements);
    }
}
