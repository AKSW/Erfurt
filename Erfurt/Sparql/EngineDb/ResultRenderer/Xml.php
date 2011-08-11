<?php
require_once 'Erfurt/Sparql/EngineDb/ResultRenderer/Extended.php';

/**
 * Result renderer that creates a JSON object string containing the result of a SPARQL query as defined in
 * @link http://www.w3.org/TR/rdf-sparql-json-res/.
 *
 * @subpackage sparql
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version	$Id: $
 */
class Erfurt_Sparql_EngineDb_ResultRenderer_Xml extends Erfurt_Sparql_EngineDb_ResultRenderer_Extended 
{
    /**
     * Converts the database results into the desired output format
     * and returns the result.
     *
     * @param array $arRecordSets Array of (possibly several) SQL query results.
     * @param Erfurt_Sparql_Query $query SPARQL query object
     * @param $engine Sparql Engine to query the database
     * @return array
     */
    public function convertFromDbResults($arRecordSets, Erfurt_Sparql_Query $query, $engine, $vars)
    {
        $result = parent::convertFromDbResults($arRecordSets, $query, $engine, $vars);
        
        $xmlString = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                     '<sparql xmlns="http://www.w3.org/2005/sparql-results#">' . PHP_EOL .
                     '<head>' . PHP_EOL;
         
        if (isset($result['head']['vars'])) {
            foreach ($result['head']['vars'] as $var) {
                $xmlString .= '<variable name="' . $var . '" />' . PHP_EOL;
            }
        }
        
        $xmlString .= '</head>' . PHP_EOL;
        
        if (isset($result['boolean'])) {
            $xmlString .= '<boolean>' . $result['boolean'] . '</boolean>' . PHP_EOL;
        } else {
            $xmlString .= '<results>' . PHP_EOL;
            
            foreach ($result['results']['bindings'] as $row) {
                $xmlString .= '<result>' . PHP_EOL;
                foreach ($row as $key=>$value) {
                    $xmlString .= '<binding name="' . $key . '">' . PHP_EOL;
                    
                    if ($value['type'] === 'bnode') {
                        $xmlString .= '<bnode>' . $value['value'] . '</bnode>' . PHP_EOL;
                    } else if ($value['type'] === 'uri') {
                        $xmlString .= '<uri>' . $value['value'] . '</uri>' . PHP_EOL;
                    } else if ($value['type'] === 'typed-literal') {
                        $xmlString .= '<literal datatype="' . $value['datatype'] . '">' . 
                                      $value['value'] . '</literal>' . PHP_EOL;
                    } else if (isset($value['xml:lang'])) {
                        $xmlString .= '<literal xml_lang="' . $value['xml:lang'] . '">' . 
                                      $value['value'] . '</literal>' . PHP_EOL;
                    } else {
                        $xmlString .= '<literal>' . $value['value'] . '</literal>' . PHP_EOL;
                    }
                    
                    $xmlString .= '</binding>' . PHP_EOL;
                }
                $xmlString .= '</result>' . PHP_EOL;
            }
            
            $xmlString .= '</results>' . PHP_EOL;
        }
        
        $xmlString .= '</sparql>' . PHP_EOL;            
        
        return $xmlString;        
    }
}
