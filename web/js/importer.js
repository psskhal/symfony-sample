function doSelectProvider(provider)
{
	$$('#providers li.selected').each(function (o) { o.className = ""});
	$('provider_'+provider).className = "selected";
	$('invite_provider').value = provider;
	
	return false;
}
