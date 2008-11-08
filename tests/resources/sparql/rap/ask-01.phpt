return array(
    'name'              => 'ask-01.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                            ASK { ?person foaf:name ?name . }',
    'test_syntax'       => true,
    'syntax_success'    => true,
    'test_result'       => true,
    'result'            => false,
    'data'              => array('s' => '', 'p' => '', 'o' => '')
);