<?php

require_once 'Default.php';
/*
 * <Example>
*/

// Just loading the settings from GET/POST
if (sizeof($_GET) != 0) {
			if (array_key_exists('query',$_GET))
				$query = $_GET['query'];
			if (array_key_exists('user',$_GET))
				$user = $_GET['user'];
			if (array_key_exists('password',$_GET))
				$password = $_GET['password'];
			if (array_key_exists('model',$_GET))
				$model = $_GET['model'];
			if (array_key_exists('renderer',$_GET))
				$renderer = $_GET['renderer'];
}
		
if (sizeof($_POST) != 0) {
			if (array_key_exists('query',$_POST))
				$query = $_POST['query'];
			if (array_key_exists('user',$_POST))
				$user = $_POST['user'];
			if (array_key_exists('password',$_POST))
				$password = $_POST['password'];
			if (array_key_exists('model',$_POST))
				$model = $_POST['model'];
			if (array_key_exists('renderer',$_POST))
				$renderer = $_POST['renderer'];
}


try {
	$endpoint = new Erfurt_Sparql_Endpoint_Default();
	$endpoint->authenticate($user,$password);
	
	if($_GET['imports'] !== 'false')
		$endpoint ->setUseImports($_GET['imports']);
		
	$query = stripslashes($query);
	
	$endpoint->setModel($model);
	
	$endpoint->setQuery($query);
	
	$endpoint->setRenderer($renderer);
	
	echo $endpoint -> query();
	
} catch (Exception $e) {
	
	echo 'Erfurt-Message: ' . $e->getMessage() .  ' / Erfurt-Code: ' . $e->getCode();
	
}

/*
 * </Example>
 */
?>