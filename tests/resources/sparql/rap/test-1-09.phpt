return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'PREFIX  prefix: <http://rdf.hp.com>
    SELECT  *
    WHERE
    # ILLEGAL
    { prefix:/r-1 ?y "v-1-2" }'
);
