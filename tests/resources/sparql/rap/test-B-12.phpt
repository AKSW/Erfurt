return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'SELECT  *
    WHERE
        { ?x ?y ?z . 
          FILTER ( ?z = "value"@en ) .
        }'
);
