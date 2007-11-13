<?php
/**
  * class providing OntoWiki custom view abstract.
  *
  * @author Stefan Berger <berger@intersolut.de>
  * @version $Id: $
  */
abstract class Erfurt_Ac_Statements_Views_Abstract {
	
	
	
	public function getGroupViewName($uri, $type = 'view') {
		return 'group_'.(($type == 'view') ? 'view_' : 'edit_') . md5($uri);
	}
	
	public function getUserViewName($uri, $type = 'view') {
		return 'user_'.(($type == 'view') ? 'view_' : 'edit_') . md5($uri);
	}
	
}