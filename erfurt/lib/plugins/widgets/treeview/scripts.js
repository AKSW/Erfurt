/**
 * Collection of crucial Javascript scripts
 * 
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: scripts.js 150 2004-03-23 18:56:50Z soerenauer $
 **/

function treeview() {
}

treeview.toggleVisibility=function(id) {
	if(document.getElementById(id).style.display=='none' || document.getElementById(id).style.display=='') {
		document.images['img'+id].src=document.images['img'+id].src.replace('plus','minus');
		document.getElementById(id).style.display='block';
		powl.setState('treeview',id,true);
	} else {
		document.images['img'+id].src=document.images['img'+id].src.replace('minus','plus');
		document.getElementById(id).style.display='none';
		powl.delState('treeview',id);
	}
}

treeview.select=function(id) {
	this.selected=id;
	powl.setState('treeview','selected',id);
	tags=document.getElementsByTagName('a');
	for(i=0;i<tags.length;i++)
		tags[i].setAttribute('class','');
	if(document.getElementById('tree'+id))
		document.getElementById('tree'+id).setAttribute('class','selected');
}
function treeviewselect() {
	if(!document.getElementById('tree'+powl.getState('treeview','selected')))
		return;
	treeview.select(powl.getState('treeview','selected'));
	target=document.getElementById('tree'+powl.getState('treeview','selected')).getAttribute('target');
	if(target)
		parent.frames[target].location.href=
			document.getElementById('tree'+powl.getState('treeview','selected')).getAttribute('href');
}
window.onload=treeviewselect;
