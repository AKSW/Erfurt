<?php
/**
 * RDFSStore
 *
 * @package rdfs
 * @author Atanas Alexandrov <sirakov@gmail.com> 
 **/
class Erfurt_Store_Adapter_Oracle extends Erfurt_Store_Default {

	/**
	 * Create table and model into ORACLE
	 * 
	 * @param	string	$tablename: Table, where the data must be stored
	 * @param	string	$modelname: Name for the new model
	 */
	public function getNewModel($tablename, $modelname) {

		// Check if table or model already exist
 		$tableexist_query = "SELECT count(*) FROM MDSYS.RDF_MODEL$ WHERE TABLE_NAME='" . $tablename . "'";
		$modelexist_query = "SELECT count(*) FROM MDSYS.RDF_MODEL$ WHERE MODEL_NAME='" . $modelname . "'";		

		$trs = $dbConn->GetOne($tableexist_query); // $trs - table record set
		$mrs = $dbConn->GetOne($modelexist_query); // $mrs - model record set

		if ($trs == 1) {
			print '<br>'.'Table '.$tablename.' already exist, please create another table';
		} else if ($mrs == 1){
			print 'Model '.$tablename.' already exist, please create another model';
		} else {
			$this->$dbConn->Execute("CREATE TABLE ".$tablename." (id NUMBER, triple SDO_RDF_TRIPLE_S)");
			echo "Table created<br>";
			$this->$dbConn->Execute("BEGIN SDO_RDF.CREATE_RDF_MODEL('".$modelname."', '".$tablename."', 'triple'); END;");
			echo "Model created";
			
			/**
			 * Optionally can be created indexes, to make some operations faster
			 */
			$this->$dbConn->Execute("CREATE INDEX ".$modelname."_sub_idx on ".$tablename."(triple.get_subject())");
			$this->$dbConn->Execute("CREATE INDEX ".$modelname."_prop_idx on ".$tablename."(triple.get_property())");
			$this->$dbConn->Execute("CREATE INDEX ".$modelname."_obj_idx on ".$tablename."(to_char(triple.get_object()))");
		}
	}

	/**
	 * getModel from MDSYS.RDF_MODEL$
	 * 
	 * @param	string	$modelname
	 * @param	string	$gmq: getModel query
	 */
	public function getModel($modelname) {	
		
		$query= "SELECT * FROM MDSYS.RDF_MODEL$ WHERE MODEL_NAME='".$modelname."'";
		
		$rs = &$this->dbConn->Execute($query); //$rs: recordset for the choosed model
	
		$_owner = $rs->Fields(OWNER);
		$_modelname = $rs->Fields(MODEL_NAME);
		$_tablename = $rs->Fields(TABLE_NAME);
		$_id = $rs->Fields(MODEL_ID);
		
		$arr = array($_owner, $_id, $_modelname, $_tablename);
		return $arr;
		// print_r ($rs->fields);	# optional	
	}
	
	/**
	 * listModels
	 * List all models
	 */
	public function listModels() {
		
		$query = "SELECT MODEL_NAME FROM MDSYS.RDF_MODEL$";
		
		$recordSet = $this->dbConn->Execute($query);
		if (!$recordSet) print $this->dbConn->ErrorMsg();
		else {
			$i=1;
			while (!$recordSet->EOF) {
				print $i.'. '.$recordSet->fields[0].'<BR>';
				$recordSet->MoveNext();
				$i++;
			}
		}
		$recordSet->Close(); # optional
	}
	
	public function deleteModel($modelname){
		
		/**
		 * Check if table or model already exist
		 * @param	string	dtq: delete table query
		 * @param	string	dmq: delete model query
		 */
	 	$modelexist = "SELECT count(*) FROM MDSYS.RDF_MODEL$ WHERE MODEL_NAME='" . $modelname . "'";
		$dmq = "SELECT MODEL_NAME,TABLE_NAME FROM MDSYS.RDF_MODEL$ WHERE MODEL_NAME='" . $modelname . "'";		
		$modelExistRecordSet = $this->dbConn->GetOne($modelexist);
		$mrs = $this->dbConn->Execute($dmq)->fields[0]; // $mrs - model record set
		$trs = $this->dbConn->Execute($dmq)->fields[1]; // $trs - table record set

		if ($modelExistRecordSet==0) {
			print "Table and model does not exist!";
		} else {		
			/**
			 * First delete model using PL/SQL command and then drop the table
			 */
			$this->dbConn->Execute("BEGIN SDO_RDF.DROP_RDF_MODEL('".$mrs."'); END;");
			print "Model deleted<br>";
			$this->dbConn->Execute("DROP TABLE ".$trs);
			print "Table deleted";
		}
		
		$modelExistRecordSet->Close(); # optional
		$mrs->Close(); # optional
		$trs->Close(); # optional
	}
}
?>
