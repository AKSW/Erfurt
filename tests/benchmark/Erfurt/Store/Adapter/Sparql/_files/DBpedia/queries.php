<?php

/**
 * This file contains the different queries that are used in the DBpedia benchmark.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 30.04.14
 */

return array(
    'distinct' => array(
        'query'              => 'PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 SELECT DISTINCT ?var1 FROM <http://dbpedia.org> WHERE { %%var%% rdf:type ?var1 . }',
        'auxiliary_query'    => 'PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE {?var rdf:type ?var1 . } LIMIT 1000',
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'filter' => array(
        'query'              => 'PREFIX dbpprop: <http://dbpedia.org/property/>
                                 PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT * FROM <http://dbpedia.org> WHERE { %%var%% ?var2 ?var1. filter(?var2 = dbpedia2:caption || ?var2 = dbpprop:caption) }',
        'auxiliary_query'    => 'PREFIX dbpprop: <http://dbpedia.org/property/>
                                 PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { ?var ?var2 ?var1. filter(?var2 = dbpedia2:caption || ?var2 = dbpprop:caption) } LIMIT 1000',
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'optional' => array(
        'query'              => 'PREFIX dc: <http://purl.org/dc/elements/1.1/> PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#> PREFIX space: <http://purl.org/net/schemas/space/>
                                 PREFIX dbpedia-owl: <http://dbpedia.org/ontology/> PREFIX dbpedia-prop: <http://dbpedia.org/property/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 SELECT ?var4 ?var8 ?var10 FROM <http://dbpedia.org> WHERE { ?var5 dbpedia-owl:thumbnail ?var4 . ?var5 rdf:type dbpedia-owl:Person . ?var5 rdfs:label %%var%% . ?var5 foaf:page ?var8 . OPTIONAL { ?var5 foaf:homepage ?var10 .} . }',
        'auxiliary_query'    => 'PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX space: <http://purl.org/net/schemas/space/>
                                 PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
                                 PREFIX dbpedia-prop: <http://dbpedia.org/property/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { ?var5 dbpedia-owl:thumbnail ?var4 . ?var5 rdf:type dbpedia-owl:Person . ?var5 rdfs:label ?var . ?var5 foaf:page ?var8 . OPTIONAL { ?var5 foaf:homepage ?var10 .} . } LIMIT 1000',
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'union' => array(
        'query'              => 'PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dbo: <http://dbpedia.org/ontology/>
                                 PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT ?var5 ?var6 ?var9 ?var8 ?var4 FROM <http://dbpedia.org> WHERE { { %%var%% ?var5 ?var6 . ?var6 foaf:name ?var8 . } UNION { ?var9 ?var5 %%var%% ; foaf:name ?var4 . } }',
        'auxiliary_query'    => 'PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dbo: <http://dbpedia.org/ontology/>
                                 PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { { ?var ?var5 ?var6 . ?var6 foaf:name ?var8 . } UNION { ?var9 ?var5 ?var ; foaf:name ?var4 . } } LIMIT 1000',
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'union,distinct' => array(
        'query'              => 'PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX dbpp: <http://dbpedia.org/property/>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 SELECT DISTINCT ?var3 ?var4 ?var5 FROM <http://dbpedia.org> WHERE { { ?var3 dbpp:series %%var1%% ; foaf:name ?var4 ; rdfs:comment ?var5 ; rdf:type %%var0%% . } UNION { ?var3 dbpp:series ?var8 . ?var8 dbpp:redirect %%var1%% . ?var3 foaf:name ?var4 ; rdfs:comment ?var5 ; rdf:type %%var0%% . } }',
        'auxiliary_query'    => 'PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX dbpp: <http://dbpedia.org/property/>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 SELECT DISTINCT ?var0 ?var1 FROM <http://dbpedia.org> WHERE { { ?var3 dbpp:series ?var1 ; foaf:name ?var4 ; rdfs:comment ?var5 ; rdf:type ?var0 . } UNION { ?var3 dbpp:series ?var8 . ?var8 dbpp:redirect ?var1 . ?var3 foaf:name ?var4 ; rdfs:comment ?var5 ; rdf:type ?var0 . } } LIMIT 1000',
        'default_assignment' => array(
            'var0' => '<http://example.org/v0>',
            'var1' => '<http://example.org/v1>'
        )
    ),
    'filter,distinct' => array(
        'query'              => 'PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT DISTINCT ?var3 ?var5 ?var7 FROM <http://dbpedia.org> WHERE { ?var3 rdf:type <http://dbpedia.org/class/yago/Company108058098> . ?var3 dbpedia2:numEmployees ?var5 FILTER ( xsd:integer(?var5) >= %%var%% ) . ?var3 foaf:homepage ?var7 . }',
        'auxiliary_query'    => 'PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT DISTINCT ?var  FROM <http://dbpedia.org> WHERE { ?var3 rdf:type <http://dbpedia.org/class/yago/Company108058098> . ?var3 dbpedia2:numEmployees ?var  . ?var3 foaf:homepage ?var7 . FILTER ( datatype(?var) = <http://www.w3.org/2001/XMLSchema#int> ) } LIMIT 1000',
        'default_assignment' => array(
            'var' => '0'
        )
    ),
    'optional,distinct' => array(
        'query'              => 'PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 PREFIX umbelBus: <http://umbel.org/umbel/sc/Business>
                                 PREFIX umbelCountry: <http://umbel.org/umbel/sc/IndependentCountry>
                                 SELECT distinct ?var0 ?var1 ?var2 ?var3 ?var5 ?var6 ?var7 ?var10 FROM <http://dbpedia.org> WHERE { ?var0 rdfs:comment ?var1. ?var0 foaf:page %%var%% OPTIONAL{?var0 skos:subject ?var6} OPTIONAL{?var0 dbpedia2:industry ?var5}OPTIONAL{?var0 dbpedia2:location ?var2}OPTIONAL{?var0 dbpedia2:locationCountry ?var3}OPTIONAL{?var0 dbpedia2:locationCity ?var9; dbpedia2:manufacturer ?var0}OPTIONAL{?var0 dbpedia2:products ?var11; dbpedia2:model ?var0}OPTIONAL{?var0 <http://www.georss.org/georss/point> ?var10}OPTIONAL{?var0 rdf:type ?var7}}',
        'auxiliary_query'    => 'PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 PREFIX umbelBus: <http://umbel.org/umbel/sc/Business>
                                 PREFIX umbelCountry: <http://umbel.org/umbel/sc/IndependentCountry>
                                 SELECT distinct ?var FROM <http://dbpedia.org> WHERE { ?var0 rdfs:comment ?var1. ?var0 foaf:page ?var OPTIONAL{?var0 skos:subject ?var6} OPTIONAL{?var0 dbpedia2:industry ?var5}OPTIONAL{?var0 dbpedia2:location ?var2}OPTIONAL{?var0 dbpedia2:locationCountry ?var3}OPTIONAL{?var0 dbpedia2:locationCity ?var9; dbpedia2:manufacturer ?var0}OPTIONAL{?var0 dbpedia2:products ?var11; dbpedia2:model ?var0}OPTIONAL{?var0 <http://www.georss.org/georss/point> ?var10}OPTIONAL{?var0 rdf:type ?var7}} LIMIT 1000',
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'union,filter' => array(
        'query'              => 'PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT ?var2 ?var4 FROM <http://dbpedia.org> WHERE { { ?var2 rdf:type %%var1%%. ?var2 dbpedia2:population ?var4. FILTER (xsd:integer(?var4) > %%var0%%) } UNION { ?var2 rdf:type %%var1%%. ?var2 dbpedia2:populationUrban ?var4. FILTER (xsd:integer(?var4) > %%var0%%) } }',
        'auxiliary_query'    => 'PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT DISTINCT ?var0 ?var1 FROM <http://dbpedia.org> WHERE { { ?var2 rdf:type ?var1. ?var2 dbpedia2:population ?var0. } UNION { ?var2 rdf:type ?var1. ?var2 dbpedia2:populationUrban ?var0.  } } LIMIT 1000',
        'default_assignment' => array(
            'var0' => '"0"^^xsd:integer',
            'var1' => '<http://example.org>'
        )
    ),
    'union,optional' => array(
        'query'              => 'PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 SELECT * FROM <http://dbpedia.org> WHERE { ?var2 a <http://dbpedia.org/ontology/Settlement>; rdfs:label %%var%% . ?var6 a <http://dbpedia.org/ontology/Airport>. {?var6 <http://dbpedia.org/ontology/city> ?var2} UNION {?var6 <http://dbpedia.org/ontology/location> ?var2} {?var6 <http://dbpedia.org/property/iata> ?var5.} UNION {?var6 <http://dbpedia.org/ontology/iataLocationIdentifier> ?var5. } OPTIONAL { ?var6 foaf:homepage ?var6_home. } OPTIONAL { ?var6 <http://dbpedia.org/property/nativename> ?var6_name.} }',
        'auxiliary_query'    => 'PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { ?var2 a <http://dbpedia.org/ontology/Settlement>; rdfs:label ?var. ?var6 a <http://dbpedia.org/ontology/Airport>. {?var6 <http://dbpedia.org/ontology/city> ?var2} UNION {?var6 <http://dbpedia.org/ontology/location> ?var2} {?var6 <http://dbpedia.org/property/iata> ?var5.} UNION {?var6 <http://dbpedia.org/ontology/iataLocationIdentifier> ?var5. } OPTIONAL { ?var6 foaf:homepage ?var6_home. } OPTIONAL { ?var6 <http://dbpedia.org/property/nativename> ?var6_name.} } LIMIT 1000',
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'optional,filter,distinct' => array(
        'query'              => "PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT DISTINCT ?var7 FROM <http://dbpedia.org> WHERE { ?var3 foaf:page ?var7. ?var3 rdf:type <http://dbpedia.org/ontology/SoccerPlayer> . ?var3 dbpedia2:position ?var16 . ?var3 <http://dbpedia.org/property/clubs> ?var8 . ?var8 <http://dbpedia.org/ontology/capacity> ?var9 . ?var3 <http://dbpedia.org/ontology/birthPlace> ?var31 . ?var31 ?var33 ?var34. OPTIONAL {?var3 <http://dbpedia.org/ontology/number> ?var35.} Filter (?var33 = <http://dbpedia.org/property/populationEstimate> || ?var33 = <http://dbpedia.org/property/populationCensus> || ?var33 = <http://dbpedia.org/property/statPop> ) Filter (xsd:integer(?var34) > %%var1%% ) . Filter (xsd:integer(?var9) < %%var0%%  ) . Filter (?var16 = 'Goalkeeper'@en || ?var16 = <http://dbpedia.org/resource/Goalkeeper_%28association_football%29> || ?var16 = <http://dbpedia.org/resource/Goalkeeper_%28football%29>) }",
        'auxiliary_query'    => "PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT DISTINCT ?var0 ?var1 FROM <http://dbpedia.org> { ?var3 foaf:page ?var7. ?var3 rdf:type <http://dbpedia.org/ontology/SoccerPlayer> . ?var3 dbpedia2:position ?var6 . ?var3 <http://dbpedia.org/property/clubs> ?var8. ?var8 <http://dbpedia.org/ontology/capacity> ?var1 . ?var3 <http://dbpedia.org/ontology/birthPlace> ?var5 . ?var5 ?var4 ?var0. OPTIONAL {?var3 <http://dbpedia.org/ontology/number> ?var35.} Filter (?var4 = <http://dbpedia.org/property/populationEstimate> || ?var4 = <http://dbpedia.org/property/populationCensus> || ?var4 = <http://dbpedia.org/property/statPop> ) . Filter (?var6 = 'Goalkeeper'@en || ?var6 = <http://dbpedia.org/resource/Goalkeeper_%28association_football%29> || ?var6 = <http://dbpedia.org/resource/Goalkeeper_%28football%29>) } LIMIT 1000",
        'default_assignment' => array(
            'var0' => '"0"^^xsd:integer',
            'var1' => '"0"^^xsd:integer'
        )
    ),
    'union,optional,distinct' => array(
        'query'              => 'PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 PREFIX umbelBus: <http://umbel.org/umbel/sc/Business>
                                 PREFIX umbelCountry: <http://umbel.org/umbel/sc/IndependentCountry>
                                 SELECT distinct ?var3 ?var4 ?var2 FROM <http://dbpedia.org> WHERE { {%%var%% dbpedia2:subsid ?var3 OPTIONAL{?var2 %%var%% dbpedia2:parent} OPTIONAL{%%var%% dbpedia2:divisions ?var4}} UNION {?var2 %%var%% dbpedia2:parent OPTIONAL{%%var%% dbpedia2:subsid ?var3} OPTIONAL{%%var%% dbpedia2:divisions ?var4}} UNION {%%var%% dbpedia2:divisions ?var4 OPTIONAL{%%var%% dbpedia2:subsid ?var3} OPTIONAL{?var2 %%var%% dbpedia2:parent}} }',
        'auxiliary_query'    => 'PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 PREFIX umbelBus: <http://umbel.org/umbel/sc/Business>
                                 PREFIX umbelCountry: <http://umbel.org/umbel/sc/IndependentCountry>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { {?var dbpedia2:subsid ?var3 OPTIONAL{?var2 ?var dbpedia2:parent} OPTIONAL{?var dbpedia2:divisions ?var4}} UNION {?var2 ?var dbpedia2:parent OPTIONAL{?var dbpedia2:subsid ?var3} OPTIONAL{?var dbpedia2:divisions ?var4}} UNION {?var dbpedia2:divisions ?var4 OPTIONAL{?var dbpedia2:subsid ?var3} OPTIONAL{?var2 ?var dbpedia2:parent}} } LIMIT 1000',
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'filter,lang,distinct' => array(
        'query'              => "PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX space: <http://purl.org/net/schemas/space/>
                                 PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
                                 PREFIX dbpedia-prop: <http://dbpedia.org/property/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 SELECT DISTINCT ?var5 FROM <http://dbpedia.org> WHERE { ?var2 rdf:type dbpedia-owl:Person . ?var2 dbpedia-owl:nationality ?var4 . ?var4 rdfs:label ?var5 . ?var2 rdfs:label %%var%% . FILTER (lang(?var5) = 'en') }",
        'auxiliary_query'    => "PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX space: <http://purl.org/net/schemas/space/>
                                 PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
                                 PREFIX dbpedia-prop: <http://dbpedia.org/property/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 SELECT DISTINCT ?var  FROM <http://dbpedia.org> WHERE { ?var2 rdf:type dbpedia-owl:Person . ?var2 dbpedia-owl:nationality ?var4 . ?var4 rdfs:label ?var5 . ?var2 rdfs:label ?var. FILTER (lang(?var5) = 'en') } LIMIT 1000",
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'union,filter,lang' => array(
        'query'              => "PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT * FROM <http://dbpedia.org> WHERE {{ %%var%% rdfs:comment ?var0. FILTER (lang(?var0) = 'en')} UNION {%%var%% foaf:depiction ?var1} UNION {%%var%% foaf:homepage ?var2}}",
        'auxiliary_query'    => "PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE {{ ?var rdfs:comment ?var0. FILTER (lang(?var0) = 'en')} UNION {?var foaf:depiction ?var1} UNION {?var foaf:homepage ?var2}} LIMIT 1000",
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'optional,filter,lang' => array(
        'query'              => "PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT ?var6 ?var8 ?var10 ?var4 FROM <http://dbpedia.org> WHERE { ?var4 skos:subject %%var%% . ?var4 foaf:name ?var6 . OPTIONAL { ?var4 rdfs:comment ?var8 . FILTER (LANG(?var8) = 'en') . } OPTIONAL { ?var4 rdfs:comment ?var10 . FILTER (LANG(?var10) = 'de') . } }",
        'auxiliary_query'    => "PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { ?var4 skos:subject ?var . ?var4 foaf:name ?var6 . OPTIONAL { ?var4 rdfs:comment ?var8 . FILTER (LANG(?var8) = 'en') . } OPTIONAL { ?var4 rdfs:comment ?var10 . FILTER (LANG(?var10) = 'de') . } } LIMIT 1000",
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'filter,regex,distinct,str' => array(
        'query'              => "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX dbo: <http://dbpedia.org/ontology/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 SELECT DISTINCT ?var2 ?var3 FROM <http://dbpedia.org> WHERE { ?var2 rdf:type %%var%% ; rdfs:label ?var3 . FILTER(regex(str(?var3), 'pes', 'i')) }",
        'auxiliary_query'    => "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX dbo: <http://dbpedia.org/ontology/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { ?var2 rdf:type ?var ; rdfs:label ?var3 . FILTER(regex(str(?var3), 'pes', 'i')) } LIMIT 1000",
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'optional,filter,lang,distinct' => array(
        'query'              => "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 SELECT DISTINCT ?var7 ?var4 ?var6 ?var5 FROM <http://dbpedia.org> WHERE { %%var%% ?var4 ?var5 . OPTIONAL {?var5 rdfs:label ?var6} . FILTER(langMatches(lang(?var6),'EN')||(! langMatches(lang(?var6),'*'))) . FILTER(langMatches(lang(?var5),'EN')||(! langMatches(lang(?var5),'*'))) . OPTIONAL {?var4 rdfs:label ?var7}}",
        'auxiliary_query'    => "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { ?var ?var4 ?var5 . OPTIONAL {?var5 rdfs:label ?var6} . FILTER(langMatches(lang(?var6),'EN')||(! langMatches(lang(?var6),'*'))) . FILTER(langMatches(lang(?var5),'EN')||(! langMatches(lang(?var5),'*'))) . OPTIONAL {?var4 rdfs:label ?var7}} LIMIT 1000",
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'union,filter,lang,distinct' => array(
        'query'              => "PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX dct: <http://purl.org/dc/terms/>
                                 PREFIX map: <file:/home/moustaki/work/motools/musicbrainz/d2r-server-0.4/mbz_mapping_raw.n3#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX event: <http://purl.org/NET/c4dm/event.owl#>
                                 PREFIX rel: <http://purl.org/vocab/relationship/>
                                 PREFIX lingvoj: <http://www.lingvoj.org/ontology#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dbpprop: <http://dbpedia.org/property/>
                                 PREFIX dbowl: <http://dbpedia.org/ontology/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX tags: <http://www.holygoat.co.uk/owl/redwood/0.1/tags/>
                                 PREFIX db: <http://dbtune.org/musicbrainz/resource/>
                                 PREFIX geo: <http://www.geonames.org/ontology#>
                                 PREFIX bio: <http://purl.org/vocab/bio/0.1/>
                                 PREFIX mo: <http://purl.org/ontology/mo/>
                                 PREFIX vocab: <http://dbtune.org/musicbrainz/resource/vocab/>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX mbz: <http://purl.org/ontology/mbz#>
                                 SELECT DISTINCT ?var2 ?var3 FROM <http://dbpedia.org> WHERE { {?var2 <http://www.w3.org/2004/02/skos/core#subject> %%var%%.} UNION {?var2 <http://www.w3.org/2004/02/skos/core#subject> <http://dbpedia.org/resource/Category:Prefectures_in_France>.} UNION {?var2 <http://www.w3.org/2004/02/skos/core#subject> <http://dbpedia.org/resource/Category:German_state_capitals>.} ?var2 <http://www.w3.org/2000/01/rdf-schema#label> ?var3. FILTER (lang(?var3)='fr') }",
        'auxiliary_query'    => "PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX dct: <http://purl.org/dc/terms/>
                                 PREFIX map: <file:/home/moustaki/work/motools/musicbrainz/d2r-server-0.4/mbz_mapping_raw.n3#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX event: <http://purl.org/NET/c4dm/event.owl#>
                                 PREFIX rel: <http://purl.org/vocab/relationship/>
                                 PREFIX lingvoj: <http://www.lingvoj.org/ontology#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dbpprop: <http://dbpedia.org/property/>
                                 PREFIX dbowl: <http://dbpedia.org/ontology/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX tags: <http://www.holygoat.co.uk/owl/redwood/0.1/tags/>
                                 PREFIX db: <http://dbtune.org/musicbrainz/resource/>
                                 PREFIX geo: <http://www.geonames.org/ontology#>
                                 PREFIX bio: <http://purl.org/vocab/bio/0.1/>
                                 PREFIX mo: <http://purl.org/ontology/mo/>
                                 PREFIX vocab: <http://dbtune.org/musicbrainz/resource/vocab/>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX mbz: <http://purl.org/ontology/mbz#>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> { {?var2 <http://www.w3.org/2004/02/skos/core#subject> ?var.} ?var2 <http://www.w3.org/2000/01/rdf-schema#label> ?var3. FILTER (lang(?var3)='fr') } LIMIT 1000",
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'union,filter,lang,str' => array(
        'query'              => "PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT ?var3 ?var4 ?var5 FROM <http://dbpedia.org> WHERE { { %%var%% ?var3 ?var4. FILTER ( (STR(?var3) = 'http://www.w3.org/2000/01/rdf-schema#label' && lang(?var4) = 'en') || (STR(?var3) = 'http://dbpedia.org/ontology/abstract' && lang(?var4) = 'en') || (STR(?var3) = 'http://www.w3.org/2000/01/rdf-schema#comment' && lang(?var4) = 'en') || (STR(?var3) != 'http://dbpedia.org/ontology/abstract' && STR(?var3) != 'http://www.w3.org/2000/01/rdf-schema#comment' && STR(?var3) != 'http://www.w3.org/2000/01/rdf-schema#label') ) } UNION { ?var5 ?var3 %%var%% FILTER ( STR(?var3) = 'http://dbpedia.org/ontology/owner' || STR(?var3) = 'http://dbpedia.org/property/redirect' ) } }",
        'auxiliary_query'    => "PREFIX owl: <http://www.w3.org/2002/07/owl#>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX : <http://dbpedia.org/resource/>
                                 PREFIX dbpedia2: <http://dbpedia.org/property/>
                                 PREFIX dbpedia: <http://dbpedia.org/>
                                 PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { { ?var ?var3 ?var4. FILTER ( (STR(?var3) = 'http://www.w3.org/2000/01/rdf-schema#label'&& lang(?var4) = 'en') || (STR(?var3) = 'http://dbpedia.org/ontology/abstract' && lang(?var4) = 'en') || (STR(?var3) = 'http://www.w3.org/2000/01/rdf-schema#comment' && lang(?var4) = 'en') || (STR(?var3) != 'http://dbpedia.org/ontology/abstract' && STR(?var3) != 'http://www.w3.org/2000/01/rdf-schema#comment' && STR(?var3) != 'http://www.w3.org/2000/01/rdf-schema#label') ) } UNION { ?var5 ?var3 ?var FILTER ( STR(?var3) = 'http://dbpedia.org/ontology/owner' || STR(?var3) = 'http://dbpedia.org/property/redirect' ) } } LIMIT 1000",
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    'union,filter,regex,str' => array(
        'query'              => "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 SELECT ?var1 FROM <http://dbpedia.org> WHERE { { ?var1 <http://www.w3.org/2000/01/rdf-schema#label> %%var%% } UNION { ?var1 <http://www.w3.org/2000/01/rdf-schema#label> %%var%% }. FILTER(regex(str(?var1),'http://dbpedia.org/resource/') || regex(str(?var1),'http://dbpedia.org/ontology/') || regex(str(?var1),'http://www.w3.org/2002/07/owl') || regex(str(?var1),'http://www.w3.org/2001/XMLSchema') || regex(str(?var1),'http://www.w3.org/2000/01/rdf-schema') || regex(str(?var1),'http://www.w3.org/1999/02/22-rdf-syntax-ns')) }",
        'auxiliary_query'    => "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { { ?var1 <http://www.w3.org/2000/01/rdf-schema#label> ?var } UNION { ?var1 <http://www.w3.org/2000/01/rdf-schema#label> ?var }. FILTER(regex(str(?var1),'http://dbpedia.org/resource/') || regex(str(?var1),'http://dbpedia.org/ontology/') || regex(str(?var1),'http://www.w3.org/2002/07/owl') || regex(str(?var1),'http://www.w3.org/2001/XMLSchema') || regex(str(?var1),'http://www.w3.org/2000/01/rdf-schema') || regex(str(?var1),'http://www.w3.org/1999/02/22-rdf-syntax-ns')) } LIMIT 1000",
        'default_assignment' => array(
            'var' => '"label"'
        )
    ),
    'union,optional,filter,lang' => array(
        'query'              => "PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 SELECT * FROM <http://dbpedia.org> WHERE { ?var6 a <http://dbpedia.org/ontology/PopulatedPlace>; <http://dbpedia.org/ontology/abstract> ?var1; rdfs:label ?var2; geo:lat ?var3; geo:long ?var4. {?var6 rdfs:label %%var%%.} UNION { ?var5 <http://dbpedia.org/property/redirect> ?var6; rdfs:label %%var%%. } OPTIONAL { ?var6 foaf:depiction ?var8 } OPTIONAL { ?var6 foaf:homepage ?var10 } OPTIONAL { ?var6 <http://dbpedia.org/ontology/populationTotal> ?var12 } OPTIONAL { ?var6 <http://dbpedia.org/ontology/thumbnail> ?var14 } FILTER (langMatches( lang(?var1), 'de') && langMatches( lang(?var2), 'de') )}",
        'auxiliary_query'    => "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { ?var6 a <http://dbpedia.org/ontology/PopulatedPlace>; <http://dbpedia.org/ontology/abstract> ?var1; rdfs:label ?var2; geo:lat ?var3; geo:long ?var4. {?var6 rdfs:label ?var.} UNION { ?var5 <http://dbpedia.org/property/redirect> ?var6; rdfs:label ?var. } OPTIONAL { ?var6 foaf:depiction ?var8 } OPTIONAL { ?var6 foaf:homepage ?var10 } OPTIONAL { ?var6 <http://dbpedia.org/ontology/populationTotal> ?var12 } OPTIONAL { ?var6 <http://dbpedia.org/ontology/thumbnail> ?var14 } FILTER (langMatches( lang(?var1), 'de') && langMatches( lang(?var2), 'de') )} LIMIT 1000",
        'default_assignment' => array(
            'var' => '"label"'
        )
    ),
    '1-TriplePatterns' => array(
        'query'              => 'PREFIX dbpprop: <http://dbpedia.org/property/>
                                 SELECT * FROM <http://dbpedia.org> WHERE { %%var%%  dbpprop:caption ?var0 . }',
        'auxiliary_query'    => 'PREFIX dbpprop: <http://dbpedia.org/property/>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { ?var dbpprop:caption ?var0 . } LIMIT 1000',
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    '2-TriplePatterns' => array(
        'query'              => 'SELECT ?var2 FROM <http://dbpedia.org> WHERE { ?var3 <http://xmlns.com/foaf/0.1/homepage> ?var2 . ?var3 <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> %%var%% . }',
        'auxiliary_query'    => 'SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { ?var3 <http://xmlns.com/foaf/0.1/homepage> ?var2 . ?var3 <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> ?var . } LIMIT 1000',
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
    '3-TriplePatterns' => array(
        'query'              => 'PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX space: <http://purl.org/net/schemas/space/>
                                 PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
                                 PREFIX dbpedia-prop: <http://dbpedia.org/property/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 SELECT ?var4 FROM <http://dbpedia.org> WHERE { ?var2 rdf:type dbpedia-owl:Person . ?var2 rdfs:label %%var%% . ?var2 foaf:page ?var4 . }',
        'auxiliary_query'    => 'PREFIX dc: <http://purl.org/dc/elements/1.1/>
                                 PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                                 PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                                 PREFIX space: <http://purl.org/net/schemas/space/>
                                 PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
                                 PREFIX dbpedia-prop: <http://dbpedia.org/property/>
                                 PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> WHERE { ?var2 rdf:type dbpedia-owl:Person . ?var2 rdfs:label ?var . ?var2 foaf:page ?var4 . } LIMIT 1000',
        'default_assignment' => array(
            'var' => '"label"'
        )
    ),
    '4-TriplePatterns' => array(
        'query'              => 'SELECT * FROM <http://dbpedia.org> WHERE { ?var1 a <http://dbpedia.org/ontology/Organisation> . ?var2 <http://dbpedia.org/ontology/foundationPlace> %%var0%% . ?var4 <http://dbpedia.org/ontology/developer> ?var2 . ?var4 a %%var1%% . } LIMIT 10000',
        'auxiliary_query'    => 'SELECT DISTINCT ?var0 ?var1 FROM <http://dbpedia.org>  where { ?var2 a <http://dbpedia.org/ontology/Organisation> . ?var2 <http://dbpedia.org/ontology/foundationPlace> ?var0 . ?var4 <http://dbpedia.org/ontology/developer> ?var2 . ?var4 a ?var1 . } LIMIT 1000',
        'default_assignment' => array(
            'var0' => '<http://example.org/v1>',
            'var1' => '<http://example.org/v2>'
        )
    ),
    '5-TriplePatterns' => array(
        'query'              => 'PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX dbpprop:<http://dbpedia.org/property/>
                                 SELECT ?var0 ?var1 ?var2 ?var3 FROM <http://dbpedia.org> WHERE { ?var6 rdf:type %%var%%. ?var6 dbpprop:name ?var0. ?var6 dbpprop:pages ?var1. ?var6 dbpprop:isbn ?var2. ?var6 dbpprop:author ?var3.}',
        'auxiliary_query'    => 'PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                                 PREFIX dbpprop:<http://dbpedia.org/property/>
                                 SELECT DISTINCT ?var FROM <http://dbpedia.org> where { ?var6 rdf:type ?var. ?var6 dbpprop:name ?var0. ?var6 dbpprop:pages ?var1. ?var6 dbpprop:isbn ?var2. ?var6 dbpprop:author ?var3.} LIMIT 1000',
        'default_assignment' => array(
            'var' => '<http://example.org>'
        )
    ),
);


