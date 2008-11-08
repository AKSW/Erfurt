return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'SELECT  *
    WHERE
        { ?x ?y ?z . 
          FILTER ( str(?y) = str(<http://rdf.hp.com/p-1>) ) .
        }'
);
