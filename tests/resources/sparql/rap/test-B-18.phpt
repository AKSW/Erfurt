return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'SELECT  *
    WHERE
    {
      ?x ?y ?v .
      FILTER ( ?v = true )
    }'
);

