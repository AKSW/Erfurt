<?php

require_once '../../../../erfurt.php';

$session = new Zend_Session_Namespace('ERFURT');
if (isset($session->config)) {
	$erfurt = new Erfurt_App_Default($session->config);
} else {
	$erfurt = new Erfurt_App_Default();
}

$model = $erfurt->getStore()->getModel($_REQUEST['modelUri']);
$searchText = $_REQUEST['searchText'];

$search = new InstanceSearch($model, $searchText . '*');
// $search->allModels = true;
$results = $search->search(0, 50, &$erg);
// $encoding = Zend_Registry::get('config')->ow->encoding;

$ret = '<ul>' . PHP_EOL;
foreach ($results->getRows() as $row) {
	// TODO: use better property names
	if ($res = $model->getResource($row[0])) {
		$localName = $res->getLocalName();
		$uri = $res->getURI();
	}
	if ($localName == '') {
		$localName = $row[0];
	}
	if ($uri == '') {
		$uri = $row[0];
	}
	
	$ret .= '<li><span class="formal">' . htmlentities($localName) . '</span><span class="informal" title="' . $uri . '">' . htmlentities($localName) . '</span></li>' . PHP_EOL;
	
	$localName = '';
	$title = '';
}
$ret .= '</ul>' . PHP_EOL;

echo $ret;

?>
