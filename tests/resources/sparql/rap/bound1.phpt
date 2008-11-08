return array(
        'name'              => 'bound1.rq',
        'group'             => 'RAP Bound Test Cases',
        'result_form'       => 'select',
        'query'             => 'PREFIX  : <http://example.org/ns#>
                                SELECT  ?a ?c
                                WHERE
                                    { ?a :b ?c . 
                                        OPTIONAL
                                        { ?c :d ?e } . 
                                        FILTER (! bound(?e)) 
                                    }'
);