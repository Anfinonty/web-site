<?php
  include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";
  DrawNavBar();
?>

<html>
<head>
<script>

window.addEventListener("load", function() {
  let video = document.getElementById('video');
  //let first = true
  let time = 0;
  let time2 = 0;

  GetDuration = function() {
    alert(video.ended);
  }

  Refresh = function() {
    video.src="https://gdaym8.site:8085";
  }


  CheckEnd = function() {
    time++;
    if (time<2) {
      video.play();
      //first=false;
    }

    if (video.duration!="Infinity") {
      //alert(video.duration);
      time2++;
      if (time2>2) {
        Refresh();
	time2=0;
      }
    }
  }

  setInterval(CheckEnd,1000);
});

</script>
</head>
<body>
<!--<h1> Now Playing: Limp Bizkit - The Chocolate Starfish and the Hotdog Flavored Water </h1>-->

<h1> Now Playing - Pendulum  </h1>
<p>If nothing's playing check back another time :P</p>
<video id="video" src="https://gdaym8.site:8085" autoplay="autoplay" width="320" height="240" controls>
</video>

<!--<a href="vlc-x-callback://x-callback-url/ACTION?url=https://gdaym8.site:8085">Click here for playback in VLC</a>-->

<!--<br><button onclick="GetDuration()">Get Detail</button>-->
<br>
<button onclick="Refresh()">Play</button>
</body>
</html>
