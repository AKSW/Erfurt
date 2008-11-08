return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'SELECT  *
    WHERE
        { ?x ?y ?v . 
          FILTER ( ?v = 5.7 ) .
        }'
);

