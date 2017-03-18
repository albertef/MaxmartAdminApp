function init() {
	document.addEventListener('deviceready', function(){
		//notificationData();
		receivedEvent('deviceready');
	}, false);
	
	document.addEventListener("backbutton", function(e){
       if($('html').attr('id') == "homepage"){
           e.preventDefault();
           navigator.app.exitApp();
       }
       else {
           navigator.app.backHistory();
       }
    }, false);
	
	localStorage.setItem('passNo',0);
}
function initInner() {
	document.addEventListener('deviceready', onDeviceReady, false);
	mainForm();
}
function readEntryPage() {
	document.addEventListener('deviceready', onDeviceReady, false);
	readEntry();
}
function statusEntry() {
	document.addEventListener('deviceready', onDeviceReady, false);
}

function onDeviceReady() {
    receivedEvent('deviceready');
	
}

function passwordCheck(){
	var passNo = localStorage.getItem('passNo');
	console.log(passNo);
	var pass = document.getElementById('password');
	console.log(pass.value);
	if(pass.value=="maxmobile@2017"){
		window.location.href= 'main.html';
	}
	else{		
		if(passNo > 3){
			pass.setAttribute("disabled", "");
			document.getElementById('passLabel').style.display = "block";
			document.getElementById('passLabel').innerHTML = "*Please contact super admin for correct password!";
			setTimeout(function(){pass.removeAttribute("disabled", "");},10000);
		}
		else {
			document.getElementById('passLabel').style.display = "block";
			document.getElementById('passLabel').innerHTML = "*Wrong Password. Try Again!";
			localStorage.setItem('passNo', parseInt(passNo)+1);
		}
	}
}

function notificationData(){
	//alert("notification fun");
	var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
           if (xmlhttp.status == 200) {
               var msg = xmlhttp.responseText;
			   window.plugin.notification.local.schedule({ title: 'Maxmart New Enquiry', text: msg, icon: 'res://icon.png' });
           }
           else if (xmlhttp.status == 400) {
              alert('There was an error 400');
           }
           else {
               alert('Please check your internet connectivity');
           }
        }
    };

    xmlhttp.open("GET", "http://www.maxmarttrading.com/mobile_app/form-api-admin.php?notification=true", true);
    xmlhttp.send();
}


function receivedEvent(id) {
	var parentElement = document.getElementById(id);
    var listeningElement = parentElement.querySelector('.listening');
    var receivedElement = parentElement.querySelector('.received');

    listeningElement.setAttribute('style', 'display:none;');
    receivedElement.setAttribute('style', 'display:block;');
	
}

function mainForm(){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
		   if (xmlhttp.status == 200) {
			   document.getElementById('resultTable').innerHTML = xmlhttp.responseText;
			   
		   }
		   else if (xmlhttp.status == 400) {
			  alert('There was an error 400');
		   }
		   else {
			   alert('Please check your internet connectivity');
		   }
		}
	};

	xmlhttp.open("GET", "http://www.maxmarttrading.com/mobile_app/form-api-admin.php", true);
	xmlhttp.send();
}
function readEntry(){
	
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
           if (xmlhttp.status == 200) {
               document.getElementById('resultTable').innerHTML = xmlhttp.responseText;
			   
           }
           else if (xmlhttp.status == 400) {
              alert('There was an error 400');
           }
           else {
               alert('Please check your internet connectivity');
           }
        }
    };

    xmlhttp.open("GET", "http://www.maxmarttrading.com/mobile_app/form-api-admin.php?read", true);
    xmlhttp.send();

}
function detailView(id){
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
           if (xmlhttp.status == 200) {
               document.getElementById('resultTable').innerHTML = xmlhttp.responseText;
           }
           else if (xmlhttp.status == 400) {
              alert('There was an error 400');
           }
           else {
               alert('Please check your internet connectivity');
           }
        }
    };

    xmlhttp.open("GET", "http://www.maxmarttrading.com/mobile_app/form-api-admin.php?view=" + id, true);
    xmlhttp.send();
}
function statusUpdate(){
	//alert('status');
	var refno = document.getElementById('refno').value;
	var statusvalue = document.getElementById('statusValue').value;
	
	//alert("http://www.maxmarttrading.com/mobile_app/form-api-admin.php?statusvalue=" + statusvalue + "&refno=" + refno);
		
	var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
           if (xmlhttp.status == 200) {
			   document.getElementById('statusResult').style.opacity = 1;
               document.getElementById('statusResult').innerHTML = xmlhttp.responseText;
           }
           else if (xmlhttp.status == 400) {
              alert('There was an error 400');
           }
           else {
               alert('Please check your internet connectivity');
           }
        }
    };

    xmlhttp.open("GET", "http://www.maxmarttrading.com/mobile_app/form-api-admin.php?statusvalue=" + statusvalue + "&refno=" + refno, true);
    xmlhttp.send();
}