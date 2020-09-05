<!DOCTYPE html>
<html>
<script>
    // [3] HANDLE SPEECH RECOGNITION
    var speech = {
      start : function () {
      // speech.start() : start speech recognition
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        speech.recognition = new SpeechRecognition();
        speech.recognition.continuous = true;
        speech.recognition.interimResults = false;
        speech.recognition.lang = "en-US";
        speech.recognition.onerror = function (evt) {
          console.log(evt);
        };
        speech.recognition.onresult = function (evt) {
          document.getElementById('inputText').value= evt.results[0][0].transcript;
          speech.stop();
        };
        speech.recognition.start();
        document.getElementById('search-on').disabled = true;
        document.getElementById('search-off').disabled = false;
      },

      stop : function () {
      // speech.stop() : end speech recognition

        if (speech.recognition != null) {
          speech.recognition.stop();
          speech.recognition = null;
          document.getElementById('search-on').disabled = false;
          document.getElementById('search-off').disabled = true;
        }
      }
    };
    window.addEventListener("load", function () {
      // [1] CHECK IF BROWSER SUPPORTS SPEECH RECOGNITION
      if (window.hasOwnProperty('SpeechRecognition') || window.hasOwnProperty('webkitSpeechRecognition')) {
        document.getElementById("search-speech").style.display = "block";
        // [2] ASK FOR USER PERMISSION TO ACCESS MICROPHONE
        // WILL ALSO FAIL IF NO MICROPHONE IS ATTACHED TO COMPUTER
        navigator.mediaDevices.getUserMedia({ audio: true })
        .then(function(stream) {
          document.getElementById("search-on").disabled = false;
        })
        .catch(function(err) {
          document.getElementById("search-speech").innerHTML = "Please enable access and attach a microphone";
        });
      }
    });
    </script>
    <head>
    	<?php require_once("include.php"); ?>
        <title>ISL : Avatar Page</title>
        <link rel="stylesheet" href="css/cwasa.css" />
        <script type="text/javascript" src="js/allcsa.js"></script>
        <script language="javascript">
			// Initial configuration
			var initCfg = {
				"aamk" : ["abc", "siggi", "anna", "marc", "francoise"],
				"avSettings" : { "avList": "aamk", "initAv": "marc" }
				};
			// global variable to store the sigmal list
			var sigmlList = null;
            // global variable to tell if avatar is ready or not
            var tuavatarLoaded = false;
		</script>
    </head>
    <body onload="CWASA.init(initCfg);" style="margin-top:0!important;">
        <h1><center>
            <b>Indian Sign Language Generator</b><hr>
        </center>
        </h1>
    <?php
    	// include_once("nav.php");
    ?>      
    <div id="loading" class="container"><div class="row text-center"><span style="background-color:#ebf8a4; padding: 8px 20px;">Loading ... Please wait...</div></div></div>
        <!-- left side division starts here -->
		<div style="width:40%; padding:15px; float:left; margin-left:14%;">

<div id="menu1">
<br>
<label for="inputText">Enter the text to animate</label><br>
<textarea id="inputText" style="width:100%; height:80px;" autofocus></textarea><br><br>
<div id="search-speech" style="display:none">
        <br><br>
        <p>
          Click on "Speech Recognition On", speak into the mic, and wait for a second.
        </p>
        <input type="button" disabled id="search-on" value="Speech Recognition On" onclick="speech.start()"/>
        <input type="button" disabled id="search-off" value="Cancel" onclick="speech.stop()"/>
        <br><br>
      </div>
<button type="button" id="btnRun" class="btn btn-primary">  Generate Play Sequence</button>
<button type="button" id="btnClear" class="btn btn-default">Clear</button>
</div>

<div id="menu2">
<br>
Words will be displayed here
</div>

<div id="menu3">
<br>
Alphabets will be displayed here
</div>

<div id="menu4">
<br>
Number will be displayed here
</div>

<!-- <div id="debuggercontainer" style="margin-top:10px; border-top:3px solid black;">
	<br><strong>Debugger</strong></br>
	<div id="debugger"></div>
</div> -->
		</div> <!-- left side division ends here -->
<script language="javascript" src="js/animationPlayer.js"></script>		
		<?php 
			// This is the main player where the animation happens	
			include_once("animationPlayer.php"); 
		?>


<script type="text/javascript" src="js/player.js"></script>
<script type="text/javascript">
/*
	Load json file for sigml available for easy searching
*/
$.getJSON("js/sigmlFiles.json", function(json){
    sigmlList = json;
});

// code for clear button in input box for words
$("#btnClear").click(function() {
	$("#inputText").val("");
    $("#debugger").html("");
});

// code to check if avatar has been loaded or not and hide the loading sign
var loadingTout = setInterval(function() {
    if(tuavatarLoaded) {
        $("#loading").hide();
        clearInterval(loadingTout);
        console.log("Avatar loaded successfully !");
    }
}, 1000);
// code to animate tabs

alltabhead = ["menu1-h", "menu2-h", "menu3-h", "menu4-h"];
alltabbody = ["menu1", "menu2", "menu3", "menu4"];

function activateTab(tabheadid, tabbodyid)
{
    for(x = 0; x < alltabhead.length; x++)
        $("#"+alltabhead[x]).css("background-color", "white");
    $("#"+tabheadid).css("background-color", "#d5d5d5");
    for(x = 0; x < alltabbody.length; x++)
        $("#"+alltabbody[x]).hide();
    $("#"+tabbodyid).show();
}

activateTab("menu1-h", "menu1"); // activate first menu by default

</script>

    </body>
</html>
