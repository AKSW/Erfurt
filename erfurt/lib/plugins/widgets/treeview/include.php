<?php
/**
 * treeview widget
 * 
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: include.php 287 2004-06-05 11:16:11Z soerenauer $
 * @access public
 **/

class treeview extends powlModuleWidget {
	var $config=array();
	function show($nav,$pref='') {
		global $_POWL;
		static $counter;
		$counter++;
		$count=$counter;
		$nav=array_filter($nav);
		$c=0;
		$ret='';
		foreach($nav as $n) {
			$target="details";
			if(!empty($n[4])) {
				$target=$n[4];
			}
			$c++;
			$id=$count.'-'.$c;
			if($n[0])
				$ret.=$pref.'<img src="'.$_POWL['uriBase'].'images/tree/'.($c==count($nav)?'corner':'tee').(is_array($n[3]) && count($n[3])?'plus.gif" border="0" onclick="treeview.toggleVisibility(\'nav'.$id.'\')" id="imgnav'.$id:'.gif').'" align="absmiddle">&nbsp;'.
				      ($n[2]?"\n<a id=\"tree$id\" onclick=\"treeview.select('$id'); parent.frames['$target'].location.href='$n[2]'; return false;\" href=\"$n[2]\" title=\"$n[1]\" target=\"$target\">$n[0]</a>":$n[0]).'<br>';
			if(is_array($n[3]) && count($n[3]))
				$ret.="\n".'<div id="nav'.$id.'" style="display:none;">'.
					$this->show($n[3],$pref.'<img src="'.$GLOBALS['_POWL']['uriBase'].'images/tree/'.($c==count($nav)?'space.gif" width="19" height="16':'line.gif').'" border="0" align="absmiddle">').
					'</div><script language="javascript">if(powl.getState(\'treeview\',\'nav'.$id.'\')) treeview.toggleVisibility(\'nav'.$id.'\');</script>'."\n";
		}
		if($pref=='')
			$ret='<link rel="stylesheet" type="text/css" media="screen" href="'.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/treeview/styles.css"></style>'.
			     '<script language="javascript" src="'.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/treeview/scripts.js"></script>'.
				 '<div class="treeview">'.$ret.'</div>';
		return $ret;
	}
	function renderEntry($entry,$id) {
		return ($entry['href']?"\n<a id=\"tree$id\" onclick=\"treeview.select('$id'); parent.frames['$entry[target]'].location.href='$entry[href]'; return false;\" href=\"$entry[href]\" title=\"$entry[title]\" target=\"$entry[target]\">$entry[text]</a>":$entry['text']);
	}
}

?>