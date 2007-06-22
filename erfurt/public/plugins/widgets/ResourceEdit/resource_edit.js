function getAutomcompleter(id) {
	var url = '';
	new Ajax.Autocompleter('value-' + id, 'autocomplete-choices-' + id, url);
}