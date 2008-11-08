return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'PREFIX  rsyn: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
    SELECT  ?b ?y
    WHERE
        { ?b rsyn:type rsyn:Bag .
          ?b ?x ?y . 
          FILTER ( ! ( ( str(?x) = str(rsyn:type) ) && ( str(?y) = str(rsyn:Bag) ) ) ) .
        }'
);
