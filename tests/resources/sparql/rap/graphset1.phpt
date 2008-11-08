return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'PREFIX foaf: <http://xmlns.com/foaf/0.1/>

    SELECT ?src ?bobNick
    WHERE
      {
        GRAPH ?src
        { ?x foaf:mbox <mailto:bob@work.example> .
          ?x foaf:nick ?bobNick
        }
      }'
);
