<?php
/**
 * HTML rendering related functions
 * 
 * @package POWLAPI
 * @author S�ren Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: html.php 633 2006-11-07 12:33:51Z p_frischmuth $
 * @access public
 **/

function pwlCompressionDialog() {
	?>
	<input type="checkbox" name="sendAsFile" value="sendAsFile" checked onchange="powl.formOptions(this)" onclick="powl.formOptions(this); this.form.target=this.checked?'':'_blank'"/> send as file<br />
	<div id="sendAsFile" style="margin-left:25px;">
	Compression:<br />
	<?
	$compr=array(''=>'none');
	if(extension_loaded('Bz2'))
		$compr['bz']='Bzip2';
	if(extension_loaded('Zlib'))
		$compr['gz']='GZip';
	if(class_exists('Ziplib'))
		$compr['zip']='Zip';
	
	echo(checkbox::edit('compression','',$compr,array('cardinality'=>1)));
	?>
	</div>
	<?
}
function pwlCompression($source,$compression,$filename) {
		if($compression=='zip') {
			$z=new ziplib();
			$z->zl_add_file($source,$filename,"g8");
			header("Content-Type: application/zip");
			header("Content-Disposition: filename=".urlencode($filename).'.zip;');
			$source=$z->zl_pack('Test');
		} else if($compression=='gz') {
			header("Content-Type: application/gzip");
			header("Content-Disposition: filename=".urlencode($filename).'.gz;');
			$source=gzencode($source);
		} else if($compression=='bz') {
			header("Content-Type: application/bzip2");
			header("Content-Disposition: filename=".urlencode($filename).'.bz;');
			$source=bzcompress($source);
		} else {
			header("Content-Type: xml/rdf");
			header("Content-Disposition: filename=".urlencode($filename).';');
		}
		return $source;
}
function pwlEditNodeLink($s,$p,$o=NULL,$linktext=NULL) {
	if(is_a($s,'statement')) {
		$linktext=$p;
		$p=$s->getPredicate();
		$o=$s->getObject();
		$s=$s->getSubject();
	}
	return '<a href="#" onclick="powl.winopen(\'../rdf/node.php?subj='.urlencode($s->getURI()).'&pred='.urlencode($p->getURI()).'&obj[value]='.urlencode($o->getLabel()).
		(is_a($o,'literal')?'&obj[type]=literal&obj[lang]='.urlencode($o->getLanguage()).'&obj[dtype]='.urlencode($o->getDatatype()):'').'\',\'comment_edit\',\'width=350,height=400\');">'.$linktext.'</a>';
}
function pwlRenderNode($node,$URLBase=array()) {
	if(empty($URLBase))
		$URLBase['node']=$GLOBALS['_POWL']['uriBase'].'modules/rdf/index.php?spo[]=subject&spo[]=predicate&spo[]=object&search=';
	if(empty($URLBase['literal']) && !empty($URLBase['node']))
		$URLBase['literal']=$URLBase['node'];
	if(empty($URLBase['resource']) && !empty($URLBase['node']))
		$URLBase['resource']=$URLBase['node'];
	if(is_a($node,'Literal')) {
		$ret=$URLBase['literal']?'<a title="'.pwl_('Show triples with this literal value.').'" href="'.$URLBase['literal'].urlencode($node->getLabel()).'">'.$node->getLabel().'</a>':$node->getLabel();
		$ret.=' ( Language: ';
		$ret.=$node->getLanguage()?'\''.$node->getLanguage().'\'':'-';
		$ret.=', Datatype: ';
		$ret.=$node->getDatatype()?(!empty($GLOBALS['_POWL']['datatypes'][$node->getDatatype()])?str_replace('&nbsp;','',$GLOBALS['_POWL']['datatypes'][$node->getDatatype()]):$node->getDatatype()):'-';
		$ret.=')';
	} else {
		$ret='';
		if(!strstr($node->getLocalName(),'('))
		foreach($GLOBALS['_ET']['rdfsmodel']->findNodes($node,$GLOBALS['RDF_type'],NULL) as $type)
			if(in_array($type->getURI(),array_keys($GLOBALS['_ET']['rdfsmodel']->vocabulary['Class'])))
				$ret='<a title="'.pwl_('Show this resource.').'" href="'.$GLOBALS['_POWL']['uriBase'].'modules/classes/class.php?uri='.urlencode($node->getURI()).'"><img src="'.$GLOBALS['_POWL']['uriBase'].'images/Class.gif" align="middle"></a>&nbsp;';
			else if(in_array($type->getURI(),array_keys($GLOBALS['_ET']['rdfsmodel']->vocabulary['Property'])))
				$ret='<a title="'.pwl_('Show this resource.').'" href="'.$GLOBALS['_POWL']['uriBase'].'modules/properties/property.php?uri='.urlencode($node->getURI()).'"><img src="'.$GLOBALS['_POWL']['uriBase'].'images/Property.gif" align="middle"></a>&nbsp;';
			else if($GLOBALS['_ET']['rdfsmodel']->getInstance($node))
				$ret='<a title="'.pwl_('Show this resource.').'" href="'.$GLOBALS['_POWL']['uriBase'].'modules/instances/instance.php?uri='.urlencode($node->getURI()).'"><img src="'.$GLOBALS['_POWL']['uriBase'].'images/Instance.gif" align="middle"></a>&nbsp;';
		$ret.=!empty($URLBase['resource'])?'<a title="'.pwl_('Show triples with this resource.').'" href="'.$URLBase['resource'].urlencode($node->getLabel()).'">'.$node->getLocalName().'</a>':$node->getLocalName();
	}
	return $ret;
}

function pwlHTMLHeader($title=NULL) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?=$title?$title:'pOWL - RDFS/OWL Ontology Browser'?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script language="javascript" src="<?=$GLOBALS['_POWL']['uriBase']?>powlapi/scripts.js"></script>
	<script language="javascript">
		powl.uribase='<?=$GLOBALS['_POWL']['uriBase']?>';
	</script>
	<link rel="stylesheet" type="text/css" media="screen" href="<?=$GLOBALS['_POWL']['uriBase']?>tabs.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?=$GLOBALS['_POWL']['uriBase']?>powlapi/styles.css" />
</head>
<body bgcolor="#f5f5f5" id="<?=str_replace('.php','',basename($_SERVER["PHP_SELF"]))?>">
<?
if($title)
	echo('<h1>'.pwl_($title).'</h1>');
}

function pwlHTMLHeaderFrameset($title='pOWL - RDFS/OWL Ontology Browser') {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?=$title?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script language="javascript" src="/powl/scripts.js"></script>
	<script language="javascript">
		powl.uribase='/powl/';
	</script>
</head>
<?
}
function pwlHTMLHeaderTree($title='pOWL - RDFS/OWL Ontology Browser') {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>pOWL - RDFS/OWL Ontology Browser</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script language="javascript" src="<?=$GLOBALS['_POWL']['uriBase']?>powlapi/scripts.js"></script>
	<script language="javascript">
		powl.uribase='<?=$GLOBALS['_POWL']['uriBase']?>';
	</script>
	<link rel="stylesheet" type="text/css" media="screen" href="<?=$GLOBALS['_POWL']['uriBase']?>tabs.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?=$GLOBALS['_POWL']['uriBase']?>powlapi/styles.css" />
</head>
<body id="tree">
<?
}

function pwlHTMLFooter() { ?>
<!-- Rendered in <?=timer();?> s //-->
</body>
</html>
<?php
}
?>