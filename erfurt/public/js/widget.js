function getEmptyHtml(trigger, id, container_id, widgetClass) {
	var countElement = $('count-' + id);
	var nameElement = $('name-' + id);
	var container = document.createElement('div');
	container.setAttribute('id', 'dyn-cont-' + id);
	$(container_id).appendChild(container);
	var uri = ow.erfurtpublicbase + 'get_widget.php?id=' + id + '&class=' + widgetClass + '&count=' + countElement.value + '&name=' + encodeURIComponent(nameElement.value);
	new Ajax.Updater(container, uri, {evalScripts: true});
	countElement.value = parseInt(countElement.value) + 1;
}