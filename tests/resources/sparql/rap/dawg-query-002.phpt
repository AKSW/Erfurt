return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => '# Get names of people, together with the names of people they know.

    PREFIX foaf: <http://xmlns.com/foaf/0.1/>

    SELECT ?name ?name2
    WHERE
      { ?person foaf:name ?name .
        OPTIONAL {
          ?person foaf:knows ?p2 .
          ?p2     foaf:name   ?name2 .
        }
      }'
);




