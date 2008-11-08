return array(
    'name'              => 'count-01.rq',
    'group'             => 'RAP Count Test Cases',
    'result_form'       => 'count',
    'query'             => 'PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                            COUNT { ?person foaf:name ?name . }'
);

