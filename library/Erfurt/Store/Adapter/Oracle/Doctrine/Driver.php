<?php

use Doctrine\DBAL\Driver\OCI8\Driver as OracleDriver;

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
        return new Erfurt_Store_Adapter_Oracle_Doctrine_Connection(
            $username,
            $password,
            $this->_constructDsn($params),
            isset($params['charset']) ? $params['charset'] : null,
            isset($params['sessionMode']) ? $params['sessionMode'] : OCI_DEFAULT,
            isset($params['persistent']) ? $params['persistent'] : false
        );
    }

}
