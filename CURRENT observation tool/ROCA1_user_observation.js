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

function openFeed() 
{
	// Get the modal
	var modal = document.getElementById('feed');

	// Get the button that opens the modal
	var btn = document.getElementById("feed_button");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal 
	btn.onclick = function() {
		modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
}