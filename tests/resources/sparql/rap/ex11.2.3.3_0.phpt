return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'PREFIX foaf: <http://xmlns.com/foaf/0.1/>
    SELECT ?name ?mbox
     WHERE { ?x foaf:name  ?name ;
                foaf:mbox  ?mbox .
             FILTER isUri(?mbox) }'
);


