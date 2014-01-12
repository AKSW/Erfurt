<?php
/**
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package Erfurt_Cache_Backend
 */
class Erfurt_Cache_Backend_QueryCache_DatabaseTest extends Erfurt_TestCase
{
    /** @var Erfurt_Cache_Backend_QueryCache_Database */
    private $_cacheBackend = null;

    public function setUp()
    {
        $this->markTestNeedsTestConfig();
        $this->markTestNeedsDatabase();

        $config = $this->getTestConfig();
        $config->cache->frontend->enable = TRUE;
        $config->cache->query->enable = TRUE;

        $this->_cacheBackend = Erfurt_App::getInstance(false)->getQueryCache()->getBackend();

        parent::setUp();
    }

    public function tearDown()
    {
        if ($this->_dbWasUsed) {
            // clean up cache database tables
            $this->_cacheBackend->uninstall();
        }

        parent::tearDown();
    }

    public function testSaveWithSingleQuoteUriGithubOntoWikiIssue116()
    {
        $sparql = <<<EOF
SELECT ?p ?o
WHERE {
   <http://dbpedia.org/resource/Category:Chevaliers_of_the_L%C3%A9gion_d'honneur> ?p ?o
}
EOF;
        $resultFormat = 'plain';
        $queryId = md5($sparql.$resultFormat);
        $modelIris = array('http://example.org/modelXyz/');
        $triplesPatterns = array(array(
            'subject'   => "http://dbpedia.org/resource/Category:Chevaliers_of_the_L%C3%A9gion_d'honneur",
            'predicate' => 'p',
            'object'    => 'o'
        ));
        $queryResult = serialize(array());
        $duration = 1000;

        $this->_cacheBackend->save($queryId, $sparql, $modelIris, $triplesPatterns, $queryResult, $duration);
    }
}
