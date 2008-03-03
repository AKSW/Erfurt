<?php
class ErfurtExamplePlugin extends Erfurt_Plugin {

	public function preAddAction(&$data) {
		
		// do some stuff before adding a statement
		
		// e.g.:
		// 1. check whether predicate is rdfs:label
		// 2a: false -> do nothing
		// 2b: true -> check whether object has a language
		// 3a: true -> do nothing
		// 3b: false -> add a standard language tag... e.g. 'de'
		
		$stm = $data['statement'];
		if ($stm->getPredicate()->getURI() === EF_RDFS_LABEL) {
			$obj = $stm->getObject();
			
			if ($obj->getLanguage() === null) {
				$obj->setLanguage('de');
			}
		}
		
		return;
	}
	
	public function postAddAction(&$data) {
		
		// do some stuff after adding a statement
		
		// e.g. log statement serialization and success status
		$stm = $data['statement'];
		$success = $data['success'];
		
		$logger = Zend_Registry::get('erfurtLog')->info('ErfurtExamplePlugin - Statement added (' . 
						date('d.m.Y H:i:s') . '): ' . $stm->toString() . 
						($success ? ' successfully added' : ' addition failed'));
	}
}
?>
