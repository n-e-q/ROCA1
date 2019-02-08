/**
 * 
 */
var hasStarted = false;
var itimer = 30;
var myInterval;
var delay;
var delay2;

const NUM_ROWS = 10;
const NUM_COLUMNS = 30;

function createBoxes(){
	
	shadeGrid(0,2,9,5, 1);
	shadeGrid(2,5,10,6, 2);
	shadeGrid(5,6,12,7, 3);
	shadeGrid(12,0,28,4, 4);
	shadeGrid(13,4,23,6, 5);
	shadeGrid(13,6,20,7, 6);
	
	/*
	 * 1: (0,2), (9,5)
	 * 2: (2,5), (10,6)
	 * 3: (5,6), (12,7)
	 * 4: (12,0), (28,4)
	 * 5: (13,4), (23,6)
	 * 6: (13,6), (20,7)
	 * 
	 */
}

function shadeGrid(x1, y1, x2, y2, bid){
	
	var frame = document.getElementById('classroom_mapping');
	
	var height = y2 - y1;
	var width = x2 - x1;
	var x = x1+2;
	var y = NUM_ROWS - (height + y1);
	
	var box = document.createElement('div');
	
	box.id = bid;
	box.className = "classroom_box"
	box.style.backgroundColor = "rgba(98,86, 80, 0.5)";
	box.style.gridRow= y + " / span " + height;
	box.style.gridColumn = x + " / span " + width;
	box.style.border = "solid";
	
	//box.onmouseover = openClassInputs();
	box.onclick= function(){openClassInputs(bid)};
	frame.appendChild(box);
	
	console.log("(" + x + "," + y+"); height: " + height + "; width: " + width);
}




function openClassInputs(bid) {

	ID = 's' + bid;
	var section = document.getElementById(ID);
	section.textContent = "BOX " + bid;
	if(section.style.display == "none")
		section.style.display = "block";
	else
		section.style.display = "none";
}





function setAllDefaultValues() {
	//alert("hello!");
	hasStarted = false;
	var inputs = document.getElementsByClassName("class_section_input");
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
	
	inputs = document.getElementById("timer");
	inputs.innerHTML = "";
	
	var startButton = document.getElementById("start_button");
	startButton.innerHTML = "<span class='ti-control-play' style='vertical-align: -2px'></span>";
	startButton.className="pulse-button"
	startButton.style.backgroundColor = "";
	
	createBoxes();
}

function start_or_stop() {
	if(!hasStarted){
		hasStarted = true;
		
		var modal = document.getElementsByClassName("modal-body");
		var content = document.createTextNode("Observation Started.");
		var br = document.createElement("br");
		date = new Date();
		var timeStamp = document.createTextNode("[" + twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes()) + ":" + twoDigits(date.getSeconds()) + "] ");
		modal[0].appendChild(timeStamp);
		modal[0].appendChild(content);
		modal[0].appendChild(br);
		
		var inputs = document.getElementsByTagName("INPUT");
		for (var i = 0; i < inputs.length; i++) {
			if(inputs[i].className != "inS" && inputs[i].className != "inS_text")
				inputs[i].disabled = false;
		}
		
		var startButton = document.getElementById("start_button");
		if (startButton.className=="pulse-button") startButton.className="circularButton";
		startButton.innerHTML = "<span class='ti-control-stop' style='vertical-align: -2px'></span>";
		startButton.style.backgroundColor = "red";
		myInterval = setInterval(runIntervalTimer, 1000);
	}
	else {
		reload();
	}
}

function reload() {
	setAllDefaultValues();
	var myNode = document.getElementsByClassName("modal-body");
	while (myNode[0].firstChild) {
	    myNode[0].removeChild(myNode[0].firstChild);
	}
	clearInterval(myInterval);
	itimer = 30;
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
	if(hasStarted){
		var myNode = document.getElementsByClassName("fadingFeed");
		while (myNode[0].firstChild) {
	    myNode[0].removeChild(myNode[0].firstChild);
	}
	    //$(".fadingFeed").fadeIn()
		var modal = document.getElementsByClassName("modal-body");
		var notification = document.getElementsByClassName("fadingFeed");
		var content = document.createTextNode(obj.textContent);
		var notificationContent = document.createTextNode(obj.textContent);
		var br = document.createElement("br");
		date = new Date();
		var timeStamp = document.createTextNode("[" + twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes()) + ":" + twoDigits(date.getSeconds()) + "] ");
		modal[0].appendChild(timeStamp);
		modal[0].appendChild(content);
		modal[0].appendChild(br);
		notification[0].appendChild(notificationContent);
		
		//$(".fadingFeed").delay(2000).fadeOut()
		
		//openFeed(event);
		fadeFeedHandler(event);
	}
}

function fadeFeedHandler(event) {
	clearTimeout(delay2);
	$(".fadingFeed").fadeIn()
	delay2 = setTimeout(function(){ $(".fadingFeed").fadeOut(); }, 2000);
	event.stopPropagation();
}


function openFeed(event) 
{
	// Get the modal
	clearTimeout(delay);
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
	console.log(event.toElement.tagName);
	if(event.toElement.tagName != "SPAN" && event.toElement.tagName != "BUTTON")
		delay = setTimeout(function(){ modal.style.display = "none"; }, 3000);
	event.stopPropagation();
	
}

function runIntervalTimer() {
	if(hasStarted){
		var min = Math.floor(itimer / 60);
		var sec = twoDigits(itimer % 60);
		document.getElementById("timer").innerHTML = "";
		if(itimer <= 100 && itimer != 0)
			document.getElementById("timer").innerHTML = "Next in: " + min + ":" + sec;
		if(itimer == 0){
			/* Submit interval readings every time timer reaches 0*/
			intervalSubmit();
			document.getElementById("timer").innerHTML = "Interval submitted!";
			itimer = 30;
		}
		else {
			itimer = itimer -1;
		}
	}
}

window.onclick = function(event) {
	//if (event.target == modal) {
		var modal = document.getElementById('feed');
		modal.style.display = "none";
		
		if(event.target.className != 'classroom_box'){
			var inputs = document.getElementsByClassName('class_section_input');
			for (var i = 0; i < inputs.length; i++) {
			    inputs[i].style.display = "none";
			}
			console.log(event.target);
		}
		
	//}
}

function updateScroll(){
    var element = document.getElementsByClassName("modal-body");
    element[0].scrollTop = element[0].scrollHeight;
}

function twoDigits(x) {
	return ("0" + x).slice(-2);
}

function intervalSubmit() {
	var intForm = document.getElementById("interval_readings_form");
	intForm.submit();
	intForm.reset();
	
	var modal = document.getElementsByClassName("modal-body");
	var content = document.createTextNode("Interval submitted.");
	var br = document.createElement("br");
	date = new Date();
	var timeStamp = document.createTextNode("[" + twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes()) + ":" + twoDigits(date.getSeconds()) + "] ");
	modal[0].appendChild(timeStamp);
	modal[0].appendChild(content);
	modal[0].appendChild(br);
}

function showSubmenu() {
	document.getElementsByClassName("dropdown2-content")[0].style.display = "inline-block";
	//console.log("done")
}

function hideSubmenu() {
	document.getElementsByClassName("dropdown2-content")[0].style.display = "none";
	//console.log("done")
}