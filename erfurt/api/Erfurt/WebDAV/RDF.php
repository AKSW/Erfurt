<?php

/**
 * @version $Id$
 */

require_once "HTTP/WebDAV/Server.php";
//require_once "System.php";

/**
 * Filesystem access using WebDAV
 *
 * @access public
 */
class HTTP_WebDAV_Server_RDF extends HTTP_WebDAV_Server
{

	/**
	 * Root directory for WebDAV access
	 *
	 * Defaults to webserver document root (set by ServeRequest)
	 *
	 * @access private
	 * @var    string
	 */
	var $base = "";

	/**
	 * MySQL Host where property and locking information is stored
	 *
	 * @access private
	 * @var    string
	 */
	var $db_host = "localhost";

	/**
	 * MySQL database for property/locking information storage
	 *
	 * @access private
	 * @var    string
	 */
	var $db_name = "webdav";

	/**
	 * MySQL user for property/locking db access
	 *
	 * @access private
	 * @var    string
	 */
	var $db_user = "owuser";

	/**
	 * MySQL password for property/locking db access
	 *
	 * @access private
	 * @var    string
	 */
	var $db_passwd = "owpass";

	//the database on the server
	var $db_base;
	//all DB options in this array
	var $DB = array();
	// Save the model in memory
	var $Model;
	//limit and offset for sparql queries
	var $limit;
	//Array fr die URI Komponenten
	var $components = array();

	var $Countcomponents;
	//the namespaces from config.inc.php file
	var $namespaces = array();

	var $output = array();
	//needed by any query to abbreviate the URI
	var $querystring;
	//Context to origin either (DB;SE,file)
	var $origin;
	//Filename and Location
	var $Origin_file;
	//to show all classes or only the owl:class and rdfs:class
	var $show_system_class;
	//usefull for wirting the model in DB
	var $mount_point;
	/**
	 *Constructor-Handler
	 *needed to use a lot of configuration from config.inc.php
	 *@param Array - this array contains the properties
	 */
	function HTTP_WebDAV_Server_RDF($optionen)
	{
		$this->origin =$optionen['origin'];
		$this->limit = $optionen['limit'];
		$this->namespaces =$optionen['NS'];
		$this->output = $optionen['output'];
		$this->show_system_class= $optionen['show_system_class'];
		$this->mount_point =$optionen['mountpoint'];
		//Source is DB
		if($this->origin=="DB") {
			$this->DB = $optionen['DB'];
			$this->db_base =			ModelFactory::getDbStore($this->DB['type'],$this->DB['host'],$this->DB['db'],$this->DB['user'],$this->DB['pass']);
			//Auslesen der modellURI
			$modelID =$this->DB['model'];
			$query =  ("Select * from models WHERE modelID='$modelID' ");
			$res = mysql_query($query);
			while($row = mysql_fetch_row($res)) {
				$modelURI = $row[1];
			}
			$this->Model = $this->db_base->getModel($modelURI);
			mysql_close();
		}
		//Sparqlendpoints
		else if($this->origin=="SE") {
			$this->Model = ModelFactory::getSparqlClient($optionen['base']);
		}
		//if there is no db-selection or sparqlendpoint then use the file connection
		//you have to check the
		else if($this->origin=="file"){
			$this->Origin_file = $optionen['base'];
			$this->Model = ModelFactory::getDefaultModel();
			$this->Model->load($optionen['base']);
		}
			
		//Namespaces hinzufgen und erkennen
		if($this->origin !="SE") {
			$nms = $this->Model->getParsedNamespaces();
			$this->namespaces =array_merge($this->namespaces,$nms);
		}
		foreach($this->namespaces as $key=>$value) {
			$this->querystring.=" PREFIX $value: <$key>";
		}
		$this->querystring.="\n";
	}
	/**
	 * Serve a webdav request
	 *
	 * @access public
	 * @param  string
	 */
	function ServeRequest($base = false)
	{
		// special treatment for litmus compliance test
		// reply on its identifier header
		// not needed for the test itself but eases debugging
		foreach(apache_request_headers() as $key => $value) {
			if (stristr($key,"litmus")) {
				error_log("Litmus test $value");
				header("X-Litmus-reply: ".$value);
			}
		}
			
		// set root directory, defaults to webserver document root if not set
		if ($base) {
			$this->base = realpath($base); // TODO throw if not a directory
		} else if (!$this->base) {
			$this->base = $_SERVER['DOCUMENT_ROOT'];
		}

		// establish connection to property/locking db
		mysql_connect($this->db_host, $this->db_user, $this->db_passwd) or die(mysql_error());
		mysql_select_db($this->db_name) or die(mysql_error());
		// TODO throw on connection problems
		// let the base class do all the work
		parent::ServeRequest();
	}

	/**
	 * No authentication is needed here
	 *
	 * @access private
	 * @param  string  HTTP Authentication type (Basic, Digest, ...)
	 * @param  string  Username
	 * @param  string  Password
	 * @return bool    true on successful authentication
	 */
	function check_auth($type, $user, $pass)
	{
		return true;
	}

	/**
	 * PROPFIND method handler
	 *
	 * @param  array  general parameter passing array
	 * @param  array  return array for file properties
	 * @return bool   true on success
	 */
	function PROPFIND(&$options, &$files)
	{
		//var_dump ($options["path"]);
		// get absolute fs path to requested resource
		$path= $options["path"];
		// prepare property array
		$files["files"] = array();

		// information for contained resources requested?
		if (!empty($options["depth"]))  { // TODO check for is_dir() first?

		// make sure path ends with '/'
		$options["path"] = $this->_slashify($options["path"]);
		if  ($path == "/") {
			$this->Ausgabe_formal("Ausgabe","classes",$files,"Resource");
			$this->Ausgabe_formal("Ausgabe","resources",$files,"Resource");
		}
		else if(preg_match("/^\/classes/",$path)){
			require("include/Classes.php");
		}
		else if(preg_match("/^\/resources/",$path)) {
			require("include/Resources.php");
		}
		}
		// ok, all done
		return true;
	}

	/**
	 * Get properties for a single file/resource
	 *
	 * @param  string  resource path
	 * @return array   resource properties
	 */
	function fileinfo($path,$mime)
	{
		// map URI path to filesystem path
		$fspath =$path;
		// create result array
		$info = array();
		// TODO remove slash append code when base clase is able to do it itself
		// no special beautified displayname here ...
		$info["path"]  =$fspath;// is_a($path,"Resource") ? $this->_slashify($path) : $path;
		$info["props"] = array();
		//The displayname is needed, because davfs could not separate a displayname from given path
		$displayname = basename($fspath);

		$info["props"][] = $this->mkprop("displayname", ($displayname));

		//changed by nic because the filectime and filemtime gives an error
		$info["props"][] = $this->mkprop("creationdate",   time()); //filectime($fspath));
		$info["props"][] = $this->mkprop("getlastmodified", time());//filemtime($fspath));

		// type and size (caller already made sure that path exists)
		if ($mime =="Resource" || $mime=="BlankNode") {
			// directory (WebDAV collection)
			$info["props"][] = $this->mkprop("resourcetype", "collection");
			$info["props"][] = $this->mkprop("getcontenttype", "folder");//httpd/unix-directory");
		}
		else if($mime=="Literal"){
			//$info["props"][] = $this->mkprop("getcontenttype", $this->_mimetype($fspath));
			$info["props"][] = $this->mkprop("getcontenttype", "text/plain, charset=iso-8859-1");
		}
		else if($mime=="N3File"){
			$info["props"][] = $this->mkprop("getcontenttype", "text/rdf+n3, charset=iso-8859-1");
		}
		else if($mime=="RDFFile"){
			$info["props"][] = $this->mkprop("getcontenttype", "text/rdf+xml, charset=iso-8859-1");
			//$info["props"][] = $this->mkprop("getcontentlength", filesize($fspath));
		}
		else if($mime=="CSVFile"){
		 $info["props"][] = $this->mkprop("getcontenttype", "text/comma-separated-values, charset=iso-8859-1");
		 //$info["props"][] = $this->mkprop("getcontentlength", filesize($fspath));
		}

		// get additional properties from database
		$query = "SELECT ns, name, value FROM properties WHERE path = '$path'";
		$res = mysql_query($query);
		while ($row = mysql_fetch_assoc($res)) {
			$info["props"][] = $this->mkprop($row["ns"], $row["name"], $row["value"]);
		}
		mysql_free_result($res);

		return $info;
	}

	/**
	 * detect if a given program is found in the search PATH
	 *
	 * helper function used by _mimetype() to detect if the
	 * external 'file' utility is available
	 *
	 * @param  string  program name
	 * @param  string  optional search path, defaults to $PATH
	 * @return bool    true if executable program found in path
	 */
	function _can_execute($name, $path = false)
	{
		// path defaults to PATH from environment if not set
		if ($path === false) {
			$path = getenv("PATH");
		}

		// check method depends on operating system
		if (!strncmp(PHP_OS, "WIN", 3)) {
			// on Windows an appropriate COM or EXE file needs to exist
			$exts = array(".exe", ".com");
			$check_fn = "file_exists";
		} else {
			// anywhere else we look for an executable file of that name
			$exts = array("");
			$check_fn = "is_executable";
		}

		// now check the directories in the path for the program
		foreach (explode(PATH_SEPARATOR, $path) as $dir) {
			// skip invalid path entries
			if (!file_exists($dir)) continue;
			if (!is_dir($dir)) continue;

			// and now look for the file
			foreach ($exts as $ext) {
				if ($check_fn("$dir/$name".$ext)) return true;
			}
		}

		return false;
	}

	/**
	 * try to detect the mime type of a file
	 *
	 * @param  string  file path
	 * @return string  guessed mime type
	 */
	function _mimetype($fspath)
	{
		if (@is_dir($fspath)) {
			// directories are easy
			return "httpd/unix-directory";
		} else if (function_exists("mime_content_type")) {
			// use mime magic extension if available
			$mime_type = mime_content_type($fspath);
		} else if ($this->_can_execute("file")) {
			// it looks like we have a 'file' command,
			// lets see it it does have mime support
			$fp = popen("file -i '$fspath' 2>/dev/null", "r");
			$reply = fgets($fp);
			pclose($fp);

			// popen will not return an error if the binary was not found
			// and find may not have mime support using "-i"
			// so we test the format of the returned string

			// the reply begins with the requested filename
			if (!strncmp($reply, "$fspath: ", strlen($fspath)+2)) {
				$reply = substr($reply, strlen($fspath)+2);
				// followed by the mime type (maybe including options)
				if (preg_match('/^[[:alnum:]_-]+/[[:alnum:]_-]+;?.*/', $reply, $matches)) {
					$mime_type = $matches[0];
				}
			}
		}

		if (empty($mime_type)) {
			// Fallback solution: try to guess the type by the file extension
			// TODO: add more ...
			// TODO: it has been suggested to delegate mimetype detection
			//       to apache but this has at least three issues:
			//       - works only with apache
			//       - needs file to be within the document tree
			//       - requires apache mod_magic
			// TODO: can we use the registry for this on Windows?
			//       OTOH if the server is Windos the clients are likely to
			//       be Windows, too, and tend do ignore the Content-Type
			//       anyway (overriding it with information taken from
			//       the registry)
			// TODO: have a seperate PEAR class for mimetype detection?
			switch (strtolower(strrchr(basename($fspath), "."))) {
				case ".html":
					$mime_type = "text/html";
					break;
				case ".gif":
					$mime_type = "image/gif";
					break;
				case ".jpg":
					$mime_type = "image/jpeg";
					break;
				default:
					$mime_type = "application/octet-stream";
					break;
			}
		}

		return $mime_type;
	}

	/**
	 * GET method handler
	 *
	 * @param  array  parameter passing array
	 * @return bool   true on success
	 */
	function GET(&$options)
	{
		// get absolute fs path to requested resource
		$path = $options["path"];
		$fspath = $this->base . $options["path"];
		// sanity check
		/**
		*TODO rausfinden warum die REQUEST URI immer vom Apache im DOCUMENT ROOT gefunden werden muss
		*erstmal auf Eis gelegt
		*PROPFIND und GET tun daselbe, wobei PROPFIND die wirklichen DAV Header erwartet und schickt, w&#228;hrend "GET" nur mit HTTP1.0 arbeitet
		*und den OUTPUT wie bei ftp bereitstellt.
		$format = "%15s  %-19s  %-s\n";
		echo "<html><head><title>Index of ".htmlspecialchars($options['path'])."</title></head>\n";
		echo "<h1>Index of ".htmlspecialchars($options['path'])."</h1>\n";

		echo "<pre>";
		printf($format, "Size", "Last modified", "Filename");
		echo "<hr>";
		if  ($path == "/") {
		printf($format, number_format(filesize($fullpath)), strftime("%Y-%m-%d %H:%M:%S", filemtime($fullpath)),"<a href='classes'>classes</a>");
		printf($format, number_format(filesize($fullpath)), strftime("%Y-%m-%d %H:%M:%S", filemtime($fullpath)),"<a href='resources'>resources</a>");
		}
		else if(preg_match("/^\/classes/",$path)){
		include("include/Classes.php");
		}
		else if(preg_match("/^\/resources/",$path)) {
		include ("include/Resources.php");
		}
		echo "</pre>";

		//closedir($handle);
		echo "</html>\n";
		exit;
		*/
		/**
		 *Alte Funktionweise, welche auch REAL existierende Pfade zur&#252;ckgreift
		 while ($filename = readdir($handle)) {
		 if ($filename != "." && $filename != "..") {
		 $fullpath = $fspath."/".$filename;
		 $name = htmlspecialchars($filename);
		 printf($format,
		 number_format(filesize($fullpath)),
		 strftime("%Y-%m-%d %H:%M:%S", filemtime($fullpath)),
		 "<a href='$name'>$name</a>");
		 }
		 }
		 */
		$candidate = basename($path);
		switch(strtolower(strrchr(basename($path),"."))){
			case ".n3";
			include("include/files/N3.php");
			//$this->AusgabeN3(basename($path));//$this->components[3]);
			break;
			case ".rdf";
			include("include/files/RDF.php");
			break;
			//Klasse welche s�tlichen Properties ausgibt
			case ".csv";
			include("include/files/CSV.php");
			break;
			//default Ausgabe Literale daraus wird dann eh der sogenannte OUTput gesucht
			default;
			$this->Ausgabe_Literal($options);
		}
		// is this a collection?
		/*  if (is_dir($fspath)) {
		return $this->GetDir($fspath, $options);
		}
			
		// detect resource type
		$options['mimetype'] = $this->_mimetype($fspath);

		// detect modification time
		// see rfc2518, section 13.7
		// some clients seem to treat this as a reverse rule
		// requiering a Last-Modified header if the getlastmodified header was set
		$options['mtime'] = filemtime($fspath);

		// detect resource size
		$options['size'] = filesize($fspath);

		// no need to check result here, it is handled by the base class
		$options['stream'] = fopen($fspath, "r");
		*/
		return true;
	}

	/**
	 * GET method handler for directories
	 *
	 * This is a very simple mod_index lookalike.
	 * See RFC 2518, Section 8.4 on GET/HEAD for collections
	 *
	 * @param  string  directory path
	 * @return void    function has to handle HTTP response itself
	 */
	function GetDir($fspath, &$options)
	{
		$path = $this->_slashify($options["path"]);
		if ($path != $options["path"]) {
			header("Location: ".$this->base_uri.$path);
			exit;
		}

		// fixed width directory column format
		$format = "%15s  %-19s  %-s\n";

		$handle = @opendir($fspath);
		if (!$handle) {
			return false;
		}

		echo "<html><head><title>Index of ".htmlspecialchars($options['path'])."</title></head>\n";

		echo "<h1>Index of ".htmlspecialchars($options['path'])."</h1>\n";

		echo "<pre>";
		printf($format, "Size", "Last modified", "Filename");
		echo "<hr>";

		while ($filename = readdir($handle)) {
			if ($filename != "." && $filename != "..") {
				$fullpath = $fspath."/".$filename;
				$name = htmlspecialchars($filename);
				printf($format,
				number_format(filesize($fullpath)),
				strftime("%Y-%m-%d %H:%M:%S", filemtime($fullpath)),
                           "<a href='$name'>$name</a>");
			}
		}

		echo "</pre>";

		closedir($handle);

		echo "</html>\n";

		exit;
	}

	/**
	 * PUT method handler
	 *
	 * @param  array  parameter passing array
	 * @return bool   true on success
	 */
	function PUT(&$options) {
		$path = $options["path"];
		//this is the path
		$fspath= $this->mount_point.$path;
		//the file to write
		$new_model = ModelFactory::getDefaultModel();
		//the file which is edited
		$new_model->load($fspath);
		//the original from DB
		$old_model = $this->GetOldDBModel($path);
		//Ein Statement aus dem neuen Modell raussuchen und es im alten Modell finden.
		//Vergleich beider Modelle
		foreach($new_model->triples as $neu_key => $neu_statement){
			//Wenn das ok true bleibt, dann findet er das neu_statement nicht im alten Modell
			$ok =true;
			foreach($old_model->triples as $old_key => $old_statement){
				//compare subjects
				if($neu_statement->subj->getLabel() === $old_statement->subj->getLabel());
				//compare predicates
				if($neu_statement->pred->getURI()===$old_statement->pred->getURI());
				//compare objects
				if($neu_statement->obj->getLabel()===$old_statement->obj->getLabel()){
					$ok=false;
					//Soll nur der Optimierung dienen, d.h wenn er das Statement gefunden hat, soll er mit dem nc&#228;hsten weitermachen
					break;
				}
			}
			if($ok) $this->ProcessDB($neu_statement,0);
		}

		foreach($old_model->triples as $old_key => $old_statement){
			//Wenn das ok true bleibt, dann findet er das neu_statement nicht im alten Modell
			$ok =true;
			foreach($new_model->triples as $neu_key => $neu_statement){
				//compare subjects
				if($neu_statement->subj->getLabel() === $old_statement->subj->getLabel());
				//compare predicates
				if($neu_statement->pred->getURI() === $old_statement->pred->getURI());
				//compare objects
				if($neu_statement->obj->getLabel() === $old_statement->obj->getLabel()){
					$ok=false;
					//Soll nur der Optimierung dienen, d.h wenn er das Statement gefunden hat, soll er mit dem nc&#228;hsten weitermachen
					break;
				}
			}
			if($ok) $this->ProcessDB($old_statement,1);
		}
		//$options["new"] = ! file_exists($path);
		//$fp = fopen($path, "w");

		return "200 OK";


	}
	/**
	 *Write in DB or delete the statement
	 *
	 *@param array - statement contains the subject, predicate,object
	 *@param bool - if is it true when delete
	 *
	 */
	function ProcessDB($statement,$action){
		$subj =$statement->subj->getLabel();
		$pred = $statement->pred->getLabel();
		$obj = $statement->obj->getLabel();
		$modelID =$this->DB['model'];
		//a new connection without use the dbstore
		$verb = mysql_connect($this->DB['host'],$this->DB['user'],$this->DB['pass']);
		mysql_select_db("$this->DB['db']", $verb);

		//Insert a new statement
		if(!$action){
			//decide kind of subject
			if(is_a($statement->subj,"Resource")) $subject_is ="r";
			else if(is_a($statement->subj,"BlankNode"))$subject_is="b";
			else $subject_is="l";
			//decide kind of object
			if(is_a($statement->obj,"Resource")) $object_is="r";
			else if(is_a($statement->obj,"BlankNode"))$object_is="b";
			else {
				$object_is="l";
				$l_language=$statement->obj->getLanguage();
				$l_datatype =$statement->obj->getDatatype();
			}
			//The query
			$query =  ("Insert into statements (modelID,subject,predicate,object,l_language,l_datatype,subject_is,object_is,id)
										VALUES('$modelID','$subj','$pred','$obj','$l_language','$l_datatype','$subject_is','$object_is',' ')");

			if(mysql_query($query,$verb)) {
				syslog(LOG_INFO,"webdav log: erfolgreich in DB geaendert");
			}
		}
		//delete a statement from old_modell
		else {
			$myresult =mysql_fetch_row(mysql_query( "Select id from statements where modelID='$modelID' AND subject='$subj' AND predicate='$pred' AND object='$obj'",$verb));
			$id = $myresult[0];
			mysql_query("Delete from statements WHERE id='$id'");
		}
		return;
	}

	/**
	 *Rescue the origin model with the algorithm to compare with changes
	 *
	 *@param string - path to model
	 *@return array - the model
	 *
	 */
	function GetOldDBModel($path)
	{
		if($this->origin !="DB") return false;
		else {
			$candidate = basename($path);
			$sub_array = explode(".",$candidate);
			$sub =$this->displayname2iri($sub_array[0]);
			$subj = new Resource($sub);
			$query = $this->querystring."SELECT ?pred ?obj
					                    WHERE { <$sub> ?pred ?obj
												}";
			$result = $this->Model->sparqlQuery($query);
			$model = ModelFactory::getDefaultModel();
			if(!empty($result) && is_array($result)){
				foreach($result as $O_Array => $O_Value){
					//parse the predicate
					$pred = new Resource($O_Value['?pred']->getLabel());
					//parse the object
					if(is_a($O_Value['?obj'],"BlankNode")){
						$obj = new BlankNode($O_Value['?obj']->getLabel());
					}
					else if(is_a($O_Value['?obj'],"Resource")){
						$obj = new Resource($O_Value['?obj']->getLabel());
					}
					else if(is_a($O_Value['?obj'],"Literal")){
						$obj =new Literal($O_Value['?obj']->getLabel())	;
					}
					//Prevend to include the statement
					$statement = new Statement($subj,$pred,$obj);
					//add to the model
					$model->add($statement);
				}
			}
		}
		return $model;
	}

	/**
	 * PROPPATCH method handler
	 *
	 * @param  array  general parameter passing array
	 * @return bool   true on success
	 */
	function PROPPATCH(&$options)
	{
		global $prefs, $tab;

		$msg = "";

		$path = $options["path"];

		$dir = dirname($path)."/";
		$base = basename($path);

		foreach($options["props"] as $key => $prop) {
			if ($prop["ns"] == "DAV:") {
				$options["props"][$key]['status'] = "403 Forbidden";
			} else {
				if (isset($prop["val"])) {
					$query = "REPLACE INTO properties SET path = '$options[path]', name = '$prop[name]', ns= '$prop[ns]', value = '$prop[val]'";
					error_log($query);
				} else {
					$query = "DELETE FROM properties WHERE path = '$options[path]' AND name = '$prop[name]' AND ns = '$prop[ns]'";
				}
				mysql_query($query);
			}
		}

		return "";
	}

	/**
	 * LOCK method handler
	 *
	 * @param  array  general parameter passing array
	 * @return bool   true on success
	 */
	function LOCK(&$options)
	{
		if (isset($options["update"])) { // Lock Update
			$query = "UPDATE locks SET expires = ".(time()+300);
			mysql_query($query);

			if (mysql_affected_rows()) {
				$options["timeout"] = 300; // 5min hardcoded
				return true;
			} else {
				return false;
			}
		}

		$options["timeout"] = time()+300; // 5min. hardcoded

		$query = "INSERT INTO locks
                        SET token   = '$options[locktoken]'
                          , path    = '$options[path]'
                          , owner   = '$options[owner]'
                          , expires = '$options[timeout]'
                          , exclusivelock  = " .($options['scope'] === "exclusive" ? "1" : "0")
		;
		mysql_query($query);

		return mysql_affected_rows() ? "200 OK" : "409 Conflict";
	}

	/**
	 * UNLOCK method handler
	 *
	 * @param  array  general parameter passing array
	 * @return bool   true on success
	 */
	function UNLOCK(&$options)
	{
		$query = "DELETE FROM locks
                      WHERE path = '$options[path]'
                        AND token = '$options[token]'";
		mysql_query($query);

		return mysql_affected_rows() ? "204 No Content" : "409 Conflict";
	}

	/**
	 * checkLock() helper
	 *
	 * @param  string resource path to check for locks
	 * @return bool   true on success
	 */
	function checkLock($path)
	{
		$result = false;
		//Die connection to testDB
		$query = "SELECT owner, token, expires, exclusivelock
                  FROM locks
                 WHERE path = '$path'
               ";
		$res = mysql_query($query);

		if ($res) {
			$row = mysql_fetch_array($res);
			mysql_free_result($res);

			if ($row) {
				$result = array( "type"    => "write",
                                                     "scope"   => $row["exclusivelock"] ? "exclusive" : "shared",
                                                     "depth"   => 0,
                                                     "owner"   => $row['owner'],
                                                     "token"   => $row['token'],
                                                     "expires" => $row['expires']
				);
			}
		}
		return $result;
	}

	/**
	 * create database tables for property and lock storage
	 *
	 * @param  void
	 * @return bool   true on success
	 */
	function create_database()
	{
		// TODO
		return false;
	}

	/**
	 * find out the components of uri and seperate them to an array
	 *
	 * @param string the path
	 * @return the cleared array which contains the path
	 */
	function GetComponents($path) {
		$this->components = split("/",$path);
		$this->Countcomponents=count($this->components);
		//leere Elemente eliminieren
		if($this->Countcomponents != 0) {
			for ($i =0;$i <($this->Countcomponents);$i++) {
				if( $this->components[$i]  == "" ) {
					unset($this->components[$i]);
				}
				else $this->components[$i] = urldecode($this->components[$i]);
			}
		}
	}

	/**
	 * general output
	 *
	 * @param Array the result of an query
	 * @param string the path to output
	 * @param Array the filesarray
	 * @param string the mimetype
	 */
	function Ausgabe_formal($result,$path,&$files,$mime)
	{
		//Ausgabe von Resources und classes
		if($result=="Ausgabe") $files["files"][] =$this->fileinfo($path,$mime);
		//Ausgabe der Unterverzeichnisse  resources/R_1_50
		if($result=="Pfad") $files["files"][] = $this->fileinfo($path,$mime);
	}

	/**
	 * change back the display value to a valid IRI
	 *
	 * @param string the IRI in abbreviated form
	 * @return string the IRI in originalform
	 */
	function displayname2iri($wert){
		//Wenn die Resource ein BlankNode ist
		if(preg_match('/_:/',$wert)) {
			$wert = str_replace('_:',' ',$wert);
			//echo $wert;
			$wert=trim($wert);//echo $wert;
			return $wert;
		}
		//Wenn die IRI nur die / oder * ver�dert waren
		if(preg_match('/:\|\|/',$wert) || preg_match('/@/',$wert)) {
			$wert=str_replace("|","/",$wert);
			$wert=str_replace("*","#",$wert);
			return $wert;
		}
		//Ansonsten l�e den Namen wieder auf
		else {
			foreach($this->namespaces as $ns => $prefix) {
				if($prefix == $wert) $wert.":";
				list($ns_pref,$fi) = split(":",$wert);
				//echo $ns_pref."und".$prefix;
				if($prefix !="" && $ns != "") {
					if(strcmp($ns_pref,$prefix) == 0) {
						$neu_wert = trim($ns).trim($fi);
						break;
					}
				}
			}

		}
		if($neu_wert == "") return $wert;
		//echo $neu_wert;
		return $neu_wert;
	}
	
	/**
	 * forms the uri in an abbreviated notation
	 * @param string the complete uri like http://example.com/adresse
	 * @return string the abbreviated notation either a namespace of the uri exist or the uri with changed characters / and #
	 */
	function iri2displayname($wert) {
		$neu_wert="";
		foreach($this->namespaces as $ns => $prefix) {
			if( $this->components[$i]  == "" ) {
				unset($this->components[$i]);
			}
			if($prefix !="" && $ns != "") {
				$length = strlen($ns)-1;
				if(strncmp($wert,$ns,$length) ==0) {
					$zweistring = substr($wert,$length+1);
					$neu_wert = $prefix.":".substr($wert,$length+1);
					break;
				}
			}
		}
			
		if($neu_wert=="") {
			$wert=str_replace("#","*",$wert);
			$wert=str_replace("/","|",$wert);
		}
		//namespace document are the following pattern ns_prefix:
		else if($neu_wert !="" && $zweistring=="") {
			$wert = substr($neu_wert,0,strlen($neu_wert)-1);
		}
		else $wert = $neu_wert;
		return $wert;
	}

	/**
	 * TODO make it better
	 * @param string
	 * @param Integer the suffix of string Literal
	 */
	function Literal_function($wert,$anzahl){
		//ein einzelnes Wort wird einfach zurckgeben
		return "Literal".$anzahl;
			
	}

	/**
	 *@param Array these contains the path
	 *@return
	 */
	function Ausgabe_Literal(&$options) {
		$path = $options['path'];
		$this->GetComponents($path);
		//Literalausgabe
		if($this->components[3] !="" &&$this->components[4]!="") {
			//Subjectname in the content
			$subname =rtrim($this->displayname2iri($this->components[3]));
			//predicatename in the content
			$predname =rtrim($this->displayname2iri($this->components[4]));
			$querystring= "SELECT ?y \n
						WHERE 	{ 
									<$subname> <$predname> ?y
									}";            	
			$result = $this->Model->sparqlQuery($querystring);
			foreach($result as $O_Value){
				$wert = $this->iri2displayname($O_Value['?y']->getLabel());
				echo $wert."\n";
			}
		}
	}
	
	/**
	 * check the given value whether an base class or an subclass is
	 * @param string the uri
	 * @param string the path
	 * @return bool
	 */
	function FindSuperClass($wert,$path) {
		syslog(LOG_INFO,"Der wert ist $wert");
		$Super_Query=$this->querystring."Select DISTINCT ?y
		WHERE {
			<$wert> rdfs:subClassOf ?y
					}";
		$result=$this->Model->sparqlQuery($Super_Query);
		//if the result is empty then it must be a base class
		if(!is_array( $result) || empty($result)) return true;
		else if(count($result) == 1)	{

			if($result[0]['?y']->getLabel() == "http://www.w3.org/2002/07/owl#Thing") {
				return true;
			}
			if($result[0]['?y']->getLabel() == $this->displayname2iri(basename($path))) {
				return true;
			}
		}
		else if(count($result) >1) {
			foreach($result as $R_wert){
				if($R_wert['?y']->getLabel() == $this->displayname2iri(basename($path))) {
					return true;
					break;
				}
			}
		}
		else return false;
	}
	
	/**
	 * check the candidate to IRI
	 * @param string the Uri
	 * @return bool
	 */
	function is_URI($candidate) {
		if(preg_match("/_:/",$candidate)) return false;
		$candidate =$this->displayname2iri($candidate);
		if(preg_match("/\/\//",$candidate) || preg_match("/@/",$candidate)) return true;
	}

}
?>
