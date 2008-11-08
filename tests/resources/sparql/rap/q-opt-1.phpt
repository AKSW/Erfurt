return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'PREFIX  foaf:   <http://xmlns.com/foaf/0.1/>

    SELECT ?mbox ?name
       {
         ?x foaf:mbox ?mbox .
         OPTIONAL { ?x foaf:name  ?name } .
       }'
);
