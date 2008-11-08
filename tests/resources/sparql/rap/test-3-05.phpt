return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'SELECT  *
    WHERE
        { ?x ?y ?z . 
          FILTER ( str(?x) = str(<http://rdf.hp.com/r-1>) ) . 
          FILTER ( str(?y) = str(<http://rdf.hp.com/p-1>) ) . 
          FILTER ( str(?z) = "v-1-1" ) .
        }'
);
