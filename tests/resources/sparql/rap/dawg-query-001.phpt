return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => '# Get name, and optionally the mbox, of each person

    PREFIX foaf: <http://xmlns.com/foaf/0.1/>

    SELECT ?name ?mbox
    WHERE
      { ?person foaf:name ?name .
        OPTIONAL { ?person foaf:mbox ?mbox}
      }'
);

