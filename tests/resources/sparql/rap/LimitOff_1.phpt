return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'PREFIX foaf:       <http://xmlns.com/foaf/0.1/>
    PREFIX ex:        <http://example.org/things#>

    SELECT ?name ?emp
    WHERE { ?x foaf:name ?name ;
               ex:empId ?emp
          }
    ORDER BY ASC(?emp)
    LIMIT 2'
);

