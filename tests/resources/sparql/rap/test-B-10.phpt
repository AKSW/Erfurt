return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'PREFIX  rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

    SELECT  *
    WHERE
        { ?x ?y "value"^^rdf:XMLLiteral }'
);
