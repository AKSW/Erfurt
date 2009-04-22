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
    public $arTableColumnNames = array(
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
        ),
        'datatype' => array(
            'value' => 'l_datatype',
            'empty' => "=''",
            'not_empty' => "!=''"
        ),
        'language' => array(
            'value' => 'l_language',
            'empty' => "=''",
            'not_empty' => "!=''"
        )
    );
    
    public $arTypeValues = array(
        'r' => '"r"',
        'b' => '"b"',
        'l' => '"l"'
    );
    
    public $strColEmpty = '= ""';
    public $strColNotEmpty = '!= ""';
}
