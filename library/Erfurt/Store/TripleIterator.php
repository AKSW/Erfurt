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
class Erfurt_Store_TripleIterator
{

}
