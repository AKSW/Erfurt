return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'PREFIX foaf: <http://xmlns.com/foaf/0.1/>
    PREFIX dc:   <http://purl.org/dc/elements/1.1/>
    SELECT ?name
     WHERE { ?x foaf:name  ?name .
             OPTIONAL { ?x dc:created ?created } .
             FILTER ( !bound(?created)) }'
);


