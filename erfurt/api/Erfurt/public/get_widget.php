<?php

require_once '../erfurt.php';

$id          = $_REQUEST['id'];
$count       = $_REQUEST['count'];
$name        = $_REQUEST['name'];
$propertyUri = $_REQUEST['property'];
$widgetClass = $_REQUEST['class'];
$modelUri    = $_REQUEST['model'];

// session_start();
// $session = $_SESSION['ERFURT'];
// $config = $session['config'];

// $session = new Zend_Session_Namespace('ERFURT');
// $config = $session->config;

// print_r($config);

// $erfurt = new Erfurt_App_Default($config);


// $model = $erfurt->getStore()->getModel($modelUri);

// print_r($model);

$wf = Erfurt_Plugin_Widget_Factory::getInstance();

// $widget = $wf->getWidgetHtml(null, $model->propertyF($propertyUri), null, array('cssId' => $id));

$widget = new $widgetClass($name, null, array('cssId' => $id));
echo $widget->getSingleValueHtml('', $count + 1);

?>
