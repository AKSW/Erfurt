return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'PREFIX  foaf:   <http://xmlns.com/foaf/0.1/>

    SELECT ?mbox ?name ?nick
       {
         ?x foaf:mbox ?mbox .
         OPTIONAL { ?x foaf:name  ?name } .
         OPTIONAL { ?x foaf:nick  ?nick } .
       }'
);
