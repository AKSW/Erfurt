<?php
require_once '../../../../erfurt.php';

$erfurt = new Erfurt_App_Default(Zend_Registry::get('config'));
$model = $erfurt->getStore()->getModel($_REQUEST['modelUri']);
$seacrText = $_REQUEST['searchText'];

$search = new InstanceSearch($model, $searchText . '*');
// $search->allModels = true;
$results = $search->search(0, 50, &$erg);
// $encoding = Zend_Registry::get('config')->ow->encoding;

$ret = '<ul>' . PHP_EOL;
foreach ($results->getRows() as $row) {
	// TODO: use better property names
	if ($res = $this->_model->getResource($row[0])) {
		$localName = $res->getLocalName();
		$title = OntoWiki_Util::getTitle($res, false, 28);
	}
	if ($localName == '') {
		$localName = $row[0];
	}
	if ($title == '') {
		$title = $row[0];
	}
	
	$ret .= '<li><span class="formal">' . $localName . '</span><span class="informal" title="' . 
			$localName . '">' . htmlentities($title) . '</span></li>' . PHP_EOL;
	
	$localName = '';
	$title = '';
}
$ret .= '</ul>' . PHP_EOL;

echo $ret;
?>