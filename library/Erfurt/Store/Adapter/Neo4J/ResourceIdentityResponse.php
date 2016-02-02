<?php

use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\ResponseClassInterface;

/**
 * Extracts the resource identity from a Neo4j API response.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 20.05.14
 */
class Erfurt_Store_Adapter_Neo4J_ResourceIdentityResponse implements ResponseClassInterface
{

    /**
     * Returns the resource identity from the response.
     *
     * @param OperationCommand $command
     * @return string
     */
    public static function fromCommand(OperationCommand $command)
    {
        $response = $command->getResponse()->json();
        return $response['self'];
    }

}
