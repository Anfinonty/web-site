<?php 
  include "VideoStream.php"; 

  $filePath = "../audio/Music/Limp Bizkit/Chocolate Starfish and the Hot Dog Flavored Water/05 - My Way.flac"; 


  $stream = new VideoStream($filePath); 
  //$stream->start();
?>


<html>
  <head></head>
  <body>
    <h1>Stream Test</h1>
    <video src="https://gdaym8.site/php/VideoStreamTest2.php" autoplay="autoplay">
    </video>
  </body>
</html>
