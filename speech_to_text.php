<!DOCTYPE html>
<html>
  <head>
    <title>
      Speech Recognition Demo
    </title>
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
          document.getElementById('search-input').value= evt.results[0][0].transcript;
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
  </head>
  <body>
    <!-- [THE SIMPLE SEARCH FORM] -->
      <!-- SEARCH FIELD -->
      <input type="text" id="search-input"/>
      <!-- SPEECH RECOGNITION -->
      <div id="search-speech" style="display:none">
        <br><br>
        <p>
          Click on "Speech Recognition On", speak into the mic, and wait for a second.
        </p>
        <input type="button" disabled id="search-on" value="Speech Recognition On" onclick="speech.start()"/>
        <input type="button" disabled id="search-off" value="Cancel" onclick="speech.stop()"/>
      </div>
  </body>
</html>

