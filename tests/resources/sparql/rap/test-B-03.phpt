return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'PREFIX  ex: <http://example.com/ns#>
    SELECT  ?x ?y
    WHERE
        { ?x ?y "value"^^ex:someType }'
);
