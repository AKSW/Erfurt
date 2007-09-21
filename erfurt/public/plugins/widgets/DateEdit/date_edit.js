function loadDateEdit(id, value) {
	var dum  = new Epoch('value-' + id, 'popup', document.getElementById('value-' + id), false);
	
	if (value && value != 'undefined') {
		valueDate = new Date(value);
		dum.selectDates([valueDate], true, true, true);
		dum.goToMonth(valueDate.getFullYear(), valueDate.getMonth());
	}
	
	return dum;
}
