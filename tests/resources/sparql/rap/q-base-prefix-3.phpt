return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'PREFIX ns: <http://example.org/ns#>
    PREFIX x:  <http://example.org/x/>

    SELECT * WHERE { x:x ns:p ?v }'
);
 
