<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @package Erfurt_Sparql_EngineDb
 */
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
