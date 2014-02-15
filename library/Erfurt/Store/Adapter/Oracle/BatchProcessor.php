<?php

use Doctrine\DBAL\Connection;

/**
 * Helper class that processes triple inserts and updates as batch.
 *
 * It is up to the batch processor to choose the method that is most
 * suitable to store a given number of triples.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.02.14
 */
class BatchProcessor
{

    /**
     * Creates a batch processor that uses the provided database connection.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {

    }

    /**
     * Stores the provided triples.
     *
     * @param array(\Erfurt_Store_Adapter_Sparql_Triple) $triples
     */
    public function persist(array $triples)
    {

    }

}
