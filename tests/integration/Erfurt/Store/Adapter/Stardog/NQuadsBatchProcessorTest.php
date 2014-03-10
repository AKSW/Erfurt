<?php

/**
 * Tests the NQuads batch processor.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.03.14
 * @group Stardog
 */
class Erfurt_Store_Adapter_Stardog_NQuadsBatchProcessorTest
    extends Erfurt_Store_Adapter_Stardog_AbstractBatchProcessorTestCase
{

    /**
     * Checks if the batch processor encodes umlauts correctly.
     */
    public function testPersistEncodesUmlautsCorrectly()
    {
        $quad = new Erfurt_Store_Adapter_Sparql_Quad(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type'  => 'literal',
                'value' => 'hello wörld'
            ),
            'http://example.org/graph'
        );

        $this->processor->persist(array($quad));

        $query = 'SELECT * FROM <http://example.org/graph> WHERE { ?s ?p "hello wörld" . }';
        $this->assertNumberOfRowsSelected(1, $query);
    }

    /**
     * Creates the batch processor that is used in the tests.
     *
     * @return Erfurt_Store_Adapter_Sparql_BatchProcessorInterface
     */
    protected function createProcessor()
    {
        $client = $this->helper->getDataAccessClient();
        return new Erfurt_Store_Adapter_Stardog_NQuadsBatchProcessor($client);
    }

}
