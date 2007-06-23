function toggleOptions(element, eventType) {
	if (eventType == 'mouseover') {
		// new Effect.Opacity(element, {duration: 0.25, from: 0, to: 1.0});
		element.setAttribute('style', 'opacity:1.0');
	} else if (eventType == 'mouseout') {
		// new Effect.Opacity(element, {duration: 0.25, from: 1.0, to: 0});
		element.setAttribute('style', 'opacity:0');
	}
}
