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
 *     $iterator = new Erfurt_Store_TripleIterator($statements);
 *     foreach ($iterator as $triple) {
 *         /*@var $triple Erfurt_Store_Triple *\/
 *     }
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.01.14
 */
class Erfurt_Store_TripleIterator implements \Iterator
{

    /**
     * The nested array that contains the triples.
     *
     * @var array(string=>array(string=>array(string=>string)))
     */
    protected $statements = null;

    protected $subjectPosition = null;

    protected $predicatePosition = null;

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
        reset($this->statements);
        $this->subjectPosition   = key($this->statements);
        $this->predicatePosition = key($this->statements[$this->subjectPosition]);
        $this->objectPosition    = key($this->statements[$this->subjectPosition][$this->predicatePosition]);
    }

    /**
     * Checks if current position is valid.
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean Returns true on success or false on failure.
     */
    public function valid()
    {
        return isset($this->statements[$this->subjectPosition][$this->predicatePosition][$this->objectPosition]);
    }

    /**
     * Return the current element.
     *
     * @link http://php.net/manual/en/iterator.current.php
     * @return Erfurt_Store_Triple
     */
    public function current()
    {
        $object = $this->statements[$this->subjectPosition][$this->predicatePosition][$this->objectPosition];
        return new Erfurt_Store_Triple($this->subjectPosition, $this->predicatePosition, $object);
    }

    /**
     * Return the key of the current element.
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->subjectPosition .':' . $this->predicatePosition . ':' . $this->objectPosition;
    }

    /**
     * Move forward to next element.
     *
     * @link http://php.net/manual/en/iterator.next.php
     */
    public function next()
    {
        if (next($this->statements[$this->subjectPosition][$this->predicatePosition]) === false) {
            // End of object list reached, move to next in predicate list.
            if (next($this->statements[$this->subjectPosition]) === false) {
                // End of predicate list reached, move to next in subject list.
                if (next($this->statements) === false) {
                    // End of triple list reached.
                    $this->subjectPosition   = null;
                    $this->predicatePosition = null;
                    $this->objectPosition    = null;
                    return;
                }
            }
        }
        $this->subjectPosition   = key($this->statements);
        $this->predicatePosition = key($this->statements[$this->subjectPosition]);
        $this->objectPosition    = key($this->statements[$this->subjectPosition][$this->predicatePosition]);
    }

}
