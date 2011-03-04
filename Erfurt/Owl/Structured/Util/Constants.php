<?php

    define("RDFS_NS", "http://www.w3.org/2000/01/rdf-schema#");
    define("OWL_NS", 'http://www.w3.org/2002/07/owl#');

    const RDF_TYPE = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#type';
    const RDF_NIL = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#nil';
    const RDF_FIRST = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#first';
    const RDF_REST = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#rest';
    const OWL_ONPROPERTY = 'http://www.w3.org/2002/07/owl#onProperty';
    const OWL_ONCLASS = 'http://www.w3.org/2002/07/owl#onClass';
    const OWL_ONDATARANGE = 'http://www.w3.org/2002/07/owl#onDataRange';
    const RDFS_DATATYPE = 'http://www.w3.org/2000/01/rdf-schema#Datatype';


    define("RDFS_SUBCLASSOF", RDFS_NS . "subClassOf");
    define("OWL_RESTRICTION", OWL_NS . 'Restriction');
    define("OWL_CLASS", OWL_NS . 'Class');
    define("OWL_QUALIFIEDCARDINALITY", OWL_NS . "qualifiedCardinality");
