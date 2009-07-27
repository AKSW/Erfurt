<?php
/**
 * Determines the offset in a row of sql queries.
 *
 * This class was originally adopted from rdfapi-php (@link http://sourceforge.net/projects/rdfapi-php/).
 * It was modified and extended in order to fit into Erfurt.
 *
 * @subpackage sparql
 * @author Christian Weiske <cweiske@cweiske.de>
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 * @version	$Id: $
 */
class Erfurt_Sparql_EngineDb_Offsetter
{
    protected $_engine;
    protected $_query;
    
    public function __construct($engine, Erfurt_Sparql_Query $query)
    {
        $this->_engine = $engine;
        $this->_query = $query;
    }
    
    /**
     * Determines the offset in the sqls, the position to start from.
     */
    public function determineOffset($arSqls)
    {
        $arSM = $this->_query->getSolutionModifier();

        if ($arSM['offset'] === null) {
            return array(0, 0);
        }

        $nCount = 0;
        foreach ($arSqls as $nId => $arSql) {
            $nCurrentCount = $this->_getCount($arSql);

            if ($nCurrentCount + $nCount > $arSM['offset']) {
                return array($nId, $arSM['offset'] - $nCount);
            }
            $nCount += $nCurrentCount;
        }
        
        //nothing found - no results for this offset
        return array(count($arSqls), 0);
    }

    /**
     * Returns the number of rows that the given query will return.
     *
     * @param array $arSql Array with sql parts and at least keys 'from' and 'where' set.
     * @return int Number of rows returned.
     */
    protected function _getCount($arSql)
    {   
        require_once 'Erfurt/Sparql/EngineDb/SqlMerger.php';
        $sql = Erfurt_Sparql_EngineDb_SqlMerger::getCount($this->_query, $arSql);
        
        $dbResult = $this->_engine->sqlQuery($sql);

        $nCount = 0;
        foreach ($dbResult as $row) {
            $nCount = intval($row['count']);
            break;
        }
        return $nCount;
    }
}
