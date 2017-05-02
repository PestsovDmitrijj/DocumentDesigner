function rememberName( obj ) {
	obj.restore_name.value = obj.filename.value;
}

function addInput( obj ) {
	var buffer = obj.restore_page.value;
	obj.restore_page.value = buffer + 
		obj.inputname.value + "|" + obj.type.value + "~";
	alert( obj.restore_page.value );
}