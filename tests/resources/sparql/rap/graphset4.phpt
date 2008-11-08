return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'result_form'       => 'select',
    'query'             => 'PREFIX  data:  <http://example.org/foaf/>
    PREFIX  foaf:  <http://xmlns.com/foaf/0.1/>
    PREFIX  rdf:   <http://www.w3.org/1999/02/22-rdf-syntax-ns#> 
    PREFIX  rdfs:  <http://www.w3.org/2000/01/rdf-schema#>

    SELECT ?mbox ?nick ?ppd
    WHERE
    {
      GRAPH data:aliceFoaf
      {
        ?alice foaf:mbox <mailto:alice@work.example> ;
               foaf:knows ?whom .
        ?whom  foaf:mbox ?mbox ;
               rdfs:seeAlso ?ppd .
        ?ppd  a foaf:PersonalProfileDocument .
      } .
      GRAPH ?ppd
      {
          ?w foaf:mbox ?mbox ;
             foaf:nick ?nick 
      }
    }'
);
