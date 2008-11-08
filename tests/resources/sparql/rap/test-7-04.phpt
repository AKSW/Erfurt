return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'SELECT  ?x ?y ?a
    WHERE
        { ?y ?a ?b .
          ?x ?y ?z .
        }'
);
