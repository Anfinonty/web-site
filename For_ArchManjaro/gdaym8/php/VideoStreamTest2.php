<?php 
  include "VideoStream.php"; 

  $filePath = "../audio/Music/Limp Bizkit/Chocolate Starfish and the Hot Dog Flavored Water/05 - My Way.flac"; 


  $stream = new VideoStream($filePath); 
  $stream->start();
?>
