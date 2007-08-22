function getAutocompleter(id) {
	var modelHidden = $('model-' + id.substring(0, id.length - 1));
	if (modelHidden) {
		var url = erfurtPublicUri + 'plugins/widgets/ResourceEdit/search.php?modelUri=' + encodeURIComponent(modelHidden.value);
		new Ajax.Autocompleter('value-' + id, 'autocomplete-choices-' + id, url, {paramName: 'searchText', minChars: 3});
	}
}