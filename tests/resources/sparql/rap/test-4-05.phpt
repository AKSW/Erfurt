return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'SELECT  ?y ?a ?b
    WHERE
        { ?x ?y ?z .
          ?z ?a ?b .
        }'
);
