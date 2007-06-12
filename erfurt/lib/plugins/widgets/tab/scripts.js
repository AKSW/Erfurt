/**
 * Collection of crucial Javascript scripts
 * 
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: scripts.js 455 2004-08-31 16:34:08Z soerenauer $
 **/

function tab() {

	this.select=function(tab) {
		// get tab name
		name=document.getElementById('tab'+tab).parentNode.getAttribute('id');
		tabs=powl.getElementsByName(name);

		// unhighlight currently highlighted tab
		for(i=0;i<tabs.length;i++) {
			powl.setStyleClass(tabs[i],'');
			t=document.getElementById(tabs[i].getAttribute('id').replace('tab',''));
			if(t) powl.setVisibility(t,'none');
		}
		// highlight selected tab
		powl.setStyleClass('tab'+tab,'selected');
		
		powl.setVisibility(tab,'block');
		powl.setState(name,'selected',tab);
		if(this.onclick) eval(this.onclick);
	}
	
	this.click=function(tab) {
		this.select(tab);
		if(this.urlbase)
			document.location.href=this.urlbase+tab;
	}
	
	this.stateSelect=function(tab) {
		var name=document.getElementById('tab'+tab).getAttribute('name');
		this.select(powl.getState(name,'selected')&&document.getElementById('tab'+tab)?powl.getState(name,'selected'):tab);
	}

}