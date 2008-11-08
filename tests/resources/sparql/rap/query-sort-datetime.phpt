return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'PREFIX dc:      <http://purl.org/dc/elements/1.1/>

    SELECT ?created
    WHERE { ?x dc:created ?created }
    ORDER BY ASC(?created)'
);
