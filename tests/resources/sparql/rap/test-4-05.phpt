return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'SELECT  ?y ?a ?b
    WHERE
        { ?x ?y ?z .
          ?z ?a ?b .
        }'
);
