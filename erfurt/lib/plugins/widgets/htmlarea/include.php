<?php
/**
 * htmlarea widget
 * 
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004 
 * @access public
 **/

class htmlarea extends powlModuleWidget {
	var $config=array();

	/**
	 * This function gets the property values for the Htmlarea configured instances.
	 * It returns the Javascript source code for initEditor().
	 * Possible instances are:
	 * 	- fontnames, fontsizes, css styles or formatting elements	 
	 * The Javascript source code will be a string and look like that:	 
	 *	"key1":	   'value1',
	 *	"key2":	   'value2'
	 *
	 * @param RDFSInstance $instance	 
	 * @return string $htmlarea_js The Javascript source code
	 **/		
	function getConfigInstanceProperties($instance) {				
		$prop = pwlListSysOntInstancePropertyValues($instance);	
		$js_string='';
		$i=0;
		foreach($prop as $values) {
			foreach($values as $val){		
				$_tmp = explode(":",$val);				
				if(!empty($_tmp[1])) {
					$js_string.='"'.$_tmp[0].'":  "'.trim($_tmp[1]).'",'."\n";			
				} else {
					$js_string.='"'.$_tmp[0].'pt":  "'.(++$i).'",'."\n";
				}
			}
		}						
		$htmlarea_js = substr($js_string,0,strlen($js_string)-2);
		return $htmlarea_js;
	}
	
	function edit($name,$value,$config=false) {	
		$config=$config?array_merge($this->config,$config):$this->config;				
		$btntime=rand(100,999);
		$ret='<script type="text/javascript">
			_editor_url = "'.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/htmlarea/HTMLArea/";
			_editor_lang = "'.$_SESSION['PWL']['language'].'";
			</script>';
		$ret.= '<script language="javascript" src="'.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/htmlarea/HTMLArea/htmlarea.js"></script>';
		$ret.= '<script language="javascript" src="'.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/htmlarea/HTMLArea/lang/en.js"></script>';
		$ret.= '<script language="javascript" src="'.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/htmlarea/HTMLArea/dialog.js"></script>';
		$ret.= '<script type="text/javascript">';		
				
      		// Load the configured Plugins
      		if($config['Tableoperations']) {
      			$ret.='HTMLArea.loadPlugin("TableOperations");';
      		}
      		if($config['Fullpage']) {
      			$ret.='HTMLArea.loadPlugin("FullPage");';
      		}
      		if($config['Spellchecker']) {
      			$ret.='HTMLArea.loadPlugin("SpellChecker");';
      		}
      		if($config['Contextmenu']) {
      			$ret.='HTMLArea.loadPlugin("ContextMenu");';
      		}
      		if($config['Css']) {
      			$ret.='HTMLArea.loadPlugin("css");';
      		}
      		
      		// Show new editor'.$btntime.' with given config
		$ret.=' var editor'.$btntime.' = null;		
			function initEditor() {
			
				editor'.$btntime.' = new HTMLArea("'.$name.'");
				// load fontnames			
				editor'.$btntime.'.config.fontname = {'."\n";				
				$ret.= $this->getConfigInstanceProperties($config['Font']);				
				$ret.= '};
				//load fontsize
				editor'.$btntime.'.config.fontsize = {'."\n";
				$ret.= $this->getConfigInstanceProperties($config['Fontsize']);
				$ret.= '};					
				//load formating elements
				editor'.$btntime.'.config.formatblock = {'."\n";				
				$ret.= $this->getConfigInstanceProperties($config['Blocktype']);
				$ret.= '};
				editor'.$btntime.'.config.customSelects = {};'."\n";			
				// remove buttons which are not configured
				$htmlarea_buttons = pwlListSysOntInstancePropertyValues($config['Buttons']);
				foreach($htmlarea_buttons as $key=>$val) {			
					$bname=substr($key,14,strlen($key)-1);										
					if(!$val[0])
						$ret.='editor'.$btntime.'.config.hideSomeButtons(" '.strtolower($bname).' ");'."\n";
				}
				// Show the loaded plugins
				if($config['Tableoperations']) {      		
					$ret.='editor'.$btntime.'.registerPlugin(TableOperations);';
				}
				if($config['Fullpage']) {
					$ret.='editor'.$btntime.'.registerPlugin(FullPage);';
				}
				if($config['Spellchecker']) {
					$ret.='editor'.$btntime.'.registerPlugin(SpellChecker);';
				}
				if($config['Contextmenu']) {
					$ret.='editor'.$btntime.'.registerPlugin("ContextMenu");';
				}
				if($config['Css']) {
					$ret.='	  editor'.$btntime.'.registerPlugin(CSS, {
						combos : [
					  	{ label: "CSS:",
							options: { "None"           : "",';								
								$ret.= $this->getConfigInstanceProperties($config['Styles']);							
								$ret.='}
					      			}
					    		]
					 	});
					editor'.$btntime.'.config.pageStyle = "@import url(\''.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/htmlarea/custom.css\');";';
				}  

				$ret.=' setTimeout(function() {
					    editor'.$btntime.'.generate();
				}, 500);
				return false;
			
			}</script>';		
		$ret.= '<script language="javascript" src="'.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/htmlarea/scripts.js"></script>';
		$ret.= '<textarea name="'.$name.'" id="'.$name.'"
			style="'.(!empty($config['Width'])?'width:'.$config['Width'].'px; ':'').(!empty($config['Width'])?'Height:'.$config['Height'].'px':'').'"'.
			(!empty($config['Cols'])?' cols="'.$config['Cols'].'"':'').
			(!empty($config['Rows'])?' rows="'.$config['Rows'].'"':'').'>'.(!empty($value)?$value:'').'</textarea>';		
		return $ret;
	}
}
?>