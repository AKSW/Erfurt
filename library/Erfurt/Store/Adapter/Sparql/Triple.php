<?php

/**
 * Represents a triple that contains subject, predicate and object.
 *
 * In contrast to a TriplePattern, a triple must have concrete values
 * for all of its parts.
 *
 * Design consideration: Triple extends TriplePattern as it *is* a pattern
 * that specifies all triple parts.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.01.14
 */
class Erfurt_Store_Adapter_Sparql_Triple extends Erfurt_Store_Adapter_Sparql_TriplePattern
{

    /**
     * Creates a triple that contains the given components.
     *
     * Null can be passed to indicate that every value is allowed
     * at that position.
     *
     * @param string $subject
     * @param string $predicate
     * @param array(string=>string) $object
     * @throws \InvalidArgumentException If a placeholder is provided.
     */
    public function __construct($subject, $predicate, array $object)
    {
        if ($subject === null) {
            throw new InvalidArgumentException('Concrete value must be provided as subject.');
        }
        if ($predicate === null) {
            throw new InvalidArgumentException('Concrete value must be provided as predicate.');
        }
        parent::__construct($subject, $predicate, $object);
    }

}
