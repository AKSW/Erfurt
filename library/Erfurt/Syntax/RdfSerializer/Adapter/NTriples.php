<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

require_once 'Erfurt/Syntax/RdfSerializer/Adapter/Interface.php';

/**
 * @package   Erfurt_Syntax_RdfSerializer_Adapter
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @author    Natanael Arndt <arndtn@gmail.com>
 * @copyright Copyright (c) 2014 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Syntax_RdfSerializer_Adapter_NTriples implements Erfurt_Syntax_RdfSerializer_Adapter_Interface
{
    protected $_store = null;
    protected $_graphUri = null;

    private $_resultString;

    public function serializeQueryResultToString($query, $graphUri, $pretty = false, $useAc = true)
    {
        $this->_graphUri = $graphUri;

        $query->setLimit(1000);
        $s = new Erfurt_Sparql_Query2_Var('resourceUri');
        $p = new Erfurt_Sparql_Query2_Var('p');
        $o = new Erfurt_Sparql_Query2_Var('o');
        if (strstr((string)$query, '?resourceUri ?p ?o') === false) {
            if ($query instanceof Erfurt_Sparql_Query2) {
                $query->addTriple($s, $p, $o);
            } else {
                //should not happen
                throw new OntoWiki_Exception(
                    'serializeQueryResultToString expects the query to contain the triple ' .
                    '?resourceUri ?p ?o .'
                );
            }
        }

        if ($query instanceof Erfurt_Sparql_Query2) {
            $query->removeAllProjectionVars();
            $query->addProjectionVar($s);
            $query->addProjectionVar($p);
            $query->addProjectionVar($o);
        } else if ($query instanceof Erfurt_Sparql_SimpleQuery) {
            $query->setProloguePart('SELECT ?resourceUri ?p ?o');
        }

        $this->_resultString = '';

        $offset = 0;
        while (true) {
            $query->setOffset($offset);
            $result = $this->_getStore()->sparqlQuery(
                $query,
                array(
                    'result_format'   => 'extended',
                    'use_owl_imports' => false,
                    'use_additional_imports' => false,
                    'use_ac' => $useAc
                )
            );
            foreach ($result['results']['bindings'] as $row) {
                $s     = $row['resourceUri']['value'];
                $p     = $row['p']['value'];
                $o     = $row['o']['value'];
                $sType = $row['resourceUri']['type'];
                $oType = $row['o']['type'];
                $lang  = isset($row['o']['xml:lang']) ? $row['o']['xml:lang'] : null;
                $dType = isset($row['o']['datatype']) ? $row['o']['datatype'] : null;
                $this->handleStatement($s, $p, $o, $sType, $oType, $lang, $dType);
            }

            if (count($result['results']['bindings']) < 1000) {
                break;
            }

            $offset += 1000;
        }
        return $this->_resultString;
    }

    public function serializeGraphToString($graphUri, $pretty = false, $useAc = true)
    {
        //construct query
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart('SELECT ?resourceUri ?p ?o');
        $query->addFrom($graphUri);
        $query->setWherePart('WHERE { ?resourceUri ?p ?o . }');
        $query->setOrderClause('?resourceUri');

        return $this->serializeQueryResultToString($query, $graphUri, $pretty, $useAc);
    }

    public function serializeResourceToString (
        $resource, $graphUri, $pretty = false, $useAc = true, array $additional = array()
    )
    {
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart('SELECT ?resourceUri ?p ?o');
        $query->addFrom($graphUri);
        /*
         * Why not as subject?
         * Because serializeQueryResultToString() expects ?resourceUri to be bound.
         */
        $query->setWherePart(
            'WHERE { ?resourceUri ?p ?o . FILTER (sameTerm(?resourceUri, <'.$resource.'>))}'
        );
        $query->setOrderClause('?resourceUri ?p ?o');

        return $this->serializeQueryResultToString($query, $graphUri, $pretty, $useAc);
    }

    public function handleStatement($s, $p, $o, $sType, $oType, $lang = null, $dType = null)
    {
        $this->_writeSubject($s, $sType);
        $this->_writePredicate($p);
        $this->_writeObject($o, $oType, $lang, $dType);
        $this->_resultString .= ' .' . PHP_EOL;
    }

    protected function _writeSubject($s, $sType)
    {
        if ($sType === 'uri') {
            $this->_writeUri($s);
        } else if ($sType === 'bnode') {
            $this->_writeBNode($s);
        } else {
            $this->_write($s);
        }

        $this->_resultString .= ' ';
    }

    protected function _writePredicate($p)
    {
        $this->_writeUri($p);

        $this->_resultString .= ' ';
    }

    protected function _writeObject($o, $oType, $lang = null, $dType = null)
    {
        if ($oType === 'uri') {
            $this->_writeUri($o);
        } else if ($oType === 'bnode') {
            $this->_writeBNode($o);
        } else {
            $this->_write('"');
            $this->_write(Erfurt_Syntax_Utils_Turtle::encodeString($o));
            $this->_write('"');

            if (null !== $lang) {
                $this->_write('@'.$lang);
            } else if (null !== $dType) {
                $this->_write('^^');
                $this->_writeUri($dType);
            }
        }
    }

    protected function _writeUri($uri)
    {
        $this->_write('<'.$uri.'>');
    }

    protected function _writeBNode($value)
    {
        if (strpos($value, '_:') == 0) {
            $this->_write($value);
        } else {
            $this->_write('_:'.$value);
        }
    }

    protected function _write($value)
    {
        $this->_resultString .= $value;
    }

    protected function _getStore()
    {
        if (null === $this->_store) {
            // TODO: refactor
            $this->_store = Erfurt_App::getInstance()->getStore();
        }

        return $this->_store;
    }
}
