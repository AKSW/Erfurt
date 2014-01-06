<?php

/**
 * Class that combines a SPARQL as well as a SQL adapter and just delegates
 * the calls to the interface methods.
 *
 * This allows one to separate SPARQL and SQL adapters and gives the opportunity
 * to create any combination of these.
 * Without these separation each SPARQL adapter must implement the SQL interface
 * to enable versioning support, even if SQL is not supported by it's architecture.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 06.01.14
 */
class Erfurt_Store_Adapter_SparqlSqlCombination
{

}
