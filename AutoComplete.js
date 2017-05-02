function twoNumbersFormat (date) {
	if (date < 10) {date = "0" + date;}
	return date;
}

function setValueDateField (idElement) {
	var date = new Date();
	document.getElementById(idElement).value = 
		twoNumbersFormat(date.getFullYear()) + "-"
		+ twoNumbersFormat(date.getMonth()+1) + "-"
		+ twoNumbersFormat(date.getDate());
}

function setValueTextField (idElement, message) {
	document.getElementById(idElement).value = message;
}

function setValueSelectorField (idElement) {
	alert( getElementById(idElement) );
}

function main () {
	setValueTextField('numChange', 'message');
	setValueDateField('dateCreate');
	alert("1");
	setValueSelectorField('specialty4');
	alert("2");
}