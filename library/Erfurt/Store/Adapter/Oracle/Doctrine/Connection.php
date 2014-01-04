<?php

use Doctrine\DBAL\Driver\OCI8\OCI8Connection;
use Doctrine\DBAL\Driver\OCI8\OCI8Statement;

/**
 * Custom connection class that avoids problems with positional parameters.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 04.01.14
 */
class Erfurt_Store_Adapter_Oracle_Doctrine_Connection extends OCI8Connection
{

    /**
     * {@inheritdoc}
     *
     * @param string $prepareString
     * @return OCI8Statement|\Doctrine\DBAL\Driver\Statement
     */
    public function prepare($prepareString)
    {
        return new Erfurt_Store_Adapter_Oracle_Doctrine_Statement($this->dbh, $prepareString, $this);
    }

}
