return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'PREFIX ex:      <http://example.org/things#> 

    SELECT ?address
    WHERE { ?x ex:address ?address }
    ORDER BY ASC(?address)'
);
