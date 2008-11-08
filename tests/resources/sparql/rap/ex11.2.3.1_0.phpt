return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'PREFIX foaf: <http://xmlns.com/foaf/0.1/>
    SELECT ?name1 ?name2
     WHERE { ?x foaf:name  ?name1 ;
                foaf:mbox  ?mbox1 .
             ?y foaf:name  ?name2 ;
                foaf:mbox  ?mbox2 .
             FILTER ( ?mbox1 = ?mbox2 && ?name1 != ?name2 )
           }'
);


