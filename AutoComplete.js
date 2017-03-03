function twoNumbersFormat(date) {
	if (date < 10) {date = "0" + date;}
	return date;
}

function fillingInTheDateField(idElement){
	var date = new Date();
	document.getElementById(idElement).value = 
		twoNumbersFormat(date.getFullYear()) + "-"
		+ twoNumbersFormat(date.getMonth()+1) + "-"
		+ twoNumbersFormat(date.getDate());
}

function fillingInTheTextField(idElement, message){
	document.getElementById(idElement).value = message;
}