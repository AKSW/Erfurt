/**
 * Collection of crucial Javascript scripts
 * 
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: scripts.js 42 2004-02-29 16:48:15Z soerenauer $
 **/

function treeselect() {
}

treeselect.treeHide=function(ev) {
	var el = powl.isIE ? window.event.srcElement : ev.target;
	for (; el!=null && (!el.getAttribute || el.getAttribute('name')!='__cxtree'); el=el.parentNode);
	if (el == null) {
		trees=document.getElementsByName('__cxtree');
		for(var i=0;i<trees.length;i++)
			powl.setVisibility(trees[i],'none');
		powl.removeEvent(document,'mousedown',this.treeHide);
	}
}

treeselect.treeRecurse=function(tree,node,name,subselected,prefix,multi) {
	var i,ret="",childs,nodeid;
	var subtree=tree[node];
	if(node=='') node='__cxroot';
	if(!this.n) this.n=0;
	if(subtree) for(i=0;i<subtree.length;i++) if(subtree[i]) {
		nodeid=++this.n;
		if(tree[subtree[i][0]] && tree[subtree[i][0]].length)
			childs=(tree[subtree[i][0]].length>0?'<div id="childnodes'+name+nodeid+'" class="childnodes">'+
				this.treeRecurse(tree,subtree[i][0],name,subselected,prefix+'<img align="absbottom" src="'+pwlbase+'images/tree/'+(subtree[i+1]?'line':'space')+'.gif">',multi)+
				'</div>':'');
		else childs='';
		ret+='<div style="height:16" '+(subselected?' class="subselected"':'')+'>'+
				prefix+'<img align="absbottom" id="imgchildnodes'+name+nodeid+'" onclick="treeview.toggleVisibility(\'childnodes'+name+nodeid+'\')" src="'+pwlbase+'images/tree/'+(subtree[i+1]?'tee':'corner')+(childs?'plus':'')+'.gif">'+
				(multi?'<input onclick="if(this.checked) document.getElementById(\'__cxtreeview'+name+'\').value+=\''+subtree[i][1]+'\'+\'\\n\'; else document.getElementById(\'__cxtreeview'+name+'\').value=document.getElementById(\'__cxtreeview'+name+'\').value.replace(/^'+subtree[i][1]+'\\r?\\n/im,\'\');" style="height:16;padding:0;margin-left:1px;margin-right:3px;margin-bottom:1;margin-top:1;" type="checkbox" name="'+name+'[]" value="'+subtree[i][0]+'"'+(subtree[i][2]?' checked':'')+">"+subtree[i][1]:'&nbsp;<a href="#" onclick="document.getElementsByName(\''+name+'\')[0].value=\''+subtree[i][0]+'\'; powl.toggleVisibility(\'__'+name+'tree\')">'+subtree[i][1]+'</a>')+
			"</div>"+childs;
	}
	return ret;
}
