<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";?>

<?php
  //echo $_GET['target_folder'];  
  if (!is_null($_GET['target_folder']) && !empty($_GET['target_folder'])) {
    $target_folder="C:/Apache2.2/htdocs".$_GET['target_folder'];
    $target_folder=str_replace("../","--/",$target_folder);
    $target_folder=str_replace("..\\","--\\",$target_folder);
    $target_folder=str_replace("/..","/--",$target_folder);
    $target_folder=str_replace("\\..","\\--",$target_folder);
  }
?>

<!DOCTYPE HTML>
<html>
<head>
<title>View Folder</title>
  <script> 
    document.getElementById("default_server_header").hidden=true;


    //function alert() {}

    /*
    function DisableAlerts() {
     frames=document.getElementsByTagName("iframe");
      for (i=0;i<frames.length;i++) {
        frames[i].contentWindow.alert = function(){}
        frames[i].classList.add("an_iframe");
      }
    }

    DisableAlerts();*/

  </script>
  <link rel="stylesheet" href="<?php echo $_GET['target_folder'];?>/folder_style.css"></link>
</head>
<body> 
  <script src="<?php echo $_GET['target_folder'];?>/folder_script.js"></script>
  <div id="view_folder_header"></div>
  <!--<a href='#view_folder_footer'>Dive Down</a><br>-->


<?php

  //echo $target_folder;
  //if (is_dir($target_folder)) {http://gdaym8.site:591/php/view_folder.php?target_folder=C:/Apache2.2/htdocs/global/
    PrintDir($target_folder,0,0);
  //}
  //}
?>
  <div id="view_folder_footer"></div>
  <!--<a href='#view_folder_header'>Back To Surface</a><br>-->
</body>
</html>

