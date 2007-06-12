
treeviewJS.renderNode=function(node) 
{ 		
	//return '&nbsp;<a id="tree'+node+'" onclick="treeviewJS.select(\''+node+'\'); parent.details.location.href=\'cms.php?uri='+node+'&amp;addons='+n[node][1]+'\';" href="#">'+n[node][2]+'</a>';
	return '&nbsp;<a id="tree'+node+'" onclick="treeviewJS.select(\''+node+'\');" href="cms.php?uri='+node+'" target="details">'+n[node][2]+'</a>';
}

function newPage(modelBaseURI,p)
{

	/*
	pageType     = document.pageform.pageTypeURI.value;
	pageChildOf  = '';
	pagePosition = 0;		
	selectedNode = document.getElementById('tree'+treeviewJS.selected).href;
	tmpaddons    = selectedNode.split("addons=");	
	addons	     = tmpaddons[1].split(",");

	addons_pos   = addons[0].split('|');
	addons_par   = addons[1].split('|');
	// child of selected tree element
	if(p=='child') {
		
		pageChildOf  = modelBaseURI + addons_par[1];
		pagePosition = addons_pos[1];
	}
	// sibling of selected tree element
	else {

		pageChildOf  = modelBaseURI + addons_par[0];
		pagePosition = addons_pos[0];
	}
	*/
	selectedNode  		= document.getElementById('tree'+treeviewJS.selected).href;		
	selectedNode_arr	= selectedNode.split('=');
	node			= selectedNode_arr[1];
	
	parent.details.location.href="cms.php?pageRelationElement="+node;
}

function openWebsite(lang)
{
	if(document.getElementById('tree'+treeviewJS.selected))	
	{		
		selectedNode  		= document.getElementById('tree'+treeviewJS.selected).href;		
		selectedNode_arr	= selectedNode.split('=');
		node			= selectedNode_arr[1];
		path = node;
		parent.details.location.href='templates/index.php?language='+lang+'&module='+path;
	}
	else
	{
		parent.details.location.href='templates/index.php?language='+lang;
	}
}