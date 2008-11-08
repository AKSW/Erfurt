return array(
    'name'              => 'count-01.rq',
    'group'             => 'RAP Count Test Cases',
    'query'             => 'PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                            COUNT { ?person foaf:name ?name . }'
);

