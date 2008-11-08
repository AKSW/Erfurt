return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'construct',
    'query'             => 'PREFIX ns: <http://example.org/ns#>
    PREFIX :   <http://example.org/>

    # No match => empty graph
    CONSTRUCT
        { ?x ns:knows ?y  }
    WHERE
        { ?x ns:sameTown ?y }'
);
