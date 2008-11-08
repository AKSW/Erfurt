return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'PREFIX  dc: <http://purl.org/dc/elements/1.1/>
    PREFIX  x: <http://example.org/ns#>
    SELECT  ?title ?price
    WHERE
        { ?book dc:title ?title . 
          OPTIONAL
            { ?book x:price ?price . 
              FILTER (?price < 15) .
            } .
        }'
);

