/**
 * Collection of crucial Javascript scripts
 *
 * @package POWL
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: scripts.js 587 2006-10-23 16:05:48Z nheino $
 **/

function powl() {
	this.agent = navigator.userAgent.toLowerCase();
	this.isIE = ((this.agent.indexOf("msie") != -1) && (this.agent.indexOf("opera") == -1));
}

powl.addEvent=function(el, evname, func) {
	if(this.isIE) {
		el.attachEvent("on" + evname, func);
	} else {
		el.addEventListener(evname, func, true);
	}
}

powl.removeEvent=function(el, evname, func) {
	if(this.isIE) {
		el.detachEvent("on" + evname, func);
	} else {
		el.removeEventListener(evname, func, true);
	}
}

powl.winopen=function(url,name,options) {
	if(options!='') options+=',';
	options+='resizable=yes,scrollbars=yes';
	if(name=='') name='New window';
	open(url,name,options);
	return;
}

powl.toggleChecked=function(form,match) {
	for(i=0;i<form.length;i++)
		if(form.elements[i].name.match(match))
			form.elements[i].checked=form.elements[i].checked?false:true;
}
powl.setStyleClass=function(elem,className) {
	if(typeof elem=='string')
		elem=document.getElementById(elem);
	if(!elem) return;
	if(document.all)
		elem.className=className;
	else
		elem.setAttribute('class',className);
}
powl.getElementsByName=function(name,tag) {
	var d=new Array();
	if(document.all) {
		elems=tag?document.getElementsByTagName(tag):document.all;
		for(i=0;i<elems.length;i++)
			if(elems[i].getAttribute('name')==name)
				d[d.length]=elems[i];
		return d;
	} else
		return document.getElementsByName(name);
}
powl.formOptions=function(elem,prefix) {
	var elements;
	if(!prefix && (typeof elem=='string' || elem.name)) {
		powl.formOptions(elem,typeof elem=='string'?elem:elem.name)
		var prefix='';
	}
	if(elem.options)
		elements=elem.options;
	else if(typeof elem=='string' && document.getElementsByName(elem)) {
		elements=document.getElementsByName(elem);
		if(elements[0] && elements[0].options)
			elements=elements[0].options;
	}
	else
		elements=document.getElementsByName(elem.name);
	var done=false;
	if(elements) for(var i=0;i<elements.length;i++) {
		if(elements[i].value && document.getElementById(prefix+elements[i].value)!=null) {
			if(elements[i].checked || elements[i].selected) {
				done=true;
				this.setVisibility(prefix+elements[i].value,'block');
			} else
				this.setVisibility(prefix+elements[i].value,'none');
		}
		else if(elements[i].value && document.getElementsByName(prefix+elements[i].value).length>0) {
			for(section in document.getElementsByName(prefix+elements[i].value)) {
				if(elements[i].checked || elements[i].selected) {
					done=true;
					this.setVisibility(section,'block');
				} else
					this.setVisibility(section,'none');
			}
		}
	}
	ele=typeof elem=='string'?elem:elem.name;
	if(done)
		this.setVisibility(ele+'Default','none');
	else
		this.setVisibility(ele+'Default','block');
}
powl.toggleVisibility=function(id) {
	if(typeof id=='string')
		id=document.getElementById(id);
	if(!id)
		return;
	if(id.style.display!='')
		id.style.display='';
	else id.style.display='none';
	return id.style.display;
}
powl.setStyle=function(id,style,value) {
	id=(typeof id=='string'?document.getElementById(id):id);
	if(!id) return;
	if(id.style)
		id.style[style]=value;
	else
		id.setAttribute('style',style+':'+block);
}
powl.setVisibility=function(id,block) {
	id=(typeof id=='string'?document.getElementById(id):id);
	if(!id) return;
	if(id.style)
		id.style.display=block;
	else
		id.setAttribute('style','display:'+block);
}
powl.remove=function(node) {
	if(node.parentNode)
		d=node;
	else
		d=document.getElementById(node);
	if(!d)
		d=document.getElementsByName(node)[0];
	d.parentNode.removeChild(d);
}
powl.duplicate=function(obj) {
	d=document.getElementById(obj);
	if(!d) {
		d=document.getElementsByName(obj)[document.getElementsByName(obj).length-1];
		if((typeof d)=='undefined') {
			spans=document.all;
			for(i=0;i<spans.length;i++)
				if(spans[i].getAttribute('name')==obj)
					d=spans[i];
		}
	}
	if(d.outerHTML)
		d.parentNode.appendChild(d.cloneNode(true));//d.parentNode.innerHTML+d.outerHTML;
	else
		d.insertAdjacentElement('afterEnd',d.cloneNode(true));
}
powl.strReplace=function(string,from,to) {
	var i;
//alert(from+' '+to);
	if(from!=to)
	while(i=string.lastIndexOf(from)) {
		if(i==-1)
			break;
		string=string.substr(0,i)+to+string.substr(i+from.length,string.length-i-from.length);
//alert(string.substr(0,i));
//alert(string.substr(i+from.length,string.length-i-from.length));
//break;
	}
//alert(string);
	return string;
}
//alert(powl.strReplace('testxxotestxxohalloxxohall123','xxo','fff'));
powl.setCookie=function(name, value, expire) {
	var duration = 700;
	var today = new Date()
	var defaultExpire = new Date()
	defaultExpire.setTime(today.getTime() + 1000*60*60*24*duration)
	var currentCookie = name + "=" +
		escape(value) +
		((expire == null) ?
			("; expires=" + defaultExpire.toGMTString()) :
			("; expires=" + expire.toGMTString()));
	document.cookie = currentCookie;
}
powl.getCookie=function(name) {
	var prefix = name + "="
	var cookieStartIndex = document.cookie.indexOf(prefix)
	if (cookieStartIndex == -1)
		return null
	var cookieEndIndex = document.cookie.indexOf(";", cookieStartIndex + prefix.length)
	if (cookieEndIndex == -1)
		cookieEndIndex = document.cookie.length
	return unescape(document.cookie.substring(cookieStartIndex + prefix.length, cookieEndIndex))
}

powl.stateframe=((opener && opener.frames['top'])?opener.frames['top']:window.frames['top']);

// if(window==powl.stateframe)
//	powl.stateframe.states=powl.getCookie('pwlstates')?eval(powl.getCookie('pwlstates')):new Array();

powl.setState=function(dom,prop,val) {
	if(!this.stateframe)
		return;
	if((typeof this.stateframe.states)=='undefined')
		this.stateframe.states=new Array();
	if((typeof this.stateframe.states[dom])=='undefined')
		this.stateframe.states[dom]=new Array();
	this.stateframe.states[dom][prop]=val;
//	if(window==powl.stateframe)
//		powl.setCookie('pwlstates',powl.stateframe.states.toSource());
}
powl.delState=function(dom,prop) {
	delete this.stateframe.states[dom][prop];
}
powl.getState=function(dom,prop) {
	if(this.stateframe)
	if((typeof this.stateframe.states)!='undefined')
	if((typeof this.stateframe.states[dom])!='undefined') {
		return this.stateframe.states[dom][prop];
	}
}
powl.optional=function(id,prop) {
	if(this.getState('optional',id+prop)=='none') {
		this.setVisibility(id,'none');
		if(img=document.getElementById('optionalIMG'+id+prop))
			img.src=img.src.replace('minus','plus');
	}
}
powl.optionalToggle=function(id,prop) {
	if(img=document.getElementById('optionalIMG'+id+prop))
		powl.togglePlusMinus(img);
	this.setState('optional',id+prop,powl.toggleVisibility(id))
}
powl.togglePlusMinus=function(img) {
	img.src=img.src.replace('minus','plus')==img.src?img.src.replace('plus','minus'):img.src.replace('minus','plus');
}
var but,w=0;
powl.wait=function(button) {
	if(button) {
		but=button;
		but.setAttribute('disabled','disabled');
		but.form.submit();
	}
	but.value=' Please wait! ('+(++w)+') ';
	setTimeout('powl.wait()',1000);
	return true;
}
powl.resetFormInside=function(id) {
        var childs=((typeof id)=='string')?document.getElementById(id).childNodes:id.childNodes;
        for(var i=0;i<childs.length;i++) {
                if(childs[i].checked)
                        childs[i].checked=false;
                else if(childs[i].value)
                        childs[i].value='';
                powl.resetFormInside(childs[i]);
        }
}
powl.getChild=function(node,childNodeName) {
	for(var i=0;i<node.childNodes.length;i++) {
		if(node.childNodes[i].nodeName.toLowerCase()==childNodeName.toLowerCase())
			return node.childNodes[i];
	}
	return false;
}
powl.getAncestor=function(node,ancestorNodeName,level) {
	var i=0;
	if(!level)
		var level=1;
	var parent=node;
	while(parent=parent.parentNode) {
		if(parent.nodeName.toLowerCase()==ancestorNodeName.toLowerCase() && ++i==level)
			return parent;
	}
	return false;
}
// implement some ie specific methods (insertAdjacentElement, insertAdjacentHTML,
// insertAdjacentText) for mozilla
if(typeof HTMLElement!="undefined" && ! HTMLElement.prototype.insertAdjacentElement) {
	HTMLElement.prototype.insertAdjacentElement = function (where,parsedNode) {
		switch (where) {
			case 'beforeBegin':
				this.parentNode.insertBefore(parsedNode,this)
				break;
			case 'afterBegin':
				this.insertBefore(parsedNode,this.firstChild);
				break;
			case 'beforeEnd':
				this.appendChild(parsedNode);
				break;
			case 'afterEnd':
				if (this.nextSibling) this.parentNode.insertBefore(parsedNode,this.nextSibling);
				else this.parentNode.appendChild(parsedNode);
				break;
		}
	}
	HTMLElement.prototype.insertAdjacentHTML = function (where,htmlStr) {
		var r = this.ownerDocument.createRange();
		r.setStartBefore(this);
		var parsedHTML = r.createContextualFragment(htmlStr);
		this.insertAdjacentElement(where,parsedHTML)
	}
	HTMLElement.prototype.insertAdjacentText = function (where,txtStr) {
		var parsedText = document.createTextNode(txtStr)
		this.insertAdjacentElement(where,parsedText)
	}
/*	HTMLElement.prototype.outerHTML setter  = function(html) {
		var range = this.ownerDocument.createRange();
		range.setStartBefore(this);
		var fragment = range.createContextualFragment(html);
		this.parentNode.replaceChild(fragment, this);
		return html;
	}
	HTMLElement.prototype.outerHTML getter  = function() {
		return HTMLElement_GetOuterHTML(this);
	}*/
	function HTMLElement_GetOuterHTML(node) {
		var output = "";
		var empties = ["IMG", "HR", "BR", "INPUT"];
		switch(node.nodeType) {
			case Node.ELEMENT_NODE:
				output += "<" + node.nodeName;
				//  get the element's attributes...
				for(var i = 0; i < node.attributes.length; i++) {
					if(node.attributes.item(i).nodeValue != null) {
					output += " ";
					output += node.attributes.item(i).nodeName + "=\"";
					output += node.attributes.item(i).nodeValue + "\"";
					}
				}

				if(node.childNodes.length == 0 && empties.getIndexOf(node.nodeName) > 0)
					output += ">";
				else {
					output += ">";
					output += node.innerHTML;
					output += "</" + node.nodeName + ">"
				}
				break;
			case Node.TEXT_NODE:
				output += node.nodeValue;
				break;
			case Node.CDATA_SECTION_NODE:
				output += "<![CDATA[" + node.nodeValue + "]]>";
				break;
			case Node.ENTITY_REFERENCE_NODE:
				output += "&" + node.nodeName + ";"
				break;
			case Node.COMMENT_NODE:
				output += "<!"+ "--" + node.nodeValue + "-->"
				break;
		}

		return output;
	}
	Array.prototype.getIndexOf  = function() {
		var index = -1;
		if(arguments.length > 0)
		for(var i = 0; i < this.length; i++)
			if(this[i] == arguments[0]) {
				index = i;
				break;
			}
		return index;
    }
}
powl.getOuterHTML=function(node) {
	if(typeof node.outerHTML!="undefined")
		return node.outerHTML;
	else
		return HTMLElement_GetOuterHTML(node);
}
// Body onload utility (supports multiple onload functions)
powl.gSafeOnload = new Array();
powl.SafeAddOnload=function(f) {
	isMac = (navigator.appVersion.indexOf("Mac")!=-1) ? true : false;
	NS4 = (document.layers) ? true : false;
	IEmac = ((document.all)&&(isMac)) ? true : false;
	IE4plus = (document.all) ? true : false;
	IE4 = ((document.all)&&(navigator.appVersion.indexOf("MSIE 4.")!=-1)) ? true : false;
	IE5 = ((document.all)&&(navigator.appVersion.indexOf("MSIE 5.")!=-1)) ? true : false;
	ver4 = (NS4 || IE4plus) ? true : false;
	NS6 = (!document.layers) && (navigator.userAgent.indexOf('Netscape')!=-1)?true:false;

	if (IEmac && IE4) { // IE 4.5 blows out on testing window.onload
		window.onload = powl.SafeOnload;
		powl.gSafeOnload[gSafeOnload.length] = f;
	} else if  (window.onload) {
		if (window.onload != powl.SafeOnload) {
			powl.gSafeOnload[0] = window.onload;
			window.onload = powl.SafeOnload;
		}
		powl.gSafeOnload[powl.gSafeOnload.length] = f;
	} else
		window.onload = f;
}
powl.SafeOnload=function() {
	for (var i=0;i<powl.gSafeOnload.length;i++)
		powl.gSafeOnload[i]();
}
powl.reloadGET=function() {
	for(var i=0; i<arguments.length; i++) {
		oldURL=arguments[i].location.href;
		newURL=oldURL.indexOf('#')!=-1?oldURL.substr(0,oldURL.indexOf('#')):oldURL;
		arguments[i].location.href=newURL+'?test=test';
	}
}
powl.loadScript=function(url) {
	url=powl.uribase+url;
	if (document.layers)
		window.location.href = url;
	else if (document.getElementById) {
		var script = document.createElement('script');
		script.defer = true;
		script.src = url;
		document.getElementsByTagName('head')[0].appendChild(script);
	}
}
if(opener && opener.screenX) {
	// resize window
	if(h=powl.getState('WindowSize'+window.name,'Height'))
		window.outerHeight=h;
	if(w=powl.getState('WindowSize'+window.name,'Width'))
		window.outerWidth=w;
	// center window
	var px1 = opener.screenX;
	var px2 = opener.screenX + opener.outerWidth;
	var py1 = opener.screenY;
	var py2 = opener.screenY + opener.outerHeight;
	var x = (px2 - px1 - window.outerWidth) / 2;
	var y = (py2 - py1 - window.outerHeight) / 2;
	window.moveTo(x, y);
	window.focus();
}
window.onresize=function() {
	if(window.outerHeight)
		powl.setState('WindowSize'+window.name,'Height',window.outerHeight);
	if(window.outerWidth)
		powl.setState('WindowSize'+window.name,'Width',window.outerWidth);
};

function getObj(id) {
	if(typeof id=='string') {
		if(document.getElementById(id))
			return document.getElementById(id);
		else
			return document.getElementsByName(id)[0];
	}
	return id;
}

/* vertically expands a text field */
function textVExpand(id) {
	id = getObj(id);
	if (id.type && id.type == 'text') {
		textarea = document.createElement('textarea');
		textarea.value = id.value;
		textarea.setAttribute('name', id.name);
		textarea.style.width = (id.offsetWidth) + 'px';
/*		textarea.style.display = 'block';*/
		id.parentNode.replaceChild(textarea, id);
	} else if(id.type == 'textarea')
		id.style.height = (id.offsetHeight + 50) + 'px';
	textSaveSize(id);
}

/* horizontally expands a text field */
function textHExpand(id) {
	id = getObj(id);
	/* get the surrounding table's surrounding table's <td> node size*/
	var maxWidth = id.parentNode.parentNode.parentNode.parentNode.parentNode.offsetWidth - 20;
	var newWidth = id.offsetWidth + 50;
	if (newWidth <= maxWidth) {
		id.style.width = newWidth + 'px';
	}
	textSaveSize(id);
}

/* vertically reduces a text field */
function textHReduce(id) {
	id = getObj(id);
	var newWidth = id.offsetWidth - 50;
	if (newWidth >= 50) {
		id.style.width = newWidth + 'px';
	}
	textSaveSize(id);
}

/* horizontally reduces a text field */
function textVReduce(id) {
	id = getObj(id);
	old = id.offsetHeight;
	if (id.type == 'textarea' && old < 60) {
		text = document.createElement('input');
		text.value = id.value;
		text.name = id.name;
		text.style.width = (id.offsetWidth)+'px';
		id.parentNode.replaceChild(text,id);
	} else
		id.style.height = (id.offsetHeight - 50) + 'px';
	textSaveSize(id);
}

function textSaveSize(id) {
	powl.setState('textedit' + id.type + id.name, 'width', id.offsetWidth);
	if (id.type == 'textarea')
		powl.setState('textedit' + id.type + id.name, 'height', id.offsetHeight);
}

function textResize(id) {
	id = getObj(id);
	if (width = powl.getState('textedit' + id.type + id.name, 'width')) {
		id.style.width = width + 'px';
		if (id.type == 'textarea')
			id.style.height = powl.getState('textedit' + id.type + id.name, 'height') + 'px';
	}
}
