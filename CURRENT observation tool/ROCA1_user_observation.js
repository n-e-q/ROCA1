/**
 * 
 */
var secondClick = false;

function setAllDefaultValues() {
	var inputs = document.getElementsByClassName("quadrant");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].style.display = "flex";
	}
	inputs = document.getElementsByClassName("quadrant_inputs");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].style.display = "none";
	}
	// Reset forms
	inputs = document.getElementsByTagName("FORM");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].reset();
	}
	// Disable checkboxes and other inputs other than the increment buttons
	inputs = document.getElementsByTagName("INPUT");
	for (var i = 0; i < inputs.length; i++) {
		if(inputs[i].className != "inS" && inputs[i].className != "inS_text")
			inputs[i].disabled = true;
	}
	
	inputs = document.getElementsByClassName("increment_stud");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].style.display = "grid";
	}
}

function start() {
	var inputs = document.getElementsByTagName("INPUT");
	for (var i = 0; i < inputs.length; i++) {
		if(inputs[i].className != "inS" && inputs[i].className != "inS_text")
			inputs[i].disabled = false;
	}
}

function end() {
	setAllDefaultValues();
}

/*function setAllDefaultValues() {
	var inputs = document.getElementsByClassName("quadrant");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].style.display = "flex";
	}
	inputs = document.getElementsByClassName("quadrant_inputs");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].style.display = "none";
	}
	
	inputs = document.getElementsByTagName("FORM");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].reset();
	}
	
	inputs = document.getElementsByClassName("increment_stud");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].style.display = "grid";
	}
}*/

function dataToFeed(event, obj) {
	var modal = document.getElementsByClassName("modal-body");
	var content = document.createTextNode(obj.textContent);
	var br = document.createElement("br");
	date = new Date();
	var timeStamp = document.createTextNode("[" + twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes()) + ":" + twoDigits(date.getSeconds()) + "] ");
	modal[0].appendChild(timeStamp);
	modal[0].appendChild(content);
	modal[0].appendChild(br);
	
	openFeed(event);
}


function openFeed(event) 
{
	// Get the modal
	var modal = document.getElementById('feed');
	// Get the button that opens the modal
	var btn = document.getElementById("feed_button");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	var displaySetting = modal.style.display;
	// When the user clicks the button, open the modal 
	//btn.onclick = function() {
		modal.style.display = "block";
	//}
	// When the user clicks on <span> (x), close the modal
	//span.onclick = function() {
		//modal.style.display = "none";
	//}

	// When the user clicks anywhere outside of the modal, close it
	/*if(displaySetting == "block"){
		window.onclick = function(event) {
		//if (event.target == modal) {
			modal.style.display = "none";
		//}
		}
	}
	else {
		modal.style.display = "block";
	}*/
	updateScroll();
	event.stopPropagation();
}

window.onclick = function(event) {
	//if (event.target == modal) {
		var modal = document.getElementById('feed');
		modal.style.display = "none";
	//}
}

function updateScroll(){
    var element = document.getElementsByClassName("modal-body");
    element[0].scrollTop = element[0].scrollHeight;
}

function twoDigits(x) {
	return ("0" + x).slice(-2);
}

