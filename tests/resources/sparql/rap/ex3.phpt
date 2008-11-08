return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'PREFIX  dc: <http://purl.org/dc/elements/1.1/>
    PREFIX  ns: <http://example.org/ns#>
    SELECT  ?title ?price
    WHERE
        { ?x ns:price ?price . 
          FILTER ( ?price < 30 ) .
          ?x dc:title ?title .
        }'
);

