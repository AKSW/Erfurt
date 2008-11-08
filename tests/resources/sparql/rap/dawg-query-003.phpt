return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => '# Get names and mboxes, each of which may be optional.

    PREFIX foaf: <http://xmlns.com/foaf/0.1/>
    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

    SELECT ?name ?mbox
    WHERE
      {
        { ?person rdf:type foaf:Person } .
        OPTIONAL { ?person foaf:name  ?name } .
        OPTIONAL {?person foaf:mbox  ?mbox} .
      }'
);


