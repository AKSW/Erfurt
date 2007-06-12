<?php
/**
 * classes and functions common to all POWL modules
 *
 * @package POWLAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: include.php 621 2006-11-03 21:47:23Z soerenauer $
 * @access public
 **/

// try to guess 'OWLAPI_INCLUDE_DIR' if 'POWLAPI_INCLUDE_DIR' is defined
if(!defined('OWLAPI_INCLUDE_DIR') && defined('POWLAPI_INCLUDE_DIR'))
	define('OWLAPI_INCLUDE_DIR',str_replace('powlapi/','owlapi/',POWLAPI_INCLUDE_DIR));

// load OWLAPI
require_once(OWLAPI_INCLUDE_DIR.'owlapi.php');

// HTML rendering related functions (header, footer)
require_once(POWLAPI_INCLUDE_DIR.'html.php');
require_once(POWLAPI_INCLUDE_DIR.'widget.php');

if(file_exists(POWLAPI_INCLUDE_DIR.'ziplib-0.4/ziplib.php'))
	include_once(POWLAPI_INCLUDE_DIR.'ziplib-0.4/ziplib.php');

// load crucial widget classes to render user interface
if(empty($_POWL['installPath']))
	$_POWL['installPath']=dirname(POWLAPI_INCLUDE_DIR).'/';
include_once($_POWL['installPath'].'plugins/widgets/treeselect/include.php');
include_once($_POWL['installPath'].'plugins/widgets/treeview/include.php');
include_once($_POWL['installPath'].'plugins/widgets/treeviewJS/include.php');
include_once($_POWL['installPath'].'plugins/widgets/tab/include.php');
include_once($_POWL['installPath'].'plugins/widgets/select.php');
include_once($_POWL['installPath'].'plugins/widgets/checkbox.php');
include_once($_POWL['installPath'].'plugins/widgets/text.php');
include_once($_POWL['installPath'].'plugins/widgets/textarea.php');
include_once($_POWL['installPath'].'plugins/widgets/date/date.php');
include_once($_POWL['installPath'].'plugins/widgets/htmlarea/include.php');
include_once($_POWL['installPath'].'plugins/widgets/selectInstance/include.php');
include_once($_POWL['installPath'].'plugins/widgets/textselect.php');
include_once($_POWL['installPath'].'plugins/widgets/node.php');
include_once($_POWL['installPath'].'plugins/widgets/file.php');

// emulate is_a for php prior 4.2
if (!function_exists('is_a')) {
	function is_a( $object, $className ) {
		return ((strtolower($className) == get_class($object)) or (is_subclass_of($object, $className)));
   }
}

if(empty($_POWL['uriBase'])) {
	if(!empty($_SERVER['DOCUMENT_ROOT']) && ereg($_SERVER['DOCUMENT_ROOT'],$_POWL['installPath']))
		$_POWL['uriBase']=str_replace(rtrim($_SERVER['DOCUMENT_ROOT'],'/'), '', $_POWL['installPath']);
	else $_POWL['uriBase']='/powl/';
}

$_POWL['datatypes']=array(
	'http://www.w3.org/2001/XMLSchema#string'=>'String',
	'http://www.w3.org/2001/XMLSchema#boolean'=>'Boolean',
	'http://www.w3.org/2001/XMLSchema#decimal'=>'Decimal',
	'http://www.w3.org/2001/XMLSchema#integer'=>'&nbsp;&nbsp;Integer',
	'http://www.w3.org/2001/XMLSchema#nonNegativeInteger'=>'&nbsp;&nbsp;&nbsp;&nbsp;nonNegative',
	'http://www.w3.org/2001/XMLSchema#positiveInteger'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;positive',
	'http://www.w3.org/2001/XMLSchema#nonPositiveInteger'=>'&nbsp;&nbsp;&nbsp;&nbsp;nonPositive',
	'http://www.w3.org/2001/XMLSchema#negativeInteger'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;negative',
	'http://www.w3.org/2001/XMLSchema#long'=>'&nbsp;&nbsp;&nbsp;&nbsp;long',
	'http://www.w3.org/2001/XMLSchema#int'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;int',
	'http://www.w3.org/2001/XMLSchema#short'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;short',
	'http://www.w3.org/2001/XMLSchema#float'=>'Float',
	'http://www.w3.org/2001/XMLSchema#double'=>'Double',
	'http://www.w3.org/2001/XMLSchema#duration'=>'Duration',
	'http://www.w3.org/2001/XMLSchema#dateTime'=>'DateTime',
	'http://www.w3.org/2001/XMLSchema#time'=>'&nbsp;&nbsp;Time',
	'http://www.w3.org/2001/XMLSchema#date'=>'&nbsp;&nbsp;Date',
	'http://www.w3.org/2001/XMLSchema#gYearMonth'=>'&nbsp;&nbsp;gYearMonth',
	'http://www.w3.org/2001/XMLSchema#gYear'=>'&nbsp;&nbsp;gYear',
	'http://www.w3.org/2001/XMLSchema#gMonthDay'=>'&nbsp;&nbsp;gMonthDay',
	'http://www.w3.org/2001/XMLSchema#gDay'=>'&nbsp;&nbsp;gDay',
	'http://www.w3.org/2001/XMLSchema#gMonth'=>'&nbsp;&nbsp;gMonth',
	'http://www.w3.org/2001/XMLSchema#hexBinary'=>'HexBinary',
	'http://www.w3.org/2001/XMLSchema#base64Binary'=>'Base64Binary',
	'http://www.w3.org/2001/XMLSchema#anyURI'=>'AnyURI',
);
function errorHandler($errno, $errstr, $errfile, $errline) {
	switch ($errno) {
		case E_ERROR:
		case E_CORE_ERROR:
		case E_COMPILE_ERROR:
		case E_USER_ERROR:
			echo "<div class=\"errfatal\"><b>FATAL:</b> [$errno] $errstr<br />\n";
			echo "in line $errline of file $errfile. <a href=\"javascript:void(powl.toggleVisibility('errbacktrace'));\">&gt;&gt;</a><div style=\"display:none;\" id=\"errbacktrace\">";
			if(function_exists('debug_backtrace'))
				errorRenderer(debug_backtrace());
			echo('</div></div>');
			exit(1);
			break;
		case E_WARNING:
		case E_CORE_WARNING:
		case E_COMPILE_WARNING:
		case E_USER_WARNING:
			if(!$GLOBALS['_POWL']['errors'][$errno][$errfile][$errline]) {
				echo "<div class=\"errwarning\"><b>WARNING:</b> [$errno] $errstr<br />\n";
				echo "in line $errline of file $errfile.<a href=\"javascript:void(powl.toggleVisibility('errbacktrace'));\">&gt;&gt;</a><div style=\"display:none;\" id=\"errbacktrace\">";
				if(function_exists('debug_backtrace'))
					errorRenderer(debug_backtrace());
				echo('</div></div>');
				$GLOBALS['_POWL']['errors'][$errno][$errfile][$errline]=true;
			}
			break;
		default:
#			echo "<b>NOTICE:</b> [$errno] $errstr<br />\n";
#			echo "in line $errline of file $errfile<br />";
			break;
	}
}
function errorRenderer($arr) {
	static $c;
	foreach($arr as $key=>$val) {
		#$val=is_object($val)?get_object_vars($val):$val;
		if(is_array($val)) {
			echo('<img onclick="powl.toggleVisibility(\'err'.++$c.'\')" id="optionalIMG'.$id.$cat.'" src="'.$GLOBALS['_POWL']['uriBase'].'images/plus.gif">&nbsp;'.$key.'<br /><div id="err'.$c.'" style="display:none;margin-left:20px;">');
			#print_r($val);
			errorRenderer($val);
			echo('</div');
		} else {
			echo('<div>'.$key.'=><xmp style="display:inline">');
			print_r($val);
			echo('</xmp></div>');
		}
	}
}
set_error_handler("errorHandler");
function pwlOutput($string) {
	echo(nl2br($string).'<br />');
	flush();
}
function pwlRewriteSQL($db, &$sql, $inputarray) {
	if(empty($GLOBALS['_POWL']['db']['tablePrefix']))
		return;
	foreach(array('statements','models','log_actions','log_action_descr','log_statements') as $table)
		$sql=preg_replace('/((on|table|insert(\s+into)?|update|from|join|,)\s+)'.$table.'/im','\1'.$GLOBALS['_POWL']['db']['tablePrefix'].$table,$sql);
}

function timer($t='global') {
	static $last;
	list($low, $high) = split(" ", microtime());
	$ret=sprintf("%f",$high + $low - $last[$t]);
	$last[$t]=$high + $low;
	if($GLOBALS['profile'])
		return $ret;
}
timer();

function pwlApplyTemplate($instance,$template,$prefix='') {
	preg_match_all('/\{'.preg_quote($prefix).'([A-Za-z0-9:\->]+)\}/',$template,$matches);
#print_r($matches);
	$ret=$template;
	foreach($matches[1] as $prop) {
		if($prop==':label')
			$rep=$instance->getLabel();
		else if($prop==':localName')
			$rep=$instance->getLocalName();
		else if($prop==':class') {
			$c=$instance->getClass();
			$rep=$c->getLocalName();
		} else if(strstr($prop,'->')) {
			$p=split('->',$prop);
			if($target=$instance->getPropertyValue($p[0]))
				if($v=$target->getPropertyValue($p[1]))
					$rep=$v->getLabel();
		} else if(is_a($instance,'rdfsresource')) {
#			$rep=$instance->getPropertyValuePlain($prop);
			if($v=$instance->getPropertyValue($prop))
				$rep=$v->getLabel();
			else $rep='';
#			$rep=iconv('UTF8','ISO-8859-1',$instance->getPropertyValuePlain($prop));
		}
		$ret=str_replace('{'.$prefix.$prop.'}',htmlentities(preg_replace("/([\xC2\xC3])([\x80-\xBF])/e","chr(ord('\\1')<<6&0xC0|ord('\\2')&0x3F)",$rep)),$ret);
	}
	return $ret;
}

function pwlArrayCopyValues2Indexes(&$array) {
	foreach($array as $key=>$val)
		$a[$val]=$val;
	$array=$a;
	return $a;
}

function pwlURLParamAdd($param,$value){
	return $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'&':'?').$param.'='.urlencode($value);
}
function pwlURLParamReplace($param,$value=false){
	$q = split('&', $_SERVER['QUERY_STRING']);
	$done=false;
	$url='';
	foreach($q as $val) {
		$e = split('=', $val);
		if($e[0]==$param || (is_array($param) && in_array($e[0],$param))) {
			$e[1]=$value;
			$done=true;
		}
		if($e[0] && $e[1])
			$url.="$e[0]=$e[1]&";
	}
	if(!$done && $value)
		$url.="$param=$value&";
#print_r($_SERVER['SCRIPT_NAME']);
	return ($_SERVER['REDIRECT_URL']?$_SERVER['REDIRECT_URL']:$_SERVER['PHP_SELF']).'?'.$url;
}

function pwlGetCurrentUser() {
}

function pwlGetUser() {
}

function pwlSessionVar() {
	$args=func_get_args();
	$sessVar=&$_SESSION['powlUserPref'];
	$sysont=$GLOBALS['powl']->getModel($GLOBALS['_POWL']['SysOntModelURI']);
	foreach($args as $arg) {
		if(empty($sessVar[$arg]))
			$sessVar[$arg]=array();
		$sessVar=&$sessVar[$arg];
		$last=$arg;
	}
	if(!empty($_REQUEST[$last]) && $todo=true)
		$sessVar=$_REQUEST[$last];
	if(!empty($_REQUEST[$last.'_add']) && false===array_search($_REQUEST[$last.'_add'],$sessVar) && $todo=true)
		$sessVar[]=$_REQUEST[$last.'_add'];
	if(!empty($_REQUEST[$last.'_del']) && false!==array_search($_REQUEST[$last.'_del'],$sessVar) && $todo=true)
		unset($sessVar[array_search($_REQUEST[$last.'_del'],$sessVar)]);
	if(!empty($_REQUEST[$last.'_up']) && false!==array_search($_REQUEST[$last.'_up'],$sessVar) && $todo=true) {
		$key=array_search($_REQUEST[$last.'_up'],$sessVar);
		if($key<count($sessVar)) {
			$tmp=$sessVar[$key+1];
			$sessVar[$key+1]=$sessVar[$key];
			$sessVar[$key]=$tmp;
		}
	}
	if(!empty($_REQUEST[$last.'_down']) && false!==array_search($_REQUEST[$last.'_down'],$sessVar) && $todo=true) {
		$key=array_search($_REQUEST[$last.'_down'],$sessVar);
		if($key>0) {
			$tmp=$sessVar[$key-1];
			$sessVar[$key-1]=$sessVar[$key];
			$sessVar[$key]=$tmp;
		}
	}
	if(!empty($todo) && $sysont && $user=$sysont->getInstance($_SESSION['PWL']['user'])) {
		if(is_array($sessVar))
			$sessVar=array_values(array_filter($sessVar));
		$user->setPropertyValue('userPreferences',serialize($_SESSION['powlUserPref']));
	} else if(!$sessVar && $last=='count')
		$sessVar=20;
	return $sessVar;
}
function pwlSessionVarGet() {
	$args=func_get_args();
	$sessVar=&$_SESSION['powlUserPref'];
	foreach($args as $arg) {
		if(empty($sessVar[$arg]))
			$sessVar[$arg]=array();
		$sessVar=&$sessVar[$arg];
		$last=$arg;
	}
	return $sessVar;
}
function pwlSessionVarSet() {
	$args=func_get_args();
	$value=array_shift($args);
	$sessVar=&$_SESSION['powlUserPref'];
	foreach($args as $arg) {
		if(empty($sessVar[$arg]))
			$sessVar[$arg]=array();
		$sessVar=&$sessVar[$arg];
		$last=$arg;
	}
	if($sessVar!=$value) {
		$sessVar=$value;
		if(is_array($sessVar))
			$sessVar=array_values(array_filter($sessVar));
		$user->setPropertyValue('userPreferences',serialize($_SESSION['powlUserPref']));
	}
}
function pwlGetCfg($cfg,$model='',$class='') {
	return 20;
}

function pwlDeny() {
	echo('Not allowed!');
	pwlHTMLFooter();
	exit;
}
/**
 * Returns a HTML form snippet combining meta information about a resource
 *
 * @param RDFSResource $resource
 * @return string $ret HTML code for the metainformations of this resource
 **/
function pwlResourceMetaShow($resource,$showIdentity=true,$editable=true) {
	$ret='';
#	$editable=$GLOBALS['powl']->aclCheck('Edit',$GLOBALS['_ET']['rdfsmodel'])&&!$resource->isImported()?true:false;

	$optionalCat=$resource->model->modelURI.get_class($resource);
	if($resource->model->type=='OWL' && $showIdentity) {
		$ret='<h2>'.pwlHTMLOptional('identity',$optionalCat).pwl_('Individual identity').'</h2><div id="identity"><table class="blind"><tr>';
		$selectClassConfig=array('AttributeStyle'=>'width:160px;');
		if(!$editable)
			$selectClassConfig['readonly']=true;
		$cs=new selectResource($selectClassConfig);
		foreach(array('sameAs'=>'Same as','differentFrom'=>'Different from') as $key=>$val)
			$ret.='<td valign="top"><b>'.pwl_($val).'</b><br />'.(method_exists($resource,"list$key")?$cs->edit($key,array_keys(call_user_func(array(&$resource,"list$key")))):'').'</td>';
		$ret.='</tr></table></div>';
	}
	$tab=new tab();
	$tabs=array('Comment'=>pwl_('Documentation'),'Labels'=>pwl_('Labels'),'Annotations'=>pwl_('Annotations'));
	$ret.='<h2>'.pwlHTMLOptional('meta',$optionalCat).'<img src="'.$GLOBALS['_POWL']['uriBase'].'images/Annotation.gif">&nbsp;'.pwl_('Metainformation').'</h2><div id="meta">';
	$ret.=$tab->show($tabs);
	// Comment
	$s=new select(array('cardinalityMax'=>1,'cardinalityMin'=>1));
	$clang=array('none'=>pwl_('Language'));
	foreach($resource->listLabelsPlain() as $key=>$val)
		if($key)
			$clang[$key]=$key;
	$ret.='<div id="Comment" class="tabarea" style="text-align:right;">'.$s->edit('commentLang','',$clang);
	foreach($resource->listComments() as $comment)
		$comments[$comment->getLanguage()]=$comment->getLabel();
	foreach($clang as $lang=>$val)
		$ret.='<div id="'.$lang.'"><textarea name="comments['.($lang=='none'?'':$lang).']" style="width:320px; height:145px;"'.($editable?'':' readonly="readonly"').'>'.(!empty($comments[$lang=='none'?'':$lang])?$comments[$lang=='none'?'':$lang]:'').'</textarea></div>';
	$ret.='</div>';
	// labels
	$ret.='<div id="Labels" class="tabarea"><table><tr><th>'.pwl_('Language').'</th><th>'.pwl_('Label').'</th></tr><tbody>';
	// show existing labels
	$labels=$resource->listLabels();
	$labels[]=new Literal('');
	foreach($labels as $label)
		$ret.='<tr name="dupl1"><td align="center"><input type="text" name="lang[]" value="'.$label->getLanguage().'" size="3"'.($editable?'':' readonly="readonly"').'></td>
			<td nowrap="nowrap"><input type="text" name="label[]" value="'.str_replace('"','&quot;',$label->getLabel()).'" style="width:230px;"'.(!$editable?' readonly="readonly">':'>&nbsp;<input type="image" onclick="if(document.getElementsByName(\'dupl1\').length>1) powl.remove(this.parentNode.parentNode); else this.parentNode.firstChild.value=\'\'; return false;" src="'.$GLOBALS['_POWL']['uriBase'].'images/delete.gif" title="'.pwl_('Remove').'" />').'</td></tr>';
	// create new
	$ret.="</tbody><tr><th colspan=\"2\" align=\"left\">".($editable?"<img src=\"../../images/item_ltr.png\" align=\"absmiddle\">&nbsp;<a href=\"javascript:powl.duplicate('dupl1')\">".pwl_('Add')."</a>":'&nbsp;')."</th></tr>";
	$ret.="</table></div>";
	// annotations
	$ret.="<div id=\"Annotations\" class=\"tabarea\"><table><tr><th>Property</th><th>Value</th></tr><tbody>";
	foreach($resource->model->listAnnotationProperties(true) as $ap)
		$annotationProperties[$ap->getURI()]=$ap->getLocalName();

	$sConfig=array('cardinalityMax'=>1,'cardinalityMin'=>1,'aAttributeStyle'=>'width:100px;');
	if(!$editable)
		$sConfig['readonly']=true;
	$s=new select($sConfig);
	$washere=false;
	foreach($annotationProperties as $annotationProperty=>$ln)
		foreach($resource->listPropertyValues($annotationProperty) as $annotationValue) {
			$washere=true;
			$ret.='<tr name="dupl"><td>';
			$ret.=$s->edit('annotationProperty[]',$annotationProperty,$annotationProperties);
			$ret.='</td><td nowrap="nowrap">'.(($lf=substr_count($annotationValue->getLabel(),"\n"))?
					'<textarea name="annotationValue[]" style="width:185px;" rows="'.min($lf-1,5).'">'.$annotationValue->getLabel().'</textarea>':
					'<input type="text" name="annotationValue[]" value="'.str_replace('"','&quot;',$annotationValue->getLabel()).'" style="width:185px;"'.($editable?'':' readonly="readonly"').'>');
			if($editable)
				$ret.='&nbsp;<input type="image" onclick="if(document.getElementsByName(\'dupl\').length>1) powl.remove(this.parentNode.parentNode); else this.parentNode.firstChild.value=\'\'; return false;" src="'.$GLOBALS['_POWL']['uriBase'].'images/delete.gif" title="'.pwl_('Remove').'" />';
			$ret.='</td></tr>';
		}
	// if no annotations are given
	if(!$washere && $editable) {
		$ret.='<tr name="dupl"><td>';
		$ret.=$s->edit('annotationProperty[]','',$annotationProperties);
		$ret.='</td><td nowrap="nowrap"><input type="text" name="annotationValue[]" value="" style="width:185px;">&nbsp;<input type="image" onclick="if(document.getElementsByName(\'dupl\').length>1) powl.remove(this.parentNode.parentNode); else this.parentNode.firstChild.value=\'\'; return false;" src="'.$GLOBALS['_POWL']['uriBase'].'images/delete.gif" title="'.pwl_('Remove').'" /></td></tr>';
	}
	if($editable) {
		$ret.='</tbody><tr><th colspan="2" align="left"><img src="../../images/item_ltr.png" align="absmiddle">&nbsp;<a href="javascript:powl.duplicate(\'dupl\')">'.pwl_('Add').'</a></th></tr>';
	}
	$ret.='</table></div></div>';
	return $ret;
}

/**
 * Sets meta information about a resource from $_REQUEST
 *
 * @param $resource
 **/
function pwlResourceMetaProcess($resource) {
	// save labels for resource
	$labels=array();
	foreach($_REQUEST['lang'] as $key=>$val)
		if(!empty($_REQUEST['label'][$key]))
			$labels[]=new RDFSLiteral($_REQUEST['label'][$key],$val);
	$resource->setLabel($labels,NULL);
	// save comment for resource
	if($_REQUEST['comments'])
		foreach($_REQUEST['comments'] as $key=>$comment)
			$resource->setComment($comment?$comment:array(),$key!==0?$key:'');
	// save annotations for resource
	$annotations=array();
	foreach($_REQUEST['annotationProperty'] as $key=>$val)
		if($_REQUEST['annotationValue'][$key])
			$annotations[$val][]=new RDFSLiteral($_REQUEST['annotationValue'][$key]);
	foreach(array_diff(array_keys($resource->model->listAnnotationProperties(true)),array_unique($_REQUEST['annotationProperty'])) as $removed)
		$resource->setPropertyValues($removed);
	foreach($annotations as $property=>$values)
		$resource->setPropertyValues($property,$values);

	if(method_exists($resource,'setSameAs'))
		foreach(array('sameAs','differentFrom') as $value)
			call_user_func(array($resource,"set$value"),!empty($_REQUEST[$value])?$_REQUEST[$value]:'');
}
function pwlResourceVersioning($resource='') {
	if($resource && $resource->model->logEnabled()) {
		$optionalCat=$resource->model->modelURI.get_class($resource);
		return '<h2>'.pwlHTMLOptional('version',$optionalCat).pwl_('Versioning comment').'</h2><div id="version"><textarea name="versioningDetails"></textarea></div>';
	}
}
function pwlShowViewLinks($type) {
	if(empty($GLOBALS['_POWL']['SysOnt']))
		return;
	if(!$view=$GLOBALS['_POWL']['SysOnt']->getClass('View'))
		return;
	if($views=$view->findInstances(array('viewResourceType'=>$type))) {
		$ret='<br /><img src="../../images/item_ltr.png" align="absmiddle">&nbsp;'.pwl_("Other").':<br />';
		foreach($views as $view)
			$ret.='<span title="'.$view->getPropertyValuePlain('rdfs:comment').'" style="white-space:nowrap;"><input style="margin-left:0px;" type="radio" name="target" value="../'.$view->getPropertyValuePlain('viewScript').'" onchange="treeviewJS.baseURL=this.value;" />&nbsp;<a href="javascript:void(loadDetails(\'../'.$view->getPropertyValuePlain('viewScript').'\'));">'.$view->getLabelForLanguage().'</a>&nbsp;|&nbsp;</span>';
	}
	return $ret;
}
class powlModule {
}

class powlModuleTab extends powlModule {
	var $conf=array(
		'tabpage'=>'index.php',
		'css'=>'',
		'js'=>'',
	);
}

function pwlGetSysOntClass($localName) {
	if(!empty($GLOBALS['_POWL']['SysOnt']->modelURI) && $class=$GLOBALS['_POWL']['SysOnt']->getClass($GLOBALS['_POWL']['SysOnt']->baseURI.$localName))
		return $class;
}

function pwlGetSysOntInstance($instance) {
	if($GLOBALS['_POWL']['SysOnt']->modelURI && $instance=$GLOBALS['_POWL']['SysOnt']->getInstance($instance))
		return $instance;
}

function pwlGetSysOntClassInstances($localName) {
	if($class=pwlGetSysOntClass($localName))
		return $class->listInstances();
	else return array();
}

function pwlListSysOntInstancePropertyValues($instance) {
	if($inst=pwlGetSysOntInstance($instance))
		return $inst->listAllPropertyValuesPlain();
	else
		return array();
}

function pwl_($name,$lang='') {
	static $texts;
	static $labelclass;
#print_r(timer().'Name:'.$name.'<br/>');
	if($GLOBALS['_POWL']['db']['backend']=='powl')
		return $name;
	$ret=$name;
	$lang=$lang?$lang:(!empty($_SESSION['PWL']['language'])?$_SESSION['PWL']['language']:'en');
	if(empty($labelclass))
		$labelclass=pwlGetSysOntClass('Label');
	if(!$texts[$lang] && $labelclass) {
		$texts[$lang]=$labelclass->listInstanceLabels($lang);
		if($lang!='en')
			$texts['en']=$labelclass->listInstanceLabels('en');
	}
	if(!empty($GLOBALS['_POWL']['SysOnt']->modelURI) && $name)
	if($labelclass) {
		if(!empty($texts['en'][$name])) {
			$ret=!empty($texts[$lang][$name][0])?$texts[$lang][$name][0]:$texts['en'][$name][0];
			$help=!empty($texts[$lang][$name][1])?$texts[$lang][$name][1]:$texts['en'][$name][1];
			$helpurl=!empty($texts[$lang][$name][2])?$texts[$lang][$name][2]:'';
			$helpurl=str_replace('owl:','http://www.w3.org/TR/owl-guide/#',$helpurl);
			if(strpos($helpurl,'owl-ref:')===0)
				$helpurl=str_replace('owl-ref:','http://www.w3.org/TR/owl-ref/#',$helpurl).'-def';
		} else {
			$instance=$GLOBALS['_POWL']['SysOnt']->addInstance($GLOBALS['_POWL']['SysOnt']->getUniqueResourceURI('Label'),$labelclass);
			$instance->setPropertyValue('labelText',$name);
			$instance->addLabel($name,'en');
			$texts['en'][$name]=$name;
			$ret=$name;
			$file=str_replace($GLOBALS['_POWL']['installPath'],'',($_SERVER['PATH_TRANSLATED']?preg_replace('/\\\+/', '/', $_SERVER['PATH_TRANSLATED']):$_SERVER['SCRIPT_FILENAME']));
			$instance->addPropertyValue('labelScript',$file);
		}
	}
	return !empty($help)?"<".($helpurl?'a href="'.$helpurl.'" target="docu" style="color:inherit"':'span')." title=\"".htmlentities($help)."\" class=\"help\">$ret</".($helpurl?'a':'span').">":$ret;
}
function pwlHTMLOptional($id,$cat,$class='optional') {
	return '<a class="'.$class.'" href="javascript:powl.optionalToggle(\''.$id.'\',\''.$cat.'\')"><img id="optionalIMG'.$id.$cat.'" src="'.$GLOBALS['_POWL']['uriBase'].'images/minus.gif"></a>'.
		'<script language="javascript">powl.SafeAddOnload(function() { powl.optional(\''.$id.'\',\''.$cat.'\'); });</script>';
}
function pwlListHead($start,$erg,$end) {
	if(!is_numeric($erg)) $erg=$end;
	$first = pwl_("|&lt;");
	$last = pwl_("&gt;|");
	$firsth = pwl_("|&lt;");
	$lasth = pwl_("&gt;|");
	$next='';
	$nexth='';
	$prev='';
	$prevh='';
	if($end>0) {
		$ret=($end>1?sprintf(pwl_("Search returned <b>%d</b> results."),$end):pwl_("Search returned 1 result."));
		if($_SESSION['PWL']['user'])
			$ret.='<a title="'.pwl_('Configure how many results should be displayed.').'" href="javascript:var erg=prompt(\''.pwl_('Number of results to display:').'\',\''.$erg.'\'); if(erg>0) document.location.href=document.location.href.replace(/count=[0-9]+/,\'\')+(document.location.search?\'&\':\'?\')+\'count=\'+erg;">[c]</a>';
		if($end>$erg) { // paging
			$ret.="<BR>";
			if($start>0)
				$ret.="<a href='".pwlURLParamReplace('start',0)."' title=\"".pwl_('Show first results.')."\">".$firsth."</A> <A HREF='".pwlURLParamReplace('start',($start-$erg))."'>".$prevh."</A>";
			else $ret.=$first." ".$prev;
			$ret .= " | ";
			if($start/$erg-3>0)
				$ret.='<a title="'.pwl_('Go to page:').'" href="javascript:var start=prompt(\''.pwl_('Go to page:').'\'); if(start>0 && start<'.(ceil($end/$erg)).') document.location.href=document.location.href.replace(/start=[0-9]+/,\'\')+(document.location.search?\'&\':\'?\')+\'start=\'+((start-1)*'.$erg.');">...</a> | ';
			for($i=max($start/$erg-3,0);$i<min($start/$erg+4,$end/$erg);$i++)
				$ret.=($start==$i*$erg?'<b><i':'<a href="'.pwlURLParamReplace('start',$i*$erg).'"').' title="'.pwl_('Results:').' '.($i*$erg+1)."-".min($i*$erg+$erg,$end)."\">".($i+1).($start==$i*$erg?"</i></b>":'</a>')." | ";
			if($start/$erg+4<$end/$erg)
				$ret.='<a title="'.pwl_('Go to page:').'" href="javascript:var start=prompt(\''.pwl_('Go to page:').'\'); if(start>0 && start<'.(ceil($end/$erg)).') document.location.href=document.location.href.replace(/start=[0-9]+/,\'\')+(document.location.search?\'&\':\'?\')+\'start=\'+((start-1)*'.$erg.');">...</a> | ';
			if($start + $erg < $end)
				$ret.="<a href='".pwlURLParamReplace('start',$start+$erg)."'>".$nexth."</A> <A HREF='".pwlURLParamReplace('start',($end-$end%$erg))."' title=\"".pwl_('Show last results.')."\">".$lasth."</A>";
			else $ret.=$next." ".$last;
		}
	} else
		$ret=pwl_("Search request returned no results.");
	return "<P>".$ret."</P>";
}
function pwlListRow($row) {
	static $i;
	$ret='<tr class="'.(++$i%2==0?'':'even').'">';
	foreach($row as $field)
		$ret.='<td>'.$field.'</td>';
	return $ret.'</tr>';
}
?>