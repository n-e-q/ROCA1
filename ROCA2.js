/**
 * 
 */
var hasStarted = false;
var itimer;
var myInterval;
var date;

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
	document.getElementById("end_button").style.display="none";
	
	inputs = document.getElementsByClassName("quadrant_inputs");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].style.display = "none";
	}
	
	inputs = document.getElementsByTagName("FORM");
	for (var i = 0; i < inputs.length; i++) {
	    inputs[i].reset();
	}
	
	document.getElementById("interval_timer").innerHTML = "0:00 time until next reading";
	
	
}

/* Enable all inputs when observation starts*/
function start() {
	hasStarted = true;
	itimer = 120;
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
	document.getElementById("end_button").style.display="block";
	
	myInterval = setInterval(runIntervalTimer, 1000);
	
	date = new Date();
	var timeStamp = document.createTextNode("[" + twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes()) + ":" + twoDigits(date.getSeconds()) + "] ");
	var msg = document.createTextNode("OBSERVATION HAS STARTED");
	var br = document.createElement("br");
	document.getElementById("feedback_container").appendChild(timeStamp);
	document.getElementById("feedback_container").appendChild(msg);
	document.getElementById("feedback_container").appendChild(br);
}

function runIntervalTimer() {
	if(hasStarted){
		var min = Math.floor(itimer / 60);
		var sec = twoDigits(itimer % 60);
		document.getElementById("interval_timer").innerHTML = min + ":" + sec + " time until next reading";
		if(itimer == 0){
			/* Submit interval readings every time timer reaches 0*/
			intervalSubmit();
			itimer = 120;
		}
		else {
			itimer = itimer -1;
		}
	}
}

/* End observation by resetting all values*/
function end() {
	hasStarted = false;
	setAllDefaultValues();
	
	var myNode = document.getElementById("feedback_container");
	while (myNode.firstChild) {
	    myNode.removeChild(myNode.firstChild);
	}
	
	itimer = 120;
	clearInterval(myInterval);
	
}

/* If option in "Instructor Events" has sub-options, show sub-menu*/
function showSubSelectMenu() {
	
	document.getElementById("sub_menu").style.display = "block";
	
}

/* Submit activities/events forms */
function aeSubmit(x) {
	
	if(x.value != "AT") {
		// Submit form
		x.form.submit();
		// Print to feedback
		printValue(x);
		// Reset form
		x.form.reset();
		
		if(x.id == "sub_menu"){
			document.getElementById("sub_menu").style.display = "none";
		}
	}
	else {
		showSubSelectMenu();
	}
	
}

// Submit interval readings form every two minutes
function intervalSubmit() {
	var intForm = document.getElementById("interval_readings_form");
	intForm.submit();
	printValue("interval_readings_form");
	intForm.reset();
}

/* Show inputs for classroom mapping when hover over areas*/
function showEventInputs(x) {
	if(hasStarted){
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

/* Hide inputs for classroom mapping when area is not hovered over*/
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

/* Print inputed value into feedback container with timestamp AND reset forms*/
function printValue(x) {
		var theDiv = document.getElementById("feedback_container");
		
		/* Creates time stamp */
		date = new Date();
		var timeStamp = document.createTextNode("[" + twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes()) + ":" + twoDigits(date.getSeconds()) + "] ");
		/* Get line break */
		var br = document.createElement("br");
		
		if(x=="interval_readings_form"){
			theDiv.appendChild(timeStamp);
			theDiv.appendChild(document.createTextNode("Interval Readings submitted"));
			theDiv.appendChild(br);
		}
		else {
			/* Get actual value of input */
			var content = document.createTextNode(x.form.id.slice(0, -5) + ": " + x.value);
			
			
			/* Append the above on the div */
			if(x.id =="sub_menu"){
				theDiv.appendChild(timeStamp);
				theDiv.appendChild(document.createTextNode(x.form.id.slice(0, -5) + ": AT, " + x.value));
				theDiv.appendChild(br);
				x.form.reset();
					
			}
			else {
				theDiv.appendChild(timeStamp);
				theDiv.appendChild(content);
				theDiv.appendChild(br);
			}
		}
		
		updateScroll();
}

function twoDigits(x) {
	return ("0" + x).slice(-2);
}

function updateScroll(){
    var element = document.getElementById("feedback_container");
    element.scrollTop = element.scrollHeight;
}