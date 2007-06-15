<?
/**
 * RDFSmodel
 *
 * @package RDFSAPI
 * @author Atanas Alexandrov <sirakov@gmail.com>
 *
 **/
class RDFSModel extends DefaultRDFSModel {

	/**
	 * Add triple to model
	 * 
	 * @param	string	$modelname: the name of the model, which will be used
	 * @param	string	$subj
	 * @param	string	$pred
	 * @param	string	$obj
	 * @return	boolean	$success
	 */
	function add($modelname, $subj, $pred, $obj){
		$success = false;
		$_getModel = new POWLStore::getModel($modelname);
		$_owner= $_getModel->fields[0];
		$_modelname= $_getModel->fields[2];
		$_tablename= $_getModel->fields[3];
		
		//get max triple ID, generate next ID for the tripple
		$_newTable = $_owner.".".$_tablename; // just concat -> Example ONTOWIKI.FAMILY_RDF_DATA
		$count = "SELECT MAX(ID) FROM ".$_newTable; // get last triple ID
		$lastTripleId = $oracle_database->GetOne($count); // Get the number of the last tripleId
		$newId = $lastTripleId + 1; // the Id for the new triple will be 1 bigger		
		
		//Check, if triple already exists
		$tripleexist = "SELECT SDO_RDF.IS_TRIPLE('".$_modelname."', '".$subj."', '".$pred."', '".$obj."') AS is_triple FROM DUAL";

		if (($oracle_database->GetOne($tripleexist)) == "TRUE (EXACT)"){
			echo "Triple already exist!";
			$success=true;
		}
		else {
			//Insert triple	
			$insert_query = "INSERT INTO ".$_tablename." ";
			$insert_query .= "VALUES (".$newId.", SDO_RDF_TRIPLE_S('".$_modelname."','".$subj."','".$pred."','".$obj."'))";	
			$oracle_database->Execute($insert_query);
		}
		
		// Check, if the triple was added successfully
		if ($newId == $this->dbConn->GetOne("SELECT MAX(ID) FROM ".$_newTable)){
			print("Triple added successfully!");
			$success=true;	
		}
		
		return $success;
	}
	
	/**
	 * Remove triple from model
	 * 
	 * @param	string	$modelname: the name of the model, which will be used
	 * @param	string	$subj
	 * @param	string	$pred
	 * @param	string	$obj
	 * @return	boolean	$success
	 */
	function remove($modelname, $subj, $pred, $obj){
		$success = false;
		$_getModel = new POWLStore::getModel($modelname);
		$_owner= $_getModel->fields[0];
		$_modelname= $_getModel->fields[2];
		$_tablename= $_getModel->fields[3];

		$_newTable = $_owner.".".$_tablename; // just concat -> Example ONTOWIKI.FAMILY_RDF_DATA
		$getLastTripleId = $oracle_database->GetOne("SELECT MAX(ID) FROM ".$_newTable);		

		// query to check, if triple already exists
		$tripleexist = "SELECT SDO_RDF.IS_TRIPLE('".$_modelname."', '".$subj."', '".$pred."', '".$obj."') AS is_triple FROM DUAL";

		// delete triple query
		$deleteTriple = "DELETE FROM ".$_newTable." a where a.triple.get_subject()='".$subj."' and a.triple.get_property() = '".$pred."' and to_char(a.triple.get_object()) = '".$obj."'";
		
		if (($oracle_database->GetOne($tripleexist)) == "TRUE (EXACT)"){
			$oracle_database->Execute($deleteTriple);
		}
		else {
			print ("Error: Triple does not exist!");
		}
		
		// Check, if the triple was added successfully
		if ($getLastTripleId > $oracle_database->GetOne("SELECT MAX(ID) FROM ".$_newTable)){
			print ("Triple deleted successfully!");
			$success=true;
		}
		else {
			print ("Error: triple was not removed succesfully"); 
		}
		
		return $success;	
	}

	/**
	 * Insert namespace to model
	 * 
	 * @param	string	$modelname
	 * @param	string	$namespace
	 */
	function insertNamespace($modelname,$namespace){

	}
	
	/**
	 * List all
	 */
	function listNamespaces(){
	
	}
	
	/**
	 * Search for triples
	 */
	function find(){

	}
	
	function findSubjects(){
	
	}
	
	function findPredicates(){
	
	}

	function findObjects(){
	
	}
	
	function createRulebase(){
	
	}
	
	function dripRulebase(){
	
	}
	
	function createRuleindex(){
	
	}
	
	function dropRuleindex(){
	
	}
	
	function insertRule(){
	
	}
	
?>
