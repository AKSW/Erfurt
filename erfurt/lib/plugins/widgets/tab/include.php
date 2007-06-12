<?php
/**
 * treeselect widget
 *
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: include.php 547 2006-01-31 19:01:15Z soerenauer $
 * @access public
 **/
class tab extends powlModuleWidget {
	var $_require=array(
		'js'=>'scripts.js',
		'css'=>'styles.css'
	);
	function show($tabs,$current='') {
		static $tabcount;

		$this->name=$tab='tab'.(md5(join('',array_keys($tabs))));
		$ret='<script language="javascript"> var '.$tab.'=new tab();'.
			(!empty($this->config['urlbase'])?$tab.'.urlbase="'.$this->config['urlbase'].'";':'').
			'powl.SafeAddOnload(function() { '.$tab.'.'.(!empty($this->config['urlbase'])?'select':'stateSelect').'("'.($current?$current:parray_shift(array_keys($tabs))).'"); });</script>';
		$ret.='<ul class="tab" id="'.$tab.'">';
		foreach($tabs as $id=>$tabname)
			$ret.='<li id="tab'.$id.'" name="'.$tab.'"><a href="javascript:'.$tab.'.click(\''.$id.'\')">'.$tabname.'</a></li>';
		$ret.='</ul><div>&nbsp;</div>';
		return $ret;
	}
}
?>