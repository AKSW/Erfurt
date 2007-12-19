<?php
/**
 * class providing OntoWiki custom view abstract.
 *
 * @package ac
 * @author Stefan Berger <berger@intersolut.de>
 * @version $Id$
 */
abstract class Erfurt_Ac_Statements_Views_Abstract {
	
/**
	 * get the coded name for the group view 
	 */
	public function getGroupViewName($uri, $type = 'view') {
		return 'group_'.(($type == 'view') ? 'view_' : 'edit_') . md5($uri);
	}
	
	/**
	 * get the coded name for the agent view 
	 */
	public function getUserViewName($uri, $type = 'view') {
		return 'user_'.(($type == 'view') ? 'view_' : 'edit_') . md5($uri);
	}
}