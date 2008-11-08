return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'SELECT  ?x ?y
    WHERE
        { ?x ?p1 "v-a-1" .
          ?y ?p2 "v-a-2" .
        }'
);
