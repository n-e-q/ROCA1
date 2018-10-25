/**
 * 
 */

function setAllDefaultValues() {
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
}