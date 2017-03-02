function twoNumbersFormat(date) {
	if (date < 10) {date = "0" + date;}
	return date;
}

function funTestComplete(){
	var date = new Date();
	alert("1");
	document.getElementById('dateCreate').value = 
		twoNumbersFormat(date.getFullYear()) + "-"
		+ twoNumbersFormat(date.getMonth()+1) + "-"
		+ twoNumbersFormat(date.getDate());

	
	//	obj.dateCreate.value = 11111111;
		// "twoNumbersFormat(date.getDate())" 
		// + "twoNumbersFormat(date.getMonth()+1)" 
		// + "twoNumbersFormat(date.getFullYear())";
	alert("2");
}

