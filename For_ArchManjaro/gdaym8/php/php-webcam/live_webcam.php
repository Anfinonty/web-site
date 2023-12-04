<?php
  function show_b64jpeg($fname) {
    $myfile = fopen($fname, "r") or die("Unable to open file!");
    $data = fread($myfile,filesize($fname));

   // $altname = fopen($altname, "r") or die("Unable to open file!");
   // $altdata = fread($altname,filesize($altname));

    fclose($myfile);
    return "<img src='".$data."' alt='loading...'/>";
  }

  $a = show_b64jpeg("hello.txt");
  echo $a;
?>
