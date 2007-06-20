function toggleSubWidget(id, active, num) {
	var inactive = (active == 'resource') ? 'literal' : 'resource';
	var contInactive = $('container-' + inactive + id + num);
	var contActive = $('container-' + active + id + num);
	new Effect.Fade(contInactive, {duration: 0.25, queue: {position: 'end', scope: 'nodeEdit'}});
	new Effect.Appear(contActive, {duration: 0.25, queue: {position: 'end', scope: 'nodeEdit'}});
	
	var resourceInput = $('value-resource' + id + num);
	var literalInput = $('value-literal' + id + num);
	var literalLang = $('lang-literal' + id + num);
	var literalDtype = $('dtype-literal' + id + num);
	
	var prefix = '';
	
	if (active == 'resource') {
		prefix = literalInput.getAttribute('name').substr(0, 4);
		
		literalInput.setAttribute('name', 'porp' + literalInput.getAttribute('name').substr(4));
		literalLang.setAttribute('name', 'porp' + literalLang.getAttribute('name').substr(4));
		literalDtype.setAttribute('name', 'porp' + literalDtype.getAttribute('name').substr(4));
		
		resourceInput.setAttribute('name', prefix + resourceInput.getAttribute('name').substr(4));
		
	} else if (active == 'literal') {
		prefix = resourceInput.getAttribute('name').substr(0, 4);
		
		resourceInput.setAttribute('name', 'porp' + resourceInput.getAttribute('name').substr(4));
		
		literalInput.setAttribute('name', prefix + literalInput.getAttribute('name').substr(4));
		literalLang.setAttribute('name', prefix + literalLang.getAttribute('name').substr(4));
		literalDtype.setAttribute('name', prefix + literalDtype.getAttribute('name').substr(4));
	}
}
