<?php
class Erfurt_Sparql_EngineDb_SqlGenerator
{
    /**
    *   Column names for subjects, predicates and
    *   objects for easy access via their character
    *   names (spo).
    *
    *   @var array
    */
    public static $arTableColumnNames = array(
        's' => array(
            'value' => 'subject',
            'is'    => 'subject_is'
        ),
        'p' => array(
            'value' => 'predicate'
        ),
        'o' => array(
            'value' => 'object',
            'is'    => 'object_is'
        )
    );
}

?>
