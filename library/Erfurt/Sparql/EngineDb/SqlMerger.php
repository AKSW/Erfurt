<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Creates an sql string from an sql array
 *
 * @author Christian Weiske <cweiske@cweiske.de>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 * @package Erfurt_Sparql_EngineDb
 */
class Erfurt_Sparql_EngineDb_SqlMerger
{
    public static function getSelect(Erfurt_Sparql_Query $query, $arSqls, $strAdditional = '')
    {
        if (count($arSqls) == 1) {
            return implode('', $arSqls[0]) . $strAdditional;
        }

        //union
        $strUnion = 'UNION' .
            ($query->getResultForm() == 'select distinct' ? '' : ' ALL');
        $ar = array();
        foreach ($arSqls as $arSql) {
            $ar[] = implode('', $arSql) . $strAdditional;
        }
        return '(' . implode(') ' . $strUnion . ' (', $ar) . ')';
    }//public static function getSelect(Query $query, $arSqls, $strAdditional = '')



    public static function getCount(Erfurt_Sparql_Query $query, $arSqls, $strAdditional = '')
    {
        if (count($arSqls) == 1) {
            return 'SELECT COUNT(*) as count ' . $arSqls[0]['from'] . $arSqls[0]['where'] . $strAdditional;
        }

        $ar = array();
        foreach ($arSqls as $arSql) {
            $ar[] = implode('', $arSql) . $strAdditional;
        }
        return 'SELECT (' . implode(') + (', $ar) . ') as count';
    }//public static function getCount(Query $query, $arSqls, $strAdditional = '')

}
