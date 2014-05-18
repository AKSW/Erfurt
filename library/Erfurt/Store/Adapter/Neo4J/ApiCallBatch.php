<?php

use \Guzzle\Service\Command\CommandInterface;

/**
 * Holds a collection of commands that are executed as batch.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 18.05.14
 */
class Erfurt_Store_Adapter_Neo4J_ApiCallBatch
{

    /**
     * Current job number.
     *
     * @var integer
     */
    protected $jobNumber = 0;

    /**
     * Adds a command to the batch.
     *
     * @param CommandInterface $command
     * @return string Identifier that can be used to reference the result of the command in following commands.
     */
    public function addJob(CommandInterface $command)
    {

    }

    /**
     * Serializes the calls.
     *
     * This serialization is used as request body.
     *
     * @returns string
     */
    public function __toString()
    {
        return '';
    }

}
