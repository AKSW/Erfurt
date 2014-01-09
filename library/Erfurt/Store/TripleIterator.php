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
        // TODO: Implement rewind() method.
    }

    /**
     * Checks if current position is valid.
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean Returns true on success or false on failure.
     */
    public function valid()
    {
        // TODO: Implement valid() method.
    }

    /**
     * Return the current element.
     *
     * @link http://php.net/manual/en/iterator.current.php
     * @return Erfurt_Store_Triple
     */
    public function current()
    {
        // TODO: Implement current() method.
    }

    /**
     * Return the key of the current element.
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        // TODO: Implement key() method.
    }

    /**
     * Move forward to next element.
     *
     * @link http://php.net/manual/en/iterator.next.php
     */
    public function next()
    {
        // TODO: Implement next() method.
    }

}
