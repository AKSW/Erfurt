return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'SELECT  *
    WHERE
        { ?a <http://rdf.hp.com/p> ?z .
          ?z <http://rdf.hp.com/p> ?d .
        }'
);
