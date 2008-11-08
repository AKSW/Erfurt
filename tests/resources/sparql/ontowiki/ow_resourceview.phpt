return array(
    'name'              => 'ask-02.rq',
    'group'             => 'RAP Ask Test Cases',
    'query'             => 'SELECT DISTINCT ?predicate ?predicate0 ?objectResource0 ?predicate1 ?objectResource1 ?objectResource 
                    ?objectLiteralstring ?objectLiteralboolean ?objectLiteralinteger ?objectLiteraldate ?objectLiteralanyURI
    FROM <http://3ba.se/conferences/>
    WHERE {
        {
            <http://3ba.se/conferences/SebastianDietzold> ?predicate ?objectResource.  
            OPTIONAL {?objectResource <http://www.w3.org/2000/01/rdf-schema#label> ?objectResource0} 
            OPTIONAL {?objectResource <http://purl.org/dc/elements/1.1/title> ?objectResource1}
            FILTER (isUri(?objectResource))
        }
        UNION
        {
            {
                <http://3ba.se/conferences/SebastianDietzold> ?predicate  ?objectLiteralstring. 
                FILTER(datatype(?objectLiteralstring) = <http://www.w3.org/2001/XMLSchema#string>)
            }
            UNION
            {
                <http://3ba.se/conferences/SebastianDietzold> ?predicate  ?objectLiteralboolean. 
                FILTER(datatype(?objectLiteralboolean) = <http://www.w3.org/2001/XMLSchema#boolean>)
            }
            UNION
            {
                <http://3ba.se/conferences/SebastianDietzold> ?predicate  ?objectLiteralinteger. 
                FILTER(datatype(?objectLiteralinteger) = <http://www.w3.org/2001/XMLSchema#integer>)
            }
            UNION
            {
                <http://3ba.se/conferences/SebastianDietzold> ?predicate  ?objectLiteraldate. 
                FILTER(datatype(?objectLiteraldate) = <http://www.w3.org/2001/XMLSchema#date>)
            }
            UNION
            {
                <http://3ba.se/conferences/SebastianDietzold> ?predicate  ?objectLiteralanyURI. 
                FILTER(datatype(?objectLiteralanyURI) = <http://www.w3.org/2001/XMLSchema#anyURI>)
            }
            FILTER (isLiteral(?objectLiteral))
        }
         OPTIONAL {?predicate <http://www.w3.org/2000/01/rdf-schema#label> ?predicate0} 
         OPTIONAL {?predicate <http://purl.org/dc/elements/1.1/title> ?predicate1}
         FILTER (?predicate != <http://www.w3.org/1999/02/22-rdf-syntax-ns#type>)
         #FILTER (str(?predicate) != str(<http://www.w3.org/1999/02/22-rdf-syntax-ns#type>)) 
         #FILTER (str(?predicate) != <http://www.w3.org/2000/01/rdf-schema#label>)
    }
    ORDER BY ?predicate'
);


