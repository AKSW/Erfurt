return array(
    'name'              => 'customUnion2.rq',
    'group'             => 'RAP Union Test Cases',
    'query'             => 'PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                            SELECT ?name ?mbox
                            WHERE  {{ ?x foaf:name ?name . ?x  foaf:mbox  ?mbox } UNION { ?x foaf:mbox2 ?mbox} }'
);

