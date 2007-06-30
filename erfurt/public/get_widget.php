<?php

require_once '../erfurt.php';

$id = $_REQUEST['id'];
$class = $_REQUEST['class'];
$count = $_REQUEST['count'];
$name = $_REQUEST['name'];

$widget = new $class($name, null, array('cssId' => $id));
echo $widget->getSingleValueHtml('', $count + 1);

?>
