return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => '# Get optional get the mbox, of each person

    PREFIX foaf: <http://xmlns.com/foaf/0.1/>
    SELECT ?name
    WHERE
      { OPTIONAL { ?person foaf:name ?name } }'
);


