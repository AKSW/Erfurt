<?php

use Doctrine\DBAL\Schema\OracleSchemaManager;

/**
 * Special schema manager that contains some workarounds for
 * auto increment handling etc.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 11.01.14
 */
class Erfurt_Store_Adapter_Oracle_Doctrine_SchemaManager extends OracleSchemaManager
{

    /**
     * @param string $table
     *
     * @return boolean
     */
    public function dropAutoincrement($table)
    {
        foreach ($this->listTableColumns($table) as $column) {
            /* @var \Doctrine\DBAL\Schema\Column */
            if ($column->getAutoincrement()) {
                // At least one column is marked as auto increment.
                // Therefore, try to drop it.
                return parent::dropAutoincrement($table);
            }
        }
        return true;
    }

}
