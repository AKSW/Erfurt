<?php
/**
 *@param $candidate
 *@return 
 *@version $Id$
*/    
$Properties = array();
  	list($sub,$bla) = split("\.csv",$candidate);
	//Mehrere Abfragen ber die vorhandenen Instanzen und deren Properties
	$subname = $this->displayname2iri($sub);    
  	$inst_query ="Select DISTINCT ?x
  		WHERE { ?x rdf:type <$subname>
					}";
	$result = $this->Model->sparqlQuery($inst_query);
   if(is_array($result)){
	//Jeden Kandidaten welcher eine Klasse ist	
		foreach($result as $O_Array =>$O_Value) {
			$instwert = $O_Value['?x']->getLabel();
			$property_query="Select DISTINCT ?y 
					WHERE { <$instwert> ?y ?z }";
			$prop_result = $this->Model->sparqlQuery($property_query);
			foreach($prop_result as $P_Array =>$P_Value) {
				$Properties[$this->iri2displayname($P_Value['?y'] ->getLabel())] = $this->iri2displayname($P_Value['?y'] ->getLabel());								
			}			
		}      	 
   }
	
//Properties welche angezeigt werden      	 
  	$Prop_lang = count($Properties);
 //Tabellenkopf  wird geschrieben 
  	echo "IRI;";
  	$j=0;
  	foreach ($Properties as $P_Value){
		if($j == $Prop_lang) echo $P_Value."\n";				
		else echo $P_Value.";"; 
		$j++;				      	 
   }
   echo "\n";
   //Jetzt alle gefundenen Instanzen durchgehen, was jetzt noch fehlt ist der Mimetype erkennung,z.B wenn ein Literal kommt, dann
   //sollte er auch das LAnguage tag mit angeben
	foreach ($result as $O_Value) {
		$instwert = $O_Value['?x']->getLabel();      	 
		$inst_wert ="<$instwert>";
		$k=0;
		$property_query="Select DISTINCT ?y ?z
			WHERE { $inst_wert ?y ?z }";		
		$eintrage_array = $this->Model->sparqlQuery($property_query);	
		//IRI aufschreiben	
		echo $this->iri2displayname($instwert).";";					
		foreach($Properties as $P_Array =>$P_Value) {
			$i=0;							
			foreach ($eintrage_array as $E_array => $E_Value) {
				$property = ($this->iri2displayname($E_Value['?y']->getLabel()));
				if($P_Value ==$property) {
					echo $this->iri2displayname($E_Value['?z']->getLabel()).";";
					$i=0;									
					break;								
				}
			$i++;		
			//Suche die Property im Propertiesarray
			}
			if($i == count($eintrage_array) && $k+1 != $Prop_lang) echo ";";						
			$k++;						
		}
		echo "\n";	
	}	      	
?>