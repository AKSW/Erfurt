<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2011, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * A set of Statements (memory model) / ARC2 index / phprdf array
 *
 * @author {@link http://sebastian.tramp.name Sebastian Tramp}
 * @author Jonas Brekle <jonas.brekle@gmail.com>
 */
class Erfurt_Rdf_MemoryModel
{
    protected $statements = array();

    /*
     * model can be constructed with a given array
     */
    function __construct( array $init = array())
    {
        $this->addStatements($init);
    }

    /*
     * checks if there is at least one statement for resource $s
     *
     * @param string $s - the subject URN of searched statement
     * @return boolean
     */
    public function hasS($s)
    {
        if ($s === null) {
            throw new Exception('need an URN string as first parameter');
        }
        if (isset($this->statements[$s])) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * checks if there is at least one statement for resource $s with
     * predicate $p
     *
     * @param string $s - the subject URN of searched statement
     * @param string $p - the predicate URN of searched statement
     * @return boolean
     */
    public function hasSP($s, $p)
    {
        if (!$this->hasS($s)) {
            return false;
        } else {
            if ($p == null) {
                throw new Exception('need an URN string as second parameter');
            }
            if (isset($this->statements[$s][$p])) {
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
     * @param string $s - the subject URN of searched statement
     * @param string $p - the predicate URN of searched statement
     * @param string $value - the value of the object of the the searched statement
     * @param string $matchType - strict for strict match, preg for preg_match
     * @return boolean
     */
    public function hasSPvalue($s, $p, $value, $matchType = 'strict')
    {
        if ($value == null) {
            throw new Exception('need a value string as third parameter');
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
                        throw new Exception('unknown matchType, use strict or preg');
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
     * @param string $s - the subject URN of searched statement
     * @param string $p - the predicate URN of searched statement
     * @return int
     */
    public function countSP($s, $p)
    {
        if (!$this->hasSP($s, $p)) {
            return 0;
        } else {
            return count($this->statements[$s][$p]);
        }
    }

    /*
     * returns all predicate/object tupel of a given subject URN
     *
     * @param string $s - the subject URN
     * @return array
     */
    public function getPO($s)
    {
        if (!$this->hasS($s)) {
            return array();
        } else {
            return $this->statements[$s];
        }
    }

    /*
     * returns an array of values from statements where S and P was given
     *
     * @param string $s - the subject URN of searched statement
     * @param string $p - the predicate URN of searched statement
     * @return array
     */
    public function getValues($s, $p)
    {
        if (!$this->hasSP($s, $p)) {
            return array();
        } else {
            return $this->statements[$s][$p];
        }
    }

    /*
     * returns the first object value of a statement where S and P was given
     *
     * @param string $s - the subject URN of searched statement
     * @param string $p - the predicate URN of searched statement
     * @return string|null
     */
    public function getValue($s, $p)
    {
        if (!$this->hasSP($s, $p)) {
            return null;
        } else {
            return $this->statements[$s][$p][0]['value'];
        }
    }

    /*
     * return the statement array, optional limited to a subject URN
     *
     * @param string $s - the subject URN of searched statements
     * @return array
     */
    public function getStatements($s)
    {
        if ($s == null) {
            return $this->statements;
        } else {
            if ($this->hasS($s)) {
                return array( $s => $this->statements[$s] );
            } else {
                return array();
            }
        }
    }

    /*
     * This adds a statement array to the model by merging the arrays
     * This function is the base for all other add functions
     *
     * @param array $statements - a php statement array
     */
    public function addStatements(array $statements)
    {
        $model = $this->statements;
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
        $this->statements = $model;
    }

    /*
     * adds multiple triples coming from the result of an extended SPARQL query
     */
    public function addStatementsFromSPOQuery(array $res)
    {
        foreach($res['bindings'] as $binding){
            $this->addStatementFromExtendedFormatArray($binding['s'], $binding['p'], $binding['o']);
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
        $s = $s['value']; // is always an URN (or bnode)
        $p = $p['value']; // is always an URN

        $pArray[$p] = array(0 => $object);
        $statement[$s] = $pArray;

        $this->addStatements($statement);
    }

    /*
     * add a single statement where the object is a literal
     *
     * @param string $subject   - the statement subject URN string
     * @param string $predicate - the statement predicate URN string
     * @param string $literal   - the literal value string
     * @param string $lang      - the optional xml:lang identifier string
     * @param string $datatype  - the optional datatype URN string
     */
    public function addAttribute($subject, $predicate, $literal = "", $lang = null, $datatype = null)
    {
        if ($subject == null) {
            throw new Exception('need a subject URN as first parameter');
        } else if ($predicate == null) {
            throw new Exception('need a predicate URN as second parameter');
        }
        $newStatements = array();

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
     * @param string $subject  - the statement subject URN string
     * @param string $relation - the statement predicate URN string
     * @param string $object   - the statement object URN string
     */
    public function addRelation($subject, $relation, $object = null)
    {
        if ($subject == null) {
            throw new Exception('need a subject URN as first parameter');
        } else if ($relation == null) {
            throw new Exception('need a predicate URN as second parameter');
        } else if ($object == null) {
            throw new Exception('need an object URN as second parameter');
        }

        $newStatements = array();

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
            unset($this->statements[$s]);
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
            unset($this->statements[$s][$p]);

            //check if this was the last
            if(count($this->statements[$s]) == 0){
                unset($this->statements[$s]);
            }
        }
    }

    /*
     * returns an array of all subjects
     */
    public function getSubjects()
    {
        return array_keys($this->statements);
    }
}
