return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'PREFIX : <http://example.org/#>

    SELECT *
    { :x ?p ?v . FILTER langMatches(lang(?v), "en-GB") . }'
);

