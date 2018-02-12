function new_window(freshurl)
{
	SmallWin = window.open(freshurl, "Calendar",
	 "scrollbars=yes,resizable=yes,toolbar=no,height=300,width=400");
	if (window.focus) { SmallWin.focus(); }
	if (SmallWin.opener == null) { SmallWin.opener = window; }
	SmallWin.opener.name = "Main";
}

function ValidateJumpToDateSelectorForm()
{
	if (document.getElementById) {
		var combined = document.getElementById("JumpToDateSelectorCombined");
		if (combined && combined.value == "") { return false; }
	}
	return true;
}

function setRadioButton(radioID, state)
{
	if (document.getElementById) {
		if (document.getElementById(radioID)) {
			document.getElementById(radioID).checked = true;
		}
	}
}

function ChangeCalendar(Side,URL)
{
	if (document.getElementById) {
		var objLeft = document.getElementById("LeftArrowButton");
		var objRight = document.getElementById("RightArrowButton");
		var objLeftDisabled = document.getElementById("LeftArrowButtonDisabled");
		var objRightDisabled = document.getElementById("RightArrowButtonDisabled");
		if (objLeft && objRight && objLeftDisabled && objRightDisabled) {
			if (Side == "Left") {
				objLeft.style.display = "none";
				objRight.style.display = "none";
				objLeftDisabled.style.display = "";
				objRightDisabled.style.display = "";
			}
			else {
				objLeft.style.display = "none";
				objRight.style.display = "none";
				objLeftDisabled.style.display = "";
				objRightDisabled.style.display = "";
			}
		}
	}
	var objDate = new Date();
	var returnValue = httpGet(URL, objDate.getTime(), ChangeCalendarProcessor);
	return !returnValue;
}

function ChangeCalendarProcessor(id, returnValue)
{
	if (document.getElementById) {
		var objLittleCalendarContainer = document.getElementById("LittleCalendarContainer");
		if (objLittleCalendarContainer) {
			if (returnValue.indexOf("ERROR:") == 0) {
				if (document.getElementById) {
					var objLeftDisabled = document.getElementById("LeftArrowButtonDisabled");
					var objRightDisabled = document.getElementById("RightArrowButtonDisabled");
					if (objLeftDisabled && objRightDisabled) {
						objLeftDisabled.style.display = "none";
						objRightDisabled.style.display = "none";
					}
				}
			}
			else {
				objLittleCalendarContainer.innerHTML = returnValue;
			}
		}
		else {
			alert("Could not locate CalendarContainer after processing: " + objLittleCalendarContainer);
		}
	}
}

function SetSponsorDefault(typeNum)
{
	var type = (typeNum == 1)? "name" : ((typeNum == 2)? "url" : "");
	if (document.getElementById) {
		var objSelectedSponsorID = document.getElementById("selectedsponsorid");
		var objTextbox = document.getElementById("defaultsponsor" + type + "text");
		var objButton = document.getElementById("defaultsponsor" + type + "button");
		if (objSelectedSponsorID && objTextbox && objButton) {
			objTextbox.disabled = true;
			objButton.disabled = true;
		}
		if (objSelectedSponsorID) {
			var sponsorID = 0;
			if (objSelectedSponsorID.value && !objSelectedSponsorID.value=="") {
				sponsorID = objSelectedSponsorID.value;
			}
			else if (objSelectedSponsorID.selectedIndex &&
			 objSelectedSponsorID[objSelectedSponsorID.selectedIndex].value) {
				sponsorID = objSelectedSponsorID[objSelectedSponsorID.selectedIndex].value;
			}
			var returnValue = httpGet("getsponsorinfo.php?sponsorid=" + sponsorID + "&type=" + type,
			 typeNum, SetSponsorDefaultProcessor);
			return !returnValue;
		}
	}
	return false;
}

function SetSponsorDefaultProcessor(id, returnValue)
{
	var type = (id == 1)? "name" : ((id == 2)? "url" : "");
	if (document.getElementById) {
		var objTextbox = document.getElementById("defaultsponsor" + type + "text");
		var objButton = document.getElementById("defaultsponsor" + type + "button");
		if (objTextbox && objButton) {
			if (returnValue.indexOf("ERROR:") != 0 &&
			 returnValue.indexOf("INVALID_SPONSOR_ID:") != 0 &&
			 returnValue.indexOf("SPONSOR_ID_NOTFOUND:") != 0) {
				objTextbox.value = returnValue;
			}
			objTextbox.disabled = false;
			objButton.disabled = false;
		}
	}
}

var objHttpSessions = new Array();

function makeHttp()
{
	var xmlObj;
	if (window.XMLHttpRequest) { // branch for native XMLHttpRequest object
		if (xmlObj = new XMLHttpRequest()) { return xmlObj; }
		return null;
	}
	if (window.ActiveXObject) { // branch for IE/Windows ActiveX version
		if (xmlObj = new ActiveXObject("Msxml2.XMLHTTP")) { return xmlObj; }
		if (xmlObj = new ActiveXObject("Microsoft.XMLHTTP")) { return xmlObj; }
		return null;
	}
	return null; // Otherwise, the XMLHttpRequest object could not be created.
}

function httpGet(url, sessionID, externalHandler)
{
	objHttpSessions[sessionID] = new Array(makeHttp(), externalHandler);
	// If the xmlHttpRequest object was created...
	if (objHttpSessions[sessionID][0]) {
		// Set the processing function.
		objHttpSessions[sessionID][0].onreadystatechange = new Function("processSession(" + sessionID + ");");
		// Set up the connection.
		objHttpSessions[sessionID][0].open("GET", url, true);
		// branch for native XMLHttpRequest object
		if (window.XMLHttpRequest) { objHttpSessions[sessionID][0].send(null); }
		// branch for IE/Windows ActiveX version
		else if (window.ActiveXObject) { objHttpSessions[sessionID][0].send(); }
		return true;
	}
	else { return false; } // If the xmlHttpRequest object was NOT created...
}

function processSession(sessionID)
{
	// If the processing has completed...
	if (objHttpSessions[sessionID][0].readyState == 4) {
		if (objHttpSessions[sessionID][0].status == 200) {
			// Execute the processing function and pass the response text.
			objHttpSessions[sessionID][1](sessionID, objHttpSessions[sessionID][0].responseText);
		}
		else {
			// Execute the processing function and pass the response text as an error.
			objHttpSessions[sessionID][1](sessionID, "ERROR:" + objHttpSessions[sessionID][0].status);
		}
	}
}

function checkAll(myForm, oid, state)
{
	// determine if ALL of the checkboxes is checked
	var cnt, ii, ckb, b=new Boolean(true);
	for (cnt=0, ii=myForm.elements.length; cnt < ii; cnt++) {
		ckb = myForm.elements[cnt];
		if (ckb.type == "checkbox" && ckb.name.indexOf(oid) == 0) {
			if (ckb.checked == false) { b = false; break; }
		}
	}
	for (cnt=0, ii=myForm.elements.length; cnt < ii; cnt++) {
		ckb = myForm.elements[cnt];
		if (ckb.type == "checkbox" && ckb.name.indexOf(oid) == 0) {
			if (b == true) { ckb.checked = false; }
			else { ckb.checked = true; };
		}
	}
}
