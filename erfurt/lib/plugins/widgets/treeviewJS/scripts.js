/**
 * Collection of crucial Javascript scripts
 * 
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: scripts.js 497 2004-11-23 16:25:33Z soerenauer $
 **/

function treeviewJS() {}

treeviewJS.imgbase=powl.uribase+'images/tree/';
var n=new Array();

treeviewJS.printNode=function(node,prefix,c) {
	var c=c?c:'';
	var childs=this.enableNodeAttributes?n[node][0]:n[node];
	if(!childs || childs.length<1) return;
	var ret='';
	var dn;
	var imgbase=this.imgbase;
	if(node!='/' && this.autoLoadLevels!=0) {
		todo=false;
		if(this.autoLoadLevels>2)
			for(i=0;i<childs.length;i++)
				if(n[childs[i]] && n[childs[i]].length) todo=true;
		if(this.autoLoadLevels<=2 || todo) {
			asrc=document.createElement('script');
			asrc.setAttribute('type','text/javascript');
			asrc.setAttribute('src',this.getNodesScript+node);
			document.getElementById('/').appendChild(asrc);
		}
	}
	var toDisplay=new Array();
	for(var i=0;i<childs.length;i++) {
		dn=childs[i];
		var j='';
		if(document.getElementById(dn))
			while(document.getElementById(dn+(++j)));
		//ret='';
		dnchilds=this.enableNodeAttributes?(n[dn]?n[dn][0]:false):n[dn];
		newprefix=prefix+'<img src='+imgbase+(i+1<childs.length?'line':'space')+'.gif align=top>';
		ret+='<div>'+prefix+'<img id="img'+dn+j+'" onclick="if(document.getElementById(\''+dn+j+'\').innerHTML==\'\') \
			treeviewJS.printNode(\''+dn+'\',\''+newprefix+'\',\''+j+'\'); treeviewJS.toggleVisibility(\''+dn+j+'\')" \
			src="'+imgbase+(i+1==childs.length?'corner':'tee')+(dnchilds&&dnchilds.length>0?'plus':'')+'.gif" align=top>'+
			this.renderNode(childs[i])+'</div>';
		ret+='<div id="'+dn+j+'" style="display:inline"></div>';
		if(powl.getState('treeview',dn+j))
			toDisplay.push([dn,dn+j,newprefix]);
	}
	document.getElementById(node+c).innerHTML=ret;
	for(var i=0;i<toDisplay.length;i++) {
		this.printNode(toDisplay[i][0],toDisplay[i][2]);
		treeviewJS.toggleVisibility(toDisplay[i][1]);
	}

}
treeviewJS.renderNode=function(node) {
	return '&nbsp;'+this.renderLink(node)+(n[node]&&n[node][2]?'&nbsp;&equiv;&nbsp;'+this.renderLink(n[node][2]):'')+
			(n[node]&&n[node][1]>0?' (<a href="'+powl.uribase+'modules/instances/instances.php?uri='+encodeURIComponent(node)+'" target="details">'+n[node][1]+'</a>)':'');
}
treeviewJS.renderLink=function(label) {
	var i;
	if(document.getElementById(label))
		while(document.getElementById(label+(++i)));
	return '<a id="tree'+label+i+'" onclick="treeviewJS.select(\''+label+i+'\'); parent.frames[\''+(this.target?this.target:'details')+'\'].location.href=treeviewJS.baseURL+\''+encodeURIComponent(label)+'\'; return false;" href="'+this.baseURL+encodeURIComponent(label)+'" target="'+(this.target?this.target:'details')+'">'+(n[label]&&n[label][3]?n[label][3]:label)+'</a>';
}
treeviewJS.plus=function(id) {
	c=this.enableNodeAttributes?n[id][0]:n[id];
	for(i=0;i<c.length;i++) {
		childs=this.enableNodeAttributes?(n[c[i]]&&n[c[i]][0]?n[c[i]][0]:false):n[c[i]];
		if(childs && childs.length>0) {
			if(!document.images['img'+c[i]].src.match('(plus|minus).gif'))
				document.images['img'+c[i]].src=document.images['img'+c[i]].src.replace('.gif','plus.gif');
		}
	}
}
treeviewJS.select=function(id) {
	powl.setStyleClass(document.getElementById('tree'+this.selected),'');

	this.selected=id;
	powl.setState('treeview','selected',id);
	powl.setStyleClass('tree'+id,'selected');
}
treeviewJS.toggleVisibility=function(id) {
	if(document.getElementById(id).style.display=='inline' || document.getElementById(id).style.display=='none' || document.getElementById(id).style.display=='') {
		document.images['img'+id].src=document.images['img'+id].src.replace('plus','minus');
		document.getElementById(id).style.display='block';
		powl.setState('treeview',id,true);
	} else {
		document.images['img'+id].src=document.images['img'+id].src.replace('minus','plus');
		document.getElementById(id).style.display='none';
		powl.delState('treeview',id);
	}
}
