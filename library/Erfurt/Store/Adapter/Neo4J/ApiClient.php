<?php

use Guzzle\Common\Collection;
use Guzzle\Batch\BatchBuilder;
use Guzzle\Http\EntityBody;
use Guzzle\Http\RedirectPlugin;
use Guzzle\Log\MessageFormatter;
use Guzzle\Log\Zf1LogAdapter;
use Guzzle\Plugin\Log\LogPlugin;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

/**
 * HTTP client for the Neo4j REST API.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 17.05.14
 */
class Erfurt_Store_Adapter_Neo4J_ApiClient extends Client
{

    /**
     * Creates a new API client instance.
     *
     * @param array|Collection $config Configuration data
     * @return Erfurt_Store_Adapter_Stardog_ApiClient
     */
    public static function factory($config = array())
    {
        if (isset($config['base_url'])) {
            $config['base_url'] = rtrim($config['base_url'], '/') . '/db/data';
        }
        $client = parent::factory($config);
        $client->setDescription(ServiceDescription::factory(__DIR__ . '/Resources/Neo4jServiceDescription.json'));
        if (isset($config['log']) && $config['log'] !== null) {
            $adapter = new Zf1LogAdapter(
                new \Zend_Log(new \Zend_Log_Writer_Stream($config['log']))
            );
            $logPlugin = new LogPlugin($adapter, MessageFormatter::DEBUG_FORMAT);
            $client->addSubscriber($logPlugin);
        }
        return $client;
    }

    /**
     * Creates a node if it does not already exist. Returns the node identifier if
     * it is already available.
     *
     * @param string $index Name of the index that is used to check uniqueness.
     * @param string $identifier The unique identifier.
     * @param array(string=>string) $properties The unique properties of the node.
     * @return string Identifier of the created or retrieved node.
     */
    public function createUniqueNode($index, $identifier, array $properties = array())
    {
        $command = $this->buildCreateUniqueNodeCommand($index, $identifier, $properties);
        $result  = $command->execute();
        return $result['self'];
    }

    /**
     * Creates a unique relationship between two nodes.
     *
     * @param string $index Name of the index that is used to check uniqueness.
     * @param string $identifier The unique identifier.
     * @param string $start The identifier of the start node.
     * @param string $end The identifier of the end node.
     * @param string $type The type of the relation.
     * @return string The identifier of the created or retrieved relation.
     */
    public function createUniqueRelation($index, $identifier, $start, $end, $type)
    {
        $command = $this->buildCreateUniqueRelationCommand($index, $identifier, $start, $end, $type);
        $result  = $command->execute();
        return $result['self'];
    }

    /**
     * Creates a node if it does not already exist. Returns the node identifier if
     * it is already available.
     *
     * @param string $index Name of the index that is used to check uniqueness.
     * @param string $identifier The unique identifier.
     * @param array(string=>string) $properties The unique properties of the node.
     * @return \Guzzle\Service\Command\CommandInterface
     */
    public function buildCreateUniqueNodeCommand($index, $identifier, array $properties = array())
    {
        $parameters = array(
            'index'      => $index,
            'identifier' => $identifier,
            'properties' => (object)$properties
        );
        return $this->getCommand('createUniqueNode', $parameters);
    }

    /**
     * Builds a command that creates a unique relation.
     *
     * @param string $index Name of the index that is used to check uniqueness.
     * @param string $identifier The unique identifier.
     * @param string $start The identifier of the start node.
     * @param string $end The identifier of the end node.
     * @param string $type The type of the relation.
     * @return \Guzzle\Service\Command\CommandInterface
     */
    public function buildCreateUniqueRelationCommand($index, $identifier, $start, $end, $type)
    {
        $parameters = array(
            'index'      => $index,
            'identifier' => $identifier,
            'start'      => $start,
            'end'        => $end,
            'type'       => $type
        );
        return $this->getCommand('createUniqueRelation', $parameters);
    }

    /**
     * Executes multiple API calls as single batch.
     *
     * @param Erfurt_Store_Adapter_Neo4J_ApiCallBatch $batch
     * @return mixed
     */
    public function executeBatch(Erfurt_Store_Adapter_Neo4J_ApiCallBatch $batch)
    {
        $parameters = array(
            'batch' => $batch
        );
        $command = $this->getCommand('executeBatch', $parameters);
        return $command->execute();
    }

}
