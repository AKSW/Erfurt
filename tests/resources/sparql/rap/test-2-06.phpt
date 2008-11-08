return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'SELECT  *
    WHERE
        { ?x ?y "v-1-1" .
          ?x ?y "v-1-2" .
        }'
);
