<?php
 /**
 *RDF - Output
 *@param string file name; 
 *@return string with content;
 *@version $Id$
 *
 */ 
//Subjekt muss rein unf sп·б╘Б∙╚tliche RDF-Serializeroptionen
	$sub_array = explode(".rdf",$candidate);
	if(count($sub_array) ==3) $sub= $sub_array[0].".rdf";
	else $sub = $sub_array[0];
	$subname = ($this->displayname2iri($sub));
	$subj = new Resource($subname);
	$subject="<$subname>";
		$query="SELECT  ?y ?z
		WHERE{ $subject ?y ?z
				}";
	$result = $this->Model->sparqlQuery($query);
	$neu_model = ModelFactory::getDefaultModel();
	if(!empty($result) && is_array($result)){
	foreach($result as $O_Array => $O_Value){
		//parse the predicate
		$pred = new Resource($O_Value['?y']->getLabel());
		//parse the object				
		if(is_a($O_Value['?z'],"BlankNode")){
			$obj = new BlankNode($O_Value['?z']->getLabel());
		}
		else if(is_a($O_Value['?z'],"Resource")){
			$obj = new Resource($O_Value['?z']->getLabel());
		}
		else if(is_a($O_Value['?z'],"Literal")){
			$obj =new Literal($O_Value['?z']->getLabel())	;	
		}
		//Prevend to include the statement		
		$statement = new Statement($subj,$pred,$obj);
		//add to the model					
		$neu_model->add($statement);
	}
//RDF-Serializer, der das ganze Modell anschlieп·б╘Б∙╚nd serialisiert					
	$ser = new RDFSerializer();
	$rdf =&$ser->serialize($neu_model);
//Ausgabe dient als Rckgabewert des GET-Aufrufes
	echo $rdf;			
}			
			
		

?>