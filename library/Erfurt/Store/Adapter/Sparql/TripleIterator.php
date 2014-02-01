<?php

/**
 * Helper class that allows the iteration over a set of nested statements as triples.
 *
 * Example:
 *
 *     $statements = array(
 *         'http://example.org/subject1' => array(
 *             'http://example.org/predicate1' => array(
 *                 array(
 *                     'type' => 'literal',
 *                     'value' => 'Hello world.'
 *                 )
 *             ),
 *             'http://example.org/predicate2' => array(
 *                 array(
 *                     'type' => 'uri',
 *                     'value' => 'http://example.org/object'
 *                 )
 *             )
 *         )
 *     );
 *     $iterator = new Erfurt_Store_Adapter_Sparql_TripleIterator($statements);
 *     foreach ($iterator as $triple) {
 *         /*@var $triple Erfurt_Store_Adapter_Sparql_Triple *\/
 *     }
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.01.14
 */
class Erfurt_Store_Adapter_Sparql_TripleIterator implements \Iterator
{

    /**
     * The nested array that contains the triples.
     *
     * @var array(string=>array(string=>array(string=>string)))
     */
    protected $statements = null;

    /**
     * The key of the current position in the subject-level list,
     * which is equal to the subject URI.
     *
     * @var string
     */
    protected $subject = null;

    /**
     * The key of the current position in the active predicate-level list,
     * which is equal to the predicate URI.
     *
     * @var string
     */
    protected $predicate = null;

    /**
     * The key of the current position in the active object-level list,
     * which is an integer that points to an object definition (as array).
     *
     * @var integer
     */
    protected $objectPosition = null;

    /**
     * @param array(string=>array(string=>array(string=>string))) $statements
     */
    public function __construct(array $statements)
    {
        $this->statements = $statements;
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->resetSubjectList();
    }

    /**
     * Checks if current position is valid.
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean Returns true on success or false on failure.
     */
    public function valid()
    {
        return isset($this->statements[$this->subject][$this->predicate][$this->objectPosition]);
    }

    /**
     * Return the current element.
     *
     * @link http://php.net/manual/en/iterator.current.php
     * @return Erfurt_Store_Adapter_Sparql_Triple
     */
    public function current()
    {
        $object = $this->statements[$this->subject][$this->predicate][$this->objectPosition];
        return new Erfurt_Store_Adapter_Sparql_Triple($this->subject, $this->predicate, $object);
    }

    /**
     * Return the key of the current element.
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->subject . ':' . $this->predicate . ':' . $this->objectPosition;
    }

    /**
     * Move forward to next element.
     *
     * @link http://php.net/manual/en/iterator.next.php
     */
    public function next()
    {
        if (next($this->statements[$this->subject][$this->predicate]) !== false) {
            $this->objectPosition = key($this->statements[$this->subject][$this->predicate]);
            return;
        }
        // End of object list reached, move to next in predicate list.
        if (next($this->statements[$this->subject]) !== false) {
            $this->predicate = key($this->statements[$this->subject]);
            $this->resetObjectList();
            return;
        }
        // End of predicate list reached, move to next in subject list.
        if (next($this->statements) !== false) {
            $this->subject = key($this->statements);
            $this->resetPredicateList();
            return;
        }
        // End of triple list reached.
        $this->subject        = null;
        $this->predicate      = null;
        $this->objectPosition = null;
    }

    /**
     * Resets the subject list to the first element.
     */
    protected function resetSubjectList()
    {
        if (reset($this->statements) === false) {
            // The list is empty.
            $this->subject        = null;
            $this->predicate      = null;
            $this->objectPosition = null;
            return;
        }
        $this->subject = key($this->statements);
        $this->resetPredicateList();
    }

    /**
     * Resets the current predicate list to the first element.
     */
    protected function resetPredicateList()
    {
        if (reset($this->statements[$this->subject]) === false) {
            // The list is empty.
            $this->predicate      = null;
            $this->objectPosition = null;
            return;
        }
        $this->predicate = key($this->statements[$this->subject]);
        $this->resetObjectList();
    }

    /**
     * Resets the current object list to the first element.
     */
    protected function resetObjectList()
    {
        if (reset($this->statements[$this->subject][$this->predicate]) === false) {
            // The list is empty.
            $this->objectPosition = null;
            return;
        }
        $this->objectPosition = key($this->statements[$this->subject][$this->predicate]);
    }

}
