/**
 * 
 */
var hasStarted = false;
var itimer = 120;
var myInterval;
var delay;
var delay2;
var intervalNum = 0;
var checkboxActivities = [];
var allActivities = [];
var SN1, SN2, SN3, SN4, SN5, SN6;
SN1 = SN2 = SN3 = SN4 = SN5 = SN6 = 0;

var html = `
<table style="width:auto; height:auto;">
<caption style="font-size: 40%; padding-top: 5%"> [ NUMBOX ] </caption>
<tr>
<td rowspan="3"><span class='ti-user' style='vertical-align: -2px; font-size: 100%;'></span></td>
<td><button class="circularButton" title="Increment Students" type="button" id="more_students" onclick="updateStudentNum(this,NUMBOX)" style="font-weight: bold; font-size: 100%;">+</button></td>
<td rowspan="3">
	<button class="button" style="width:100%" onclick="dataToFeed(event,this,NUMBOX)">Asks Question</button> 
	<button class="button" style="width:100%" onclick="dataToFeed(event,this,NUMBOX)">Response to Instructor</button>
	<button class="button" style="width:100%" onclick="dataToFeed(event,this,NUMBOX)">Make Prediction</button>
	<button class="button" style="width:100%" onclick="dataToFeed(event,this,NUMBOX)">Response to Student</button>
</td>
</tr>
<tr>
<td id="numStudentLabelNUMBOX" style="font-size: 50%;"> Value </td>
</tr>
<tr>
<td><button class="circularButton" title="Decrement Students" type="button" id="less_students" onclick="updateStudentNum(this,NUMBOX)" style="font-weight: bold; font-size: 100%;">-</button></td>
</tr>
</table>
`;

const NUM_ROWS = 10;
const NUM_COLUMNS = 30;

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
	box.onclick= function(){openClassInputs(bid,event)};
	frame.appendChild(box);
	
	console.log("(" + x + "," + y+"); height: " + height + "; width: " + width);
}

// Updates the feed everytime a student is added only after the interval has started
function studentNumToFeed(num, option){
	console.log("interval num: " + intervalNum);
	console.log(option);
	if (option && intervalNum != 0) {
		var content = document.createTextNode("Section " + num + " one added.");
		var modal = document.getElementsByClassName("modal-body");
	var br = document.createElement("br");
	date = new Date();
	var timeStamp = document.createTextNode("[" + twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes()) + ":" + twoDigits(date.getSeconds()) + "] ");
	modal[0].appendChild(timeStamp);
	modal[0].appendChild(content);
	modal[0].appendChild(br);
	}
	if (!option && intervalNum != 0) {
		var content = document.createTextNode("Section " + num + " one removed.");
		var modal = document.getElementsByClassName("modal-body");
	var br = document.createElement("br");
	date = new Date();
	var timeStamp = document.createTextNode("[" + twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes()) + ":" + twoDigits(date.getSeconds()) + "] ");
	modal[0].appendChild(timeStamp);
	modal[0].appendChild(content);
	modal[0].appendChild(br);
	}
	
}

function updateStudentNum(obj, num){
	var id = "numStudentLabel" + num;
	var label = document.getElementById(id);
	if(obj.id == "more_students"){
		switch (num) {
		  case 1:
		    SN1++;
			label.textContent = SN1;
			studentNumToFeed(num, true);
		    break;
		  case 2:
			SN2++;
			label.textContent = SN2;
			studentNumToFeed(num, true);
			break;
		  case 3:
			SN3++;
			label.textContent = SN3;
			studentNumToFeed(num, true);
		    break;
		  case 4:
			SN4++;
			label.textContent = SN4;
			studentNumToFeed(num, true);
		    break;
		  case 5:
			SN5++;
			label.textContent = SN5;
			studentNumToFeed(num, true);
		    break;
		  case 6:
			SN6++;
			label.textContent = SN6;
			studentNumToFeed(num, true);
		}
	}else {
		switch (num) {
		  case 1:
		    if(SN1 > 0)SN1--;
			label.textContent = SN1;
			studentNumToFeed(num, false);
		    break;
		  case 2:
			if(SN2 > 0)SN2--;
			label.textContent = SN2;
			studentNumToFeed(num, false);
			break;
		  case 3:
			if(SN3 > 0)SN3--;
			label.textContent = SN3;
			studentNumToFeed(num, false);
			break;
		  case 4:
			if(SN4 > 0)SN4--;
			label.textContent = SN4;
			studentNumToFeed(num, false);
			break;
		  case 5:
			if(SN5 > 0)SN5--;
			label.textContent = SN5;
			studentNumToFeed(num, false);
			break;
		  case 6:
			if(SN6 > 0)SN6--;
			label.textContent = SN6;
			studentNumToFeed(num, false);
		}
	}
}

function openClassInputs(bid,event) {
	htmlEdited=html.replace(/NUMBOX/g,String(bid));
	var sn;
	switch (bid) {
	  case 1:
	    sn = SN1;
	    break;
	  case 2:
		 sn = SN2;
	    break;
	  case 3:
		 sn = SN3;
	    break;
	  case 4:
		 sn = SN4;
	    break;
	  case 5:
		 sn = SN5;
	    break;
	  case 6:
		 sn = SN6;
	}
	htmlEdited= htmlEdited.replace("Value", sn);
	hideAll();
	ID = 's' + bid;
	var section = document.getElementById(ID);

	
	
	if(section.style.display == "none")
	{
		x=event.screenX-150;
   	    y=event.screenY-150;
        
    	section.style.left=x+"px";
    	section.style.top=y+"px";
		section.style.display = "block";
		section.innerHTML = htmlEdited; 
		
	}
	else
	{
		section.style.display = "none";
	}
		
}

function hideAll() {
	var inputs = document.getElementsByClassName("class_section_input");
	for(var i = 0; i < inputs.length; i++){
		inputs[i].style.display = "none";
	}
}





function setAllDefaultValues() {
	//alert("hello!");
	hasStarted = false;
	intervalNum = 0;
	SN1 = SN2 = SN3 = SN4 = SN5 = SN6 = 0;
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

		// If this is the very first time starting, submit number of students in each section to Feed
		if (intervalNum === 0) {
			intervalNum += 1;
			var modal = document.getElementsByClassName("modal-body");
			var content = document.createTextNode("Section 1: " + SN1 + ", Section 2: " + SN2 + ", Section 3: " + SN3+ ", Section 4: " + SN4 + ", Section 5: " + SN5 + ", Section 6: " + SN6);
			var br = document.createElement("br");
			date = new Date();
			var timeStamp = document.createTextNode("[" + twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes()) + ":" + twoDigits(date.getSeconds()) + "] ");
			modal[0].appendChild(timeStamp);
			modal[0].appendChild(content);
			modal[0].appendChild(br);
		}

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
	// while (myNode[0].firstChild) {
	//     myNode[0].removeChild(myNode[0].firstChild);
	// }
	clearInterval(myInterval);
	itimer = 120;
}



function dataToFeed(event, obj, extra1) {
	if(hasStarted){
		var myNode = document.getElementsByClassName("fadingFeed");
		var nodeName = obj.nodeName;

		while (myNode[0].firstChild) {
			myNode[0].removeChild(myNode[0].firstChild);
	}
	    var fullTextContent = '';
		if(extra1 != null){
			fullTextContent += ("Section " + extra1 + ": ");
		}
		fullTextContent += obj.textContent;

		
		var modal = document.getElementsByClassName("modal-body");
		var notification = document.getElementsByClassName("fadingFeed");
		var content = document.createTextNode(fullTextContent);
		var notificationContent = document.createTextNode(obj.textContent);
		var br = document.createElement("br");
		date = new Date();
		var timeStamp = document.createTextNode("[" + twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes()) + ":" + twoDigits(date.getSeconds()) + "] ");
		
		
		if (nodeName === "INPUT") {
			if (obj.checked) {
				checkboxActivities.push(obj.getAttribute('id'));
				allActivities.push(obj.getAttribute('id').toString());
				// modal[0].appendChild(timeStamp);
				// modal[0].appendChild(document.createTextNode(obj.getAttribute('id')));
				// modal[0].appendChild(br);
				// notification[0].appendChild(checkNotification);
			}
			else { 
				checkboxActivities.splice(checkboxActivities.indexOf(obj.getAttribute('id')), 1);
				allActivities.splice(allActivities.indexOf(obj.getAttribute('id')), 1);
			// 	var uncheckNotification = document.createTextNode("Unchecked " + obj.getAttribute('id'));
			// 	modal[0].appendChild(timeStamp);
			// 	modal[0].appendChild(document.createTextNode("Unchecked " + obj.getAttribute('id')));
			// 	modal[0].appendChild(br);
			// 	notification[0].appendChild(uncheckNotification);
			}
		}	
		else {
			modal[0].appendChild(timeStamp);
			modal[0].appendChild(content);
			modal[0].appendChild(br);
			notification[0].appendChild(notificationContent);
			allActivities.push(notificationContent.wholeText);
		}
		
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
		//if(itimer <= 120 && itimer != 0)
			document.getElementById("timer").innerHTML = "Next in: " + min + ":" + sec;
		if(itimer == 0){
			/* Submit interval readings every time timer reaches 0*/
			intervalSubmit();
			document.getElementById("timer").innerHTML = "Interval submitted!";
			itimer = 120;
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
		
		if(event.target.className != 'classroom_box' && event.target.id != 'more_students' && event.target.id != 'less_students'){
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
	var content = document.createTextNode("Interval submitted. " + checkboxActivities.toString());
	var br = document.createElement("br");
	date = new Date();
	var timeStamp = document.createTextNode("[" + twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes()) + ":" + twoDigits(date.getSeconds()) + "] ");
	modal[0].appendChild(timeStamp);
	modal[0].appendChild(content);
	modal[0].appendChild(br);

	checkboxActivities = [];
	console.log(allActivities.toString());
}

function showSubmenu(menuID) {
	//document.getElementsByClassName("dropdown2-content")[0].style.display = "inline-block";
	//console.log("done")
	document.getElementById(menuID).style.display = "inline-block";
	//alert(menuID);
}

function hideSubmenu(menuID) {
	document.getElementById(menuID).style.display = "none";
	//console.log("done")
}