/*
  	Filename: ROCA1.js
  	Author: Annie Khuu
  	Email: ak6eh@virginia.edu
  	
  	Notes:
  		(1) Include map metadata (max # of seats) when available.
  		(2) Use jquery to call php when submitting data to database...
 */
var hasStarted = false;
var itimer;
var myInterval;
var date; 
var setInitStud = false;


/* Set default values of elements when application first loads*/
function setAllDefaultValues() {
	q1Submitted = q2Submitted = q3Submitted = q4Submitted = q5Submitted = q6Submitted = false;
	
	document.getElementById("sub_menu").style.display = "none";
	var inputs = document.getElementsByTagName("INPUT");
	for (var i = 0; i < inputs.length; i++) {
		if(inputs[i].className != "inS" && inputs[i].className != "inS_text")
			inputs[i].disabled = true;
	}
	inputs = document.getElementsByClassName("input_button");
	for (var i = 0; i < inputs.length; i++) {
		inputs[i].disabled = true;
	}
	document.getElementById("student_activities_select").disabled = true;
	document.getElementById("instructor_activities_select").disabled = true;
	
	document.getElementById("start_button").style.display="block";
	document.getElementById("reset_button").style.display="block";
	document.getElementById("end_button").style.display="none";
	
	inputs = document.getElementsByClassName("quadrant");
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
	
	document.getElementById("interval_timer").innerHTML = "0:00 time until next reading";

	
}

/* Enable all inputs when observation starts*/
function start() {
	
	/* Check to see if user has inputed initial num of students before starting observation */
	studCounts = document.getElementsByClassName("inS_text");
	setInitStud = true;
	for(var i = 0; i < studCounts.length; i++){
		if(studCounts[i].value == studCounts[i].defaultValue){
			setInitStud = false;
		}
	}
	
	if(setInitStud){
		hasStarted = true;
		itimer = 120;
		
		/* Enable all input buttons/elements */
		var inputs = document.getElementsByTagName("INPUT");
		for (var i = 0; i < inputs.length; i++) {
		    inputs[i].disabled = false;
		}
		inputs = document.getElementsByClassName("input_button");
		for (var i = 0; i < inputs.length; i++) {
		    inputs[i].disabled = false;
		}
		
		/* Enable the select menus */
		document.getElementById("student_activities_select").disabled = false;
		document.getElementById("instructor_activities_select").disabled = false;
		
		/* Hide start and reset buttons and show end button */
		document.getElementById("start_button").style.display="none";
		document.getElementById("reset_button").style.display="none";
		document.getElementById("end_button").style.display="block";
		
		/* Set up the interval readings timer */
		myInterval = setInterval(runIntervalTimer, 1000);
		
		/* Print out time of start */
		date = new Date();
		var timeStamp = document.createTextNode("[" + twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes()) + ":" + twoDigits(date.getSeconds()) + "] ");
		var msg = document.createTextNode("OBSERVATION HAS STARTED");
		var br = document.createElement("br");
		document.getElementById("feedback_container").appendChild(timeStamp);
		document.getElementById("feedback_container").appendChild(msg);
		document.getElementById("feedback_container").appendChild(br);
		
		/* Enable quadrants */
		inputs = document.getElementsByClassName("quadrant");
		for (var i = 0; i < inputs.length; i++) {
		    inputs[i].style.display = "flex";
		}
	}
	else {
		alert("Please set the initial number of students for each quadrant before starting.");
	}
}

/* Submit student events form every time # of students is changed */
function handle(e) {
	if(e.keyCode === 13){
        e.preventDefault(); // Ensure it is only this code that runs
        document.getElementById("student_events_form").submit();
    }
}

/* Increase # of students display and then submits the change */
function incStudent(x) {
	document.getElementById(x).value++;
	document.getElementById("student_events_form").submit();
}

/* Decrease # of students display and then submits the change */
function decStudent(x) {
	if(document.getElementById(x).value > 0){
		document.getElementById(x).value--;
	}
	document.getElementById("student_events_form").submit();
}

/* Runs the interval form timer */
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
	setInitStud = false;
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
	
		var numStudents = document.getElementsByClassName("inS_text");
		var inSValues = [];
		for(var i = 0; i < numStudents.length; i++){
			inSValues[i] = numStudents[i].value;
		}
	if(x.value != "AT") {
		// Submit form
		x.form.submit();
		// Print to feedback
		printValue(x);
		// Reset form
		x.form.reset();
		
		for(var i = 0; i < numStudents.length; i++){
			numStudents[i].value = inSValues[i];
		}
		
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
		
		if(x=="q1"){
			document.getElementById("q1_inputs").style.display = "grid";
			document.getElementById("inc_stud1").style.display = "grid";
			document.getElementById("q1_title").style.display = "none";
		}
		if(x=="q2"){
			document.getElementById("q2_inputs").style.display = "grid";
			document.getElementById("inc_stud2").style.display = "grid";
			document.getElementById("q2_title").style.display = "none";
		}
		if(x=="q3"){
			document.getElementById("q3_inputs").style.display = "grid";
			document.getElementById("inc_stud3").style.display = "grid";
			document.getElementById("q3_title").style.display = "none";
		}
		if(x=="q4"){
			document.getElementById("q4_inputs").style.display = "grid";
			document.getElementById("inc_stud4").style.display = "grid";
			document.getElementById("q4_title").style.display = "none";
		}
		if(x=="q5"){
			document.getElementById("q5_inputs").style.display = "grid";
			document.getElementById("inc_stud5").style.display = "grid";
			document.getElementById("q5_title").style.display = "none";
		}
		if(x=="q6"){
			document.getElementById("q6_inputs").style.display = "grid";
			document.getElementById("inc_stud6").style.display = "grid";
			document.getElementById("q6_title").style.display = "none";
		}
	}
}

/* Hide inputs for classroom mapping when area is not hovered over*/
function hideEventInputs() {
	var x = document.getElementsByClassName("quadrant_inputs");
}

function hideEventInputs(x) {
	if(x=="q1"){
		document.getElementById("q1_inputs").style.display = "none";
		if(setInitStud){
			document.getElementById("inc_stud1").style.display = "none";
		}
		document.getElementById("q1_title").style.display = "inline";
	}
	if(x=="q2"){
		document.getElementById("q2_inputs").style.display = "none";
		if(setInitStud){
			document.getElementById("inc_stud2").style.display = "none";
		}
		document.getElementById("q2_title").style.display = "inline";
	}
	if(x=="q3"){
		document.getElementById("q3_inputs").style.display = "none";
		if(setInitStud){
			document.getElementById("inc_stud3").style.display = "none";
		}
		document.getElementById("q3_title").style.display = "inline";
	}
	if(x=="q4"){
		document.getElementById("q4_inputs").style.display = "none";
		if(setInitStud){
			document.getElementById("inc_stud4").style.display = "none";
		}
		document.getElementById("q4_title").style.display = "inline";
	}
	if(x=="q5"){
		document.getElementById("q5_inputs").style.display = "none";
		if(setInitStud){
			document.getElementById("inc_stud5").style.display = "none";
		}
		document.getElementById("q5_title").style.display = "inline";
	}
	if(x=="q6"){
		document.getElementById("q6_inputs").style.display = "none";
		if(setInitStud){
			document.getElementById("inc_stud6").style.display = "none";
		}
		document.getElementById("q6_title").style.display = "inline";
	}
}

/* Print inputed value into feedback container with time stamp AND reset forms*/
function printValue(x) {
		var theDiv = document.getElementById("feedback_container");
		
		// Highlight ACTIVITIES
		var highlightDiv = document.createElement('div');
		highlightDiv.style.backgroundColor = "#3299ba";
		highlightDiv.style.display = "block";
		highlightDiv.style.marginLeft = "2%";
		highlightDiv.style.marginRight = "2%";
		highlightDiv.style.padding = "3%";
		
		// Low-light things other than activities (i.e. events, other notifications)
		var lowlightDiv = document.createElement('div');
		lowlightDiv.style.display = "block";
		lowlightDiv.style.marginLeft = "5%";
		lowlightDiv.style.marginRight = "5%";
		lowlightDiv.style.padding = "1%";
		lowlightDiv.style.backgroundColor = "#F0F0F0";
		
		/* Creates time stamp */
		date = new Date();
		var timeStamp = document.createTextNode("[" + twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes()) + ":" + twoDigits(date.getSeconds()) + "] ");
		/* Get line break */
		var br = document.createElement("br");
		var brAbove = document.createElement("br");
		
		if(x=="interval_readings_form"){
			lowlightDiv.appendChild(timeStamp);
			lowlightDiv.appendChild(document.createTextNode("Interval Reading submitted"));
			theDiv.appendChild(lowlightDiv);
		}
		else {
			/* Get actual value of input */
			var content = document.createTextNode(x.form.id.slice(0, -5) + ": " + x.value);
			
			
			/* Append the above on the div */
			if(x.id =="sub_menu"){
				highlightDiv.appendChild(timeStamp);
				highlightDiv.appendChild(document.createTextNode(x.form.id.slice(0, -5) + ": AT, " + x.value));
				theDiv.appendChild(brAbove);
				theDiv.appendChild(highlightDiv);
				theDiv.appendChild(br);
				x.form.reset();
					
			}
			else {
				if(x.form.id == "student_activities_form" || x.form.id == "instructor_activities_form"){
					highlightDiv.append(timeStamp);
					highlightDiv.append(content);
					theDiv.appendChild(brAbove);
					theDiv.appendChild(highlightDiv);
					theDiv.appendChild(br);
				}
				else {
					lowlightDiv.append(timeStamp);
					lowlightDiv.append(content)
					theDiv.appendChild(lowlightDiv);
				}
			}
		}
		
		updateScroll();
}

function twoDigits(x) {
	return ("0" + x).slice(-2);
}

/* Feedback container automatically scrolls down when overfilled */
function updateScroll(){
    var element = document.getElementById("feedback_container");
    element.scrollTop = element.scrollHeight;
}