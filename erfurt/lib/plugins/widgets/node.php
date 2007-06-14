<?php
/**
 * rdf node editing widget
 *
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: node.php 965 2007-05-01 16:35:48Z nheino $
 * @access public
 **/
class editliteral extends powlModuleWidget {
	
	/**
	  *
	  *
	  * @param $formElemName
	  * @param $values
	  * @param $config
	  * @return
	  */
	function edit($formElemName, $values = array(''), $config = array()) {
		
		if (!$values)
			$values = !empty($this) && !empty($this->config['values']) ? 
					$this->config['values'] : 
					array('');
			
		if (!is_array($values) || $values['value'])
			$values = array($values);
			
		if (!empty($this) && is_array($this->config))
			$config = array_merge($config, $this->config);
			
		foreach ($values as $value) {
			$name = $formElemName.(count($values) > 1 || 
					($config['cardinality'] != 1 && 
					$config['cardinalityMax'] != 1) ? '['.++$c.']' : '');
					
			if (is_array($value) && $value['value'])
				$value = new RDFSLiteral($value['value'],$value['lang'],$value['dtype']);
				
			if (!is_a($value,'literal'))
				$value = new Literal(is_a($value, 'Resource') ? $value->getURI() : $value);
				
			$ret.='<table name="'.$formElemName.'" 
			         onmouseout="powl.setStyle(this.rows[1],\'visibility\',\'hidden\'); 
			         powl.setStyle(this.rows[0].cells[1],\'visibility\',\'hidden\')"
					 onmouseover="powl.setStyle(this.rows[1],\'visibility\',\'\'); 
					 powl.setStyle(this.rows[0].cells[1],\'visibility\',\'\')"
					 class="blind"'.(empty($config['fixedSize']) ? '' : '
					 style="width:100%;height:90%;"').'><tbody><tr><td colspan="2">';
			
			// if text length is < 100 use an <input> else use a <textarea>
			if (!strstr($value->getLabel(), "\n") && 
					(strlen($value->getLabel()) < 100 || !strstr($value->getLabel(), ' '))) {
						
				$ret.='<input type="text" name="'.$name.'[value]"'.
					(!empty($config['AttributeStyle']) ? ' style="'.$config['AttributeStyle'].'"' : '').
					'value="'.htmlspecialchars($value->getLabel()).'" />';
			} else {
				$ret.='<textarea name="'.$name.'[value]" rows="5"'.
					(!empty($config['AttributeStyle']) ? ' style="'.$config['AttributeStyle'].'"' : '').
					'>'.$value->getLabel().'</textarea>';
			}
			
			$ret.='<script language="javascript">';
			if (empty($config['fixedSize']))
				$ret.='powl.SafeAddOnload(function() { textResize("'.$name.'[value]"); });';
			else {
				$ret.='window.onresize=function() { getObj("'.$name.
						'[value]").style.height=window.innerHeight-105+\'px\'; }; getObj("'.
						$name.'[value]").style.height=window.innerHeight-105+\'px\';';
			}
			$ret.='</script></td>';
			
			$ret.='<td style="visibility:hidden; vertical-align:middle"><img src="'.Zend_Registry::get('config')->erfurtPublicUri.
					'/images/delete.gif" valign="absbottom" onclick="if(document.getElementsByName(\''.
					$formElemName.'\').length>'.max($config['minCardinality'],$config['cardinality'],1).
					') powl.remove(powl.getAncestor(this,\'table\')); else document.getElementsByName(\''.
					$name.'[value]\')[0].value=\'\'" /></td>';
					
			$ret.='</tr><tr style="font-size:x-small; visibility:hidden;">';
			$ret.='<td style="vertical-align:top"><input style="font-size:x-small;" type="text" name="'.
					$name.'[lang]" value="'.($value->getLanguage() ? $value->getLanguage() : 'Lang').
					'" style="width:3em;" onclick="if(this.value==\'Lang\') '.
					'this.value=\'\'" onblur="if(this.value==\'\') this.value=\'Lang\'" />';
			
			if ($config['datatype'])
				$ret.='<input type="hidden" name="'.$name.'[dtype]" value="'.$config['datatype'].'" />';
			else {
				$ret.=select::edit($name.'[dtype]', $value->getDatatype(), 
						array_merge(array(''=>pwl_('Datatype')), Zend_Registry::get('datatypes')), 
						array('cardinalityMax'=>1, 'AttributeStyle'=>'font-size:x-small;'));
			}
			$ret.='</td>';
			
			if (empty($config['fixedSize'])) {
				$ret.='<td style="font-size:x-small; text-align:right">'.
				        '<a onclick="textHReduce(\''.$name.'[value]\')" '.
								'title="Horizontally reduce text field.">[&lt;]</a>&nbsp;'.
						'<a onclick="textVReduce(\''.$name.'[value]\')" '.
								'title="Vertically reduce text field.">[&and;]</a>&nbsp;'.
						'<a onclick="textVExpand(\''.$name.'[value]\')" '.
								'title="Vertically expand text field.">[&or;]</a>&nbsp;'.
						'<a onclick="textHExpand(\''.$name.'[value]\')" '.
								'title="Horizontally expand text field.">[&gt;]</a>'.
					  '</td>';
			}
			$ret.='</tr></tbody></table>';
			
			if ($config['cardinality'] != 1 && $config['cardinalityMax'] != 1)
				$ret.='<img src="'.Zend_Registry::get('config')->erfurtPublicUri.'/images/plus.gif" '.
					'valign="absbottom" onclick="'.($config['maxCardinality'] || 
					$config['cardinality'] ? 'if(document.getElementsByName(\''.
					$formElemName.'\').length>'.min($config['maxCardinality'], 
					$config['cardinality']).') ' : '').'this.insertAdjacentHTML(\'beforeBegin\','.
					'powl.getOuterHTML(this.previousSibling).replace(/'.
					preg_quote($formElemName).'\[[0-9]+]/g,\''.$formElemName.
					'[\'+Math.round(Math.random()*10000)+\']\').replace(/\bvalue=\x22[\S]*\x22/g, \'\'));" />';
		}
		return $ret;
	}
}

/**
  * ???
  *
  */
class editnode extends powlModuleWidget {
	
	/**
	  *
	  * @param $formElemName
	  * @param $values
	  * @param $config
	  */
	function edit($formElemName, $values = array(''), $config = array()) {
		
		if (!$values)
			$values = !empty($this) && !empty($this->config['values']) ? 
				$this->config['values'] : 
				array('');
			
		if (!is_array($values) || $values['uri'])
			$values = array($values);
			
		if (!empty($this) && is_array($this->config))
			$config = array_merge($config, $this->config);
			
		// if(is_array($value) && $value['value']) {
		// 	if($value['type']=='literal')
		// 		$value=new RDFSLiteral($value['value'],$value['lang'],$value['dtype']);
		// 	else
		// 		$value=new Resource($value['value']);
		// }

		$opts = array('resource'=>'Resource', 'literal'=>'Literal');
		
		// if($value)
		// 	$opts['remove']='Remove';
		
		foreach ($values as $value) {
			$name = $formElemName.'['.++$c.']';
			$ret.='<div><div style="font-size:x-small;">'.checkbox::edit($name.'[type]', 
					is_a($value, 'Literal') ? 'literal' : 'resource', $opts, 
					array('cardinality'=>1, 'prefix'=>$name, 
					'Attributes'=>'style="width:10px;"', 'separator' => '&nbsp;')).'</div>';
					
			$ret.='<div id="'.$name.'resource"'.(!is_a($value, 'literal') ? 
					'' : 
					' style="display:none"').'>'.editResource::edit($name.'[uri]', 
					$value,array_merge($config,array('cardinality'=>1))).'</div>';
					
			$ret.='<div id="'.$name.'literal"'.(is_a($value,'Literal') ? 
					'' : 
					' style="display:none"').'>'.editLiteral::edit($name, $value, 
						array_merge($config, array('cardinality'=>1))).'</div></div>';
		}
		
		if ($config['cardinality'] != 1 && $config['cardinalityMax'] != 1)
			$ret.='<img src="'.Zend_Registry::get('config')->erfurtPublicUri.'/images/plus.gif" valign="absbottom" onclick="'.
			($config['maxCardinality'] || $config['cardinality'] ? 'if(document.getElementsByName(\''.
					$formElemName.'\').length>'.min($config['maxCardinality'], 
					$config['cardinality']).') ' : '').'this.insertAdjacentHTML('.
					'\'beforeBegin\',powl.getOuterHTML(this.previousSibling).replace(/'.
					preg_quote($formElemName).'\[[0-9]+]/g,\''.$formElemName.
					'[\'+Math.round(Math.random()*10000)+\']\').replace(/\bvalue=\x22[\S]*\x22/g, \'\'));" />';
		
		return $ret;
	}
}


class editResource extends powlModuleWidget {
	
	function edit($formElemName, $value = array(''), $config = array()) {
		if (!empty($this) && is_array($this->config))
			$config = array_merge($this->config,$config);
			
		$value = is_a($value, 'Resource') ? $value->getLocalName() : $value;
		$value = is_a($value, 'Literal') ? $value->getLabel() : $value;
		$value = is_array($value) ? $value : ($value ? array($value=>$value) : array(''));
		
		if (!empty($config['cardinality']))
			$config['cardinalityMax'] = $config['cardinalityMin'] = 1;
		
		$attributes = (!empty($config['Attributes']) ? ' '.$config['Attributes'] : '').'"'.
			(!empty($config['size']) ? ' size="'.$config['size'].'"' : '').
			(!empty($config['length']) ? ' length="'.$config['length'].'"' : '').
			(!empty($config['AttributeClass']) ? ' class="'.$config['AttributeClass'].'"' : '').
			(!empty($config['AttributeStyle']) ? ' style="'.$config['AttributeStyle'].'"' : '');
		
		$get_class='selectresource';
		
		if (!$value)
			$value[]='';
			
		$r='<script type="text/javascript" src="'.Zend_Registry::get('config')->erfurtLibUri.
				'plugins/widgets/selectInstance/scripts.js"></script><span>';
		
		foreach ($value as $val) {
			$name = $formElemName.(empty($config['cardinalityMax']) || 
					!$config['cardinalityMax'] == 1 ? '['.++$c.']' : '');
					
			$r.='<div '.(!$config['readonly'] ? 'onmouseover="powl.setStyle(powl.getChild(this,\'img\'),\'visibility\',\'\')" onmouseout="powl.setStyle(powl.getChild(this,\'img\'),\'visibility\',\'hidden\')" ' : '').'name="add'.$name.'" style="white-space:nowrap">'.
				'<input type="text" style="color:blue" onfocus="this.select();" onblur="powl.setVisibility(document.getElementById(\''.$name.'.liveSearchDiv\'),\'none\');" onchange="selectResource.liveSearch(this)" onkeyup="selectResource.liveSearch(this)" id="'.$name.'" name="'.$name.'" value="'.htmlspecialchars(is_object($val)?$val->getLocalName():$val).'"'.($config['readonly'] || $get_class!='selectresource'?' readonly="readonly"':'').$attributes.'>';
				
			if($config['showEdit'])
				$r.='&nbsp;<input type="image" onclick="window.open(\''.Zend_Registry::get('config')->erfurtLibUri.'plugins/widgets/selectInstance/resource.php?uri=\'+this.parentNode.firstChild.value,\'Edit Instance\',\'resizable=1,scrollbars=1\'); return false;" src="'.Zend_Registry::get('config')->erfurtPublicUri.'images/edit.gif" title="'.pwl_('Edit').'" />&nbsp;';
			if(!$config['readonly'])
				$r.='<img style="visibility:hidden" onclick="if(document.getElementsByName(\''.$name.'\').length>1) powl.remove(this.parentNode); else document.getElementsByName(\''.$name.'\')[0].value=\'\'; return false;" src="'.Zend_Registry::get('config')->erfurtPublicUri.'images/delete.gif" title="'.pwl_('Remove').'" />';
			$r.='<br /><div id="'.$name.'.liveSearchDiv" style="position:absolute; display:none;"><select style="width:85%" size="5" id="'.$name.'.liveSearch" onclick="document.getElementById(\''.$name.'\').value=this.value; powl.setVisibility(this.parentNode,\'none\')"></select></div></div>';
		}
		
		$r.='</span>';
		if(!$config['readonly']) {
			if(empty($config['cardinalityMax']) || !$config['cardinalityMax']==1)
#				$r.='<a id="dupl'.$name.'" href="javascript:powl.duplicate(\'add'.$name.'\')" title="'.pwl_('Add').'"><img src="'.$GLOBALS['_POWL']['uriBase'].'/images/plus.gif" valign="absbottom" /></a>&nbsp;';
				$r.='<img onclick="this.previousSibling.insertAdjacentHTML(\'afterEnd\',powl.getOuterHTML(this.previousSibling.firstChild).replace(/'.preg_quote($formElemName).'\[[0-9]+]/g,\''.$formElemName.'[\'+Math.round(Math.random()*10000)+\']\').replace(/\bvalue=\x22[\S]*\x22/g, \'\'));" title="'.pwl_('Add').'" src="'.Zend_Registry::get('config')->erfurtPublicUri.'/images/plus.gif" valign="absbottom" />&nbsp;';
			if($config['showSelector'])
				$r.='<a href="javascript:powl.winopen(\''.Zend_Registry::get('config')->erfurtLibUri.'plugins/widgets/selectInstance/selectInstance.php?resource='.$get_class.(!empty($config['class'])?'&uri='.urlencode(urlencode(serialize(array_keys($config['class']->getURI())))):'').'&element='.urlencode(urlencode($name)).'\',\'selectInstance\',\'height=400,width='.($get_class=='selectinstance'||$get_class=='selectresource'?600:300).'\');" title="'.pwl_('Select').'">[s]</a>';
		}
		return $r;
	}
}
?>