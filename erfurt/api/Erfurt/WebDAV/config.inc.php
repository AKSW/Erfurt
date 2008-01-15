<?

//#define("RDFAPI_INCLUDE_DIR", "rdfapi-php/api/");
//define("RDFAPI_INCLUDE_DIR", "rdfapi-php/api/");
//include(RDFAPI_INCLUDE_DIR."RdfAPI.php");
//include(RDFAPI_INCLUDE_DIR."syntax/RdfSerializer.php");
//include(RDFAPI_INCLUDE_DIR."syntax/N3Serializer.php");
//include(RDFAPI_INCLUDE_DIR."util/ModelComparator.php");

//Namespsaces
$_WEBDAV['NS'] = array('http://www.daml.org/2001/10/html/airport-ont#'=>'air',
		  	'http://www.w3.org/2000/10/swap/pim/contact#'=>'con' ,
			'http://purl.org/dc/elements/1.1/'=>'dc' ,
			'http://xmlns.com/foaf/0.1/' =>'foaf',
			'http://www.w3.org/2003/01/geo/wgs84_pos#'=>'geo' ,
			'http://www.w3.org/2002/07/owl#'=>'owl' ,
			'http://www.w3.org/1999/02/22-rdf-syntax-ns#'=>'rdf' ,
			'http://www.w3.org/2000/01/rdf-schema#'=>'rdfs' ,
			'http://www.w3.org/2001/vcard-rdf/3.0#'=>'vCard' ,
			'http://purl.org/vocab/bio/0.1/'=>'bio',
			'http://webns.net/mvcb/'=>'admin',
			'http://purl.org/rss/1.0/'=>'rss',
			'http://purl.org/vocab/relationship/'=>'rel',
			'http://purl.org/net/ldap#'=>'ns1',
			'http://www.xfront.com/owl/ontologies/camera/'=>'camera',
	);
								
//db parameter to connect the db and use it
$_WEBDAV['DB'] = array('type'=>'MySQL',
	'host'=>'127.0.0.1',
	'db'=>'3base',
	'user'=>'root',
	'pass'=>'welldone' ,
	'model' =>'1'
);

//the limit parameter we could use to seperate the model because these are could not represent if they is too large for RAP
$_WEBDAV['limit'] = "10";

//this select the origin of the browsing model either DB Database or SE Sparql_Endpoint or file
$_WEBDAV['origin']="DB";
$_WEBDAV['base'] = "/var/www/localhost/htdocs/Dokumente/wine.owl";

// n3 oder normal oder rdf-file
$_WEBDAV['output']['resource'] =array('showResourceDir' =>TRUE,
										'showResourceN3' => TRUE,
										'showResourceRDF' => TRUE
										);
															
$_WEBDAV['output']['class'] =array(	'showClassDir' =>TRUE,
										'showCSV' => TRUE
									);	
$_WEBDAV['show_system_class']=TRUE;	

$_WEBDAV['mountpoint']="/";																	
?>