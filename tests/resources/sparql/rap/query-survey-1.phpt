return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'prefix ex: <http://example.org/survey-sample/ontology/>
    SELECT ?n 
    WHERE  
         { ?x ex:author _:a . _:a ?li  _:b . _:b ex:name ?n . }'
);
