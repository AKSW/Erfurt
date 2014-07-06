<?php

use Doctrine\DBAL\Driver\OCI8\Driver as OracleDriver;
use Doctrine\DBAL\Types\Type;

/**
 * Custom driver class that avoids problems with positional parameters.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 04.01.14
 */
class Erfurt_Store_Adapter_Oracle_Doctrine_Driver extends OracleDriver
{

    /**
     * {@inheritdoc}
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = array())
    {
        if (!Type::hasType(\Erfurt_Store_Adapter_Oracle_Doctrine_TripleType::TRIPLE)) {
            Type::addType(
                \Erfurt_Store_Adapter_Oracle_Doctrine_TripleType::TRIPLE,
                'Erfurt_Store_Adapter_Oracle_Doctrine_TripleType'
            );
        }
        if (isset($params['pool'])) {
            // Set the name of the connection pool.
            ini_set('oci8.connection_class', $params['pool']);
        }
        return new Erfurt_Store_Adapter_Oracle_Doctrine_Connection(
            $username,
            $password,
            $this->_constructDsn($params),
            isset($params['charset']) ? $params['charset'] : null,
            isset($params['sessionMode']) ? $params['sessionMode'] : OCI_DEFAULT,
            isset($params['persistent']) ? $params['persistent'] : false
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getSchemaManager(\Doctrine\DBAL\Connection $conn)
    {
        return new \Erfurt_Store_Adapter_Oracle_Doctrine_SchemaManager($conn);
    }

}
