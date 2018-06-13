/**
 * 
 */
var hasStarted = false;
var paused = false;

/* Set default values of elements when app first loads*/
function setAllDefaultValues() {
	document.getElementById("sub_menu").style.display = "none";
	var inputs = document.getElementsByTagName("INPUT");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].disabled = true;
	}
	inputs = document.getElementsByClassName("input_button");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].disabled = true;
	}
	document.getElementById("student_activities_select").disabled = true;
	document.getElementById("instructor_activities_select").disabled = true;
	
	document.getElementById("start_button").style.display="block";
	document.getElementById("pause_button").style.display="none";
	document.getElementById("end_button").style.display="none";
	
	inputs = document.getElementsByClassName("quadrant_inputs");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].style.display = "none";
	}
	
	inputs = document.getElementsByTagName("FORM");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].reset();
	}
	
	
}

/* Enable all inputs when observation starts*/
function start() {
	hasStarted = true;
	var inputs = document.getElementsByTagName("INPUT");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].disabled = false;
	}
	inputs = document.getElementsByClassName("input_button");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].disabled = false;
	}
	document.getElementById("student_activities_select").disabled = false;
	document.getElementById("instructor_activities_select").disabled = false;
	
	document.getElementById("start_button").style.display="none";
	document.getElementById("pause_button").style.display="block";
	document.getElementById("pause_button").innerHTML = "Pause Observation";
	document.getElementById("end_button").style.display="block";
}

function pauseOrUnPause() {
	if(!paused){
		document.getElementById("sub_menu").style.display = "none";
		var inputs = document.getElementsByTagName("INPUT");
		for (var i = 0; i < inputs.length; i++) {
		    inputs[i].disabled = true;
		}
		inputs = document.getElementsByClassName("input_button");
		for (var i = 0; i < inputs.length; i++) {
		    inputs[i].disabled = true;
		}
		document.getElementById("student_activities_select").disabled = true;
		document.getElementById("instructor_activities_select").disabled = true;
		
		inputs = document.getElementsByClassName("quadrant_inputs");
		for (var i = 0; i < inputs.length; i++) {
		    inputs[i].style.display = "none";
		}
		document.getElementById("pause_button").innerHTML = "Unpause Observation";
		paused = true;
		alert("The observation has been PAUSED.");
	}
	else {
		var inputs = document.getElementsByTagName("INPUT");
		for (var i = 0; i < inputs.length; i++) {
		    inputs[i].disabled = false;
		}
		inputs = document.getElementsByClassName("input_button");
		for (var i = 0; i < inputs.length; i++) {
		    inputs[i].disabled = false;
		}
		document.getElementById("student_activities_select").disabled = false;
		document.getElementById("instructor_activities_select").disabled = false;
		document.getElementById("pause_button").innerHTML = "Pause Observation";
		paused = false;
		alert("The observation has been UNPAUSED.");
	}
	
}

function end() {
	hasStarted = false;
	setAllDefaultValues();
}


function showSubSelectMenu() {
	if(document.getElementById("instructor_activities_select").value=="AT"){
		document.getElementById("sub_menu").style.display = "block"
	}
	else{
		document.getElementById("sub_menu").style.display = "none";
		document.getElementById("instructor_activities_form").submit();
		document.getElementById("instructor_activities_form").reset();
	}
	
}

function testSubmit(x) {
	x.form.submit();
	x.form.reset();
	if(x.id=="sub_menu"){
		document.getElementById("sub_menu").style.display = "none";
	}
}

function showEventInputs(x) {
	if(hasStarted && !paused){
		if(x.id=="q1"){
			document.getElementById("q1_inputs").style.display = "grid";
		}
		if(x.id=="q2"){
			document.getElementById("q2_inputs").style.display = "grid";
		}
		if(x.id=="q3"){
			document.getElementById("q3_inputs").style.display = "grid";
		}
		if(x.id=="q4"){
			document.getElementById("q4_inputs").style.display = "grid";
		}
		if(x.id=="q5"){
			document.getElementById("q5_inputs").style.display = "grid";
		}
		if(x.id=="q6"){
			document.getElementById("q6_inputs").style.display = "grid";
		}
	}
}

function hideEventInputs(x) {
	if(x.id=="q1"){
		document.getElementById("q1_inputs").style.display = "none";
	}
	if(x.id=="q2"){
		document.getElementById("q2_inputs").style.display = "none";
	}
	if(x.id=="q3"){
		document.getElementById("q3_inputs").style.display = "none";
	}
	if(x.id=="q4"){
		document.getElementById("q4_inputs").style.display = "none";
	}
	if(x.id=="q5"){
		document.getElementById("q5_inputs").style.display = "none";
	}
	if(x.id=="q6"){
		document.getElementById("q6_inputs").style.display = "none";
	}
}