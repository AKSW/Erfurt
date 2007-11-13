<?php
interface Erfurt_Store_MainInterface extends Erfurt_Store_DataInterface {
	
	public function init();
	public function isSetup();
		
	public function aclCheck($accessType,$model='',$property='',$class='',$instance='');
	public function aclCompute($user,$accessType,$model,$property='',$class='',$instance='');
	public function aclGet($user,$accessType,$model='',$property='',$class='',$instance='');
	public function setAc($acObj = null);
	public function getAc();
	public function checkAc();
}
?>
