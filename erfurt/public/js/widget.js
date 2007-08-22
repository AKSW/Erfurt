function getEmptyHtml(trigger, id, containerId, widgetClass) {
	var count    = $jq('#count-' + id).val();
	var name     = $jq('#name-' + id).val();
	var model    = $jq('#model-' + id).val();
	var property = $jq('#property-' + id).val();
	
	var container = document.createElement('div');
	container.setAttribute('id', 'dyn-cont-' + id);
	document.getElementById(containerId).appendChild(container);
	
	var uri = erfurtPublicUri + 'get_widget.php?id=' + id + 
		'&property=' + encodeURIComponent(property) + 
		'&count=' + count + 
		'&name=' + encodeURIComponent(name) + 
		'&class=' + encodeURIComponent(widgetClass);
		/* '&model=' + encodeURIComponent(model); */
	
	$jq(container).load(uri);
	//new Ajax.Updater(container, uri, {evalScripts: true});
	$jq('count-' + id).val(parseInt(count) + 1);
}
