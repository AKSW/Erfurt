<?php

/**
 * Batch processor that adds data in NQuads format.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.03.14
 */
class Erfurt_Store_Adapter_Stardog_NQuadsBatchProcessor implements Erfurt_Store_Adapter_Sparql_BatchProcessorInterface
{

    /**
     * The client that is used to interact with the store.
     *
     * @var Erfurt_Store_Adapter_Stardog_DataAccessClient
     */
    protected $client = null;

    /**
     * Creates a batch processor that uses the provided client.
     *
     * @param Erfurt_Store_Adapter_Stardog_DataAccessClient $client
     */
    public function __construct(Erfurt_Store_Adapter_Stardog_DataAccessClient $client)
    {
        $this->client = $client;
    }

    /**
     * Stores the provided quads.
     *
     * @param array(\Erfurt_Store_Adapter_Sparql_Quad) $quads
     */
    public function persist(array $quads)
    {
        if (count($quads) === 0) {
            return;
        }
        $this->client->import($this->toNQuads($quads), Erfurt_Store_Adapter_Stardog_DataAccessClient::FORMAT_NQUADS);
    }

    /**
     * Converts the provided quads into NQuad format (subject, predicate, object and context).
     *
     * @param array(\Erfurt_Store_Adapter_Sparql_Quad) $quads
     * @return string
     */
    protected function toNQuads(array $quads)
    {
        $data = '';
        foreach ($quads as $quad) {
            /* @var $quad \Erfurt_Store_Adapter_Sparql_Quad */
            $data .= $quad->format('?subject ?predicate ?object ?graph .') . PHP_EOL;
        }
        return rtrim($data);
    }

}
