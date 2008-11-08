return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'PREFIX  xsd: <http://www.w3.org/2001/XMLSchema#>
    PREFIX  : <http://example.org/things#>
    SELECT  ?x ?v
    WHERE
        { ?x :p ?v . 
          FILTER (str(?v) = "zzz") .
        }'
);
