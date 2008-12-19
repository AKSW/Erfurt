<?php

class Erfurt_Versioning_StoreStub
{    
    public function sqlQuery($sql)
    {
        
        $sql = substr($sql, 7); // Remove SELECT
        
        $variables = substr($sql, 0, strpos($sql, 'FROM'));
        
        $keys = explode(', ', $variables);
        $result = array();
        
        $match = array();
        preg_match('/(LIMIT ){1,1}(\d{1,})/', $sql, $match);
        
        for ($i=0; $i<$match[2]; ++$i) {
            $result[$i] = array();
            
            foreach ($keys as $k) {
                $result[$i][trim($k)] = 'ttt' . $i;
            }
        }
        
        return $result;
    }
    
    public function lastInsertId()
    {
        return 1;
    }
}



