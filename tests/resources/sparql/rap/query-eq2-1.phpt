return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'PREFIX  xsd: <http://www.w3.org/2001/XMLSchema#>
    PREFIX  : <http://example.org/things#>
    SELECT  ?v1 ?v2
    WHERE
        { ?x1 :p ?v1 .
          ?x2 :p ?v2 . 
          FILTER (?v1 = ?v2)
        }'
);
