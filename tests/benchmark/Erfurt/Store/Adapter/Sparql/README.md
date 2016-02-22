# Connector Benchmarks #

This directory contains several benchmark scenarios that can be used
to test the performance of any SPARQL connector.

Read the doc comment of \Erfurt_Store_Adapter_Sparql_AbstractConnectorAthleticEvent
to learn how to provide a benchmark setup for a connector.

Afterwards it should be sufficient to extend a benchmark scenario to be able to
run the related events for the connector:

    class Erfurt_Store_Adapter_MyConnector_AddTriplesEvent
        extends Erfurt_Store_Adapter_Sparql_AbstractAddTriplesAthleticEvent
    {

    }