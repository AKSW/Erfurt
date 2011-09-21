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
 */
class Erfurt_Rdf_MemoryModel
{
    private $statements = array();

    /*
     * model can be constructed with a given array
     */
    function __construct( array $init = array())
    {
        $this->addStatements($init);
    }

    /*
     * checks if there is at least one statement for resource $iri
     */
    public function hasS($s = null)
    {
        if ($s == null) {
            throw new Exception('need an IRI string as first parameter');
        }
        if (isset($this->statements[$s])) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * checks if there is at least one statement for resource $iri with
     * predicate $p
     */
    public function hasSP($s = null, $p = null )
    {
        if (!$this->hasS($s)) {
            return false;
        } else {
            if ($p == null) {
                throw new Exception('need an IRI string as second parameter');
            }
            if (isset($this->statements[$s][$p])) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * search for a value where S and P is fix
     */
    public function hasSPvalue($s = null, $p = null, $value = null)
    {
        if ($value == null) {
            throw new Exception('need a value string as third parameter');
        } else {
            $values = $this->getValues($s, $p);
            foreach ($values as $key => $object) {
                if ($object['value'] == $value) {
                    return true;
                }
            }
            return false;
        }
    }

    /*
     * count statements where S and P is fix
     */
    public function countSP($s = null, $p = null)
    {
        if (!$this->hasSP($s, $p)) {
            return 0;
        } else {
            return count($this->statements[$s][$p]);
        }
    }

    /*
     * returns an array of values where S and P is fix
     */
    public function getValues($s = null, $p = null)
    {
        if (!$this->hasSP($s, $p)) {
            return array();
        } else {
            return $this->statements[$s][$p];
        }
    }

    /*
     * returns the first object value where S and P is fix
     */
    public function getValue($s = null, $p = null)
    {
        if (!$this->hasSP($s, $p)) {
            return false;
        } else {
            return $this->statements[$s][$p][0]['value'];
        }
    }

    /*
     * return the statement array, limited to a subject uri
     */
    public function getStatements($iri = null)
    {
        if ($iri == null) {
            return $this->statements;
        } else {
            if ($this->hasS($iri)) {
                return array( $iri => $this->statements[$iri] );
            } else {
                return array();
            }
        }
    }

    /*
     * This adds a statement array to the model by merging the arrays
     * This function is the base for all other add functions
     */
    public function addStatements(array $statements)
    {
        $model = $this->statements;
        foreach ($statements as $subjectIri => $subjectArray) {
            if (!isset($model[$subjectIri])) {
                // new subject
                $model[$subjectIri] = $subjectArray;
            } else {
                // existing subject
                foreach ($subjectArray as $predicateIri => $predicateArray) {
                    if (!isset($model[$subjectIri][$predicateIri])) {
                        // new predicate on subject
                        $model[$subjectIri][$predicateIri] = $predicateArray;
                    } else {
                        // existing predicate on subject
                        foreach ($predicateArray as $objectArray) {
                            if (!in_array($objectArray, $model[$subjectIri][$predicateIri])) {
                                // new object for subject/predicate pattern
                                $model[$subjectIri][$predicateIri][] = $objectArray;
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
            default:
                /* blank nodes are ignore */
                /* be quiet here */
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
     * @param string $subject   - the statement subject URI string
     * @param string $predicate - the statement predicate URI string
     * @param string $literal   - the literal value string
     * @param string $lang      - the optional xml:lang identifier string
     * @param string $datatype  - the optional datatype URI string
     */
    public function addAttribute($subject = null, $predicate = null, $literal = "", $lang = null, $datatype = null)
    {
        if ($subject == null) {
            throw new Exception('need a subject URI as first parameter');
        } else if ($predicate == null) {
            throw new Exception('need a predicate URI as second parameter');
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
     * @param string $subject  - the statement subject URI string
     * @param string $relation - the statement predicate URI string
     * @param string $object   - the statement object URI string
     */
    public function addRelation($subject = null, $relation = null, $object = null)
    {
        if ($subject == null) {
            throw new Exception('need a subject URI as first parameter');
        } else if ($relation == null) {
            throw new Exception('need a predicate URI as second parameter');
        } else if ($object == null) {
            throw new Exception('need an object URI as second parameter');
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
}
