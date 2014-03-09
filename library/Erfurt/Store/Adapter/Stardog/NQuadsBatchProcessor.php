<?php

/**
 * Batch processor that adds data in NQuads format.
 *
 * Stardog follows an NQuads specification that does not assume UTF-8 encoding of
 * strings ({@link http://sw.deri.org/2008/07/n-quads/}). Therefore, special escaping
 * rules must be applied.
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
        return $this->encodeNonAsciiCharacters(rtrim($data));
    }

    /**
     * Encodes non-ASCII characters in a NQuad document that is UTF-8 encoded.
     *
     * @param string $data
     * @return string
     * @see http://www.w3.org/TR/2004/REC-rdf-testcases-20040210/#ntrip_strings
     */
    protected function encodeNonAsciiCharacters($data)
    {
        $pattern = '/[\x{0}-\x{8}\x{B}-\x{C}\x{E}-\x{1F}\x{7F}-\x{FFFF}]/u';
        return preg_replace_callback ($pattern, function (array $matches) {
            $character = $matches[0];
            return trim(json_encode($character), '"');
        }, $data);
    }

}
