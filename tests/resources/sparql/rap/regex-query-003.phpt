return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'PREFIX  rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
    PREFIX  ex:  <http://example.com/#>

    SELECT ?val
    WHERE {
    	ex:foo rdf:value ?val .
    	FILTER regex(?val, "example\\.com")
    }'
);
