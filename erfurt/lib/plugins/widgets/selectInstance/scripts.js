/**
 * Collection of crucial Javascript scripts
 *
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: scripts.js 548 2006-02-18 17:50:02Z soerenauer $
 **/

function selectResource() {}

selectResource.select=function(name,checked,key,val) {
	formElem=top.opener.document.getElementById('__cxtreeview'+name);
	if(!formElem) {
		multi=top.opener.document.getElementById('dupl'+name);
		elems=top.opener.document.getElementsByName(name);
		for(j=0;j<elems.length;j++) {
				if(checked && (elems[j].value=='' || !multi)) {
					elems[j].value=key;
					if(!multi) top.close();
					return;
				}
				else if(!checked && (elems[j].value==key || !multi)) {
					if(elems.length>1)
						elems[j].parentNode.parentNode.removeChild(elems[j].parentNode);
					else
						elems[j].value='';
					if(!multi) top.close();
					return;
				}
		}
		top.opener.powl.duplicate('add'+name);
		top.opener.document.getElementsByName(name)[top.opener.document.getElementsByName(name).length-1].value='';
		this.select(name,checked,key,val);
	} else {
		if(checked) {
			formElem.value+=val+"\n";
			formElem.insertAdjacentHTML("afterEnd",'<input type="hidden" name="'+name+'" value="'+key+'" />');
		} else {
			tt=new RegExp("^"+val+"\r?\n","im");
			formElem.value=formElem.value.replace(tt,'');
			elems=top.opener.document.getElementsByName(name);
			for(i=0;i<elems.length;i++)
				if(elems[i].value==key)
					elems[i].parentNode.removeChild(elems[i]);
		}
	}
}

selectResource.initialSelect=function(name) {
	localElems=document.getElementsByName(name);
	elems=top.opener.document.getElementsByName(name);
	for(i=0;i<localElems.length;i++) {
		for(j=0;j<elems.length;j++) {
				if(elems[j].value==localElems[i].value)
					localElems[i].checked=true;
		}
	}
}

selectResource.liveSearch=function(input) {
//	powl.setVisibility(document.getElementById(input.name+'.liveSearchDiv'),'block');
	powl.setVisibility(input.parentNode.lastChild,'block');
	if(input.value.search(/http:\/\//)==-1 && this.liveSearchValue!=input.value && input.value.length>2) {
		this.liveSearchValue=input.value;
		powl.loadScript('plugins/widgets/selectInstance/live_search.php?q='+encodeURIComponent(input.value)+'&id='+encodeURIComponent(input.name+'.liveSearch'));
	}
	input.focus();
}
