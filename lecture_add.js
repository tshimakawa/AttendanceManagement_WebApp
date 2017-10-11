function start_time(object){//objectはselectタグ

	var index = object.selectedIndex;
	var value = object.options[index].value;
	var text = object.options[index].text;

	if(value == 1){
		document.getElementById("start_time").value = '08:50';
	}else if (value == 2) {
		document.getElementById("start_time").value = '10:35';
	}else if (value == 3) {
		document.getElementById("start_time").value = '13:00';
	}else if (value == 4) {
		document.getElementById("start_time").value = '14:45';
	}else if (value == 5) {
		document.getElementById("start_time").value = '16:30';
	}else if (value == 6) {
		document.getElementById("start_time").value = '18:15';
	}else {
		document.getElementById("start_time").value = '';
	}
}

function showAlert(message){
	alert(message);
}
