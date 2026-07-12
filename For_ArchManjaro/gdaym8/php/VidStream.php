<?php
  include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";
  DrawNavBar();
?>

<html>
<head>
<script>

window.addEventListener("load", function() {
/*  //let video = document.getElementById('video');
  let video = document.getElementById('audio');
  //let first = true
  let time = 0;
  let time2 = 0;

  GetDuration = function() {
    alert(video.ended);
  }

  Refresh = function() {
//    video.src="https://spiderspeed.site:8085";
      video.src="https://vlc.spiderspeed.site";
  }


  //2026-05-10 uses mp3 instead, modified
  CheckEnd = function() {
    time++;
    if (time<2) {
      //video.play();
      //first=false;
    }

    if (video.duration!="Infinity") {
      //alert(video.duration);
      time2++;
      if (time2>2) {
        //Refresh();
	document.getElemtById("mymessage").innerText = "Now Live!";
	time2=0;
      }
    } else {
      document.getElemtById("mymessage").innerText = "If nothing's playing check back another time :P";
    }
  }*/

  let audio = document.getElementById("livesongplayer");
  let mymsg = document.getElementById("mymessage");
  let random_tips = document.getElementById("random_tips");

  CheckEnd = function() {
    const isLive = !(audio.duration === Infinity || audio.seekable.length === 0);
    if (isLive) {
      mymsg.innerText = "";
      random_tips.style.visibility = "hidden";
    } else {
      mymsg.innerText = "If nothing's playing check back another time :P";
      random_tips.style.visibility = "visible";
    }
  }

  setInterval(CheckEnd,5000);
  
});

</script>
</head>
<body class="main_body">
<div class="main_body_background"></div>
<!--<h1> Now Playing: Limp Bizkit - The Chocolate Starfish and the Hotdog Flavored Water </h1>-->

<!--<h1> Now Playing - Pendulum  </h1>-->




<?php
  //if (!isStreamReachable("https://vlc.spiderspeed.com")) {
    echo "<p id='mymessage'>If nothing's playing check back another time :P</p>";
  //} else {
    //echo "<p id='mymessage'>Now Live! Hit Play!</p>";
  //}
?>

<!--<video id="video" src="http://vlc.spiderspeed.site" autoplay="autoplay" width="320" height="240" controls>
</video>-->

<!--
Source - https://stackoverflow.com/a/33512389
Posted by rogerdpack, modified by community. See post 'Timeline' for change history
Retrieved 2026-05-10, License - CC BY-SA 3.0
-->

<audio id="livesongplayer" controls>
  <source src="https://vlc.spiderspeed.site" type="audio/mpeg">
</audio>


<!--<a href="vlc-x-callback://x-callback-url/ACTION?url=https://spiderspeed.site:8085">Click here for playback in VLC</a>-->

<!--<br><button onclick="GetDuration()">Get Detail</button>-->
<br>
<!--<button onclick="Refresh()">Play</button>-->
</body>
</html>
