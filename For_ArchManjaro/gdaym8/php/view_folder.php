<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";?>

<?php
  //echo $_GET['target_folder'];
  if (!is_null($_GET['target_folder']) && !empty($_GET['target_folder'])) {
    //$target_folder="C:/Apache2.2/htdocs".$_GET['target_folder'];
    $target_folder="/var/www/html".$_GET['target_folder'];
    $target_folder=str_replace("../","--/",$target_folder);
    $target_folder=str_replace("..\\","--\\",$target_folder);
    $target_folder=str_replace("/..","/--",$target_folder);
    $target_folder=str_replace("\\..","\\--",$target_folder);

    #$target_main_folder="/var/www/html".$_GET['target_main_folder'];
    #$target_main_folder=str_replace("../","--/",$target_main_folder);
    #$target_main_folder=str_replace("..\\","--\\",$target_main_folder);
    #$target_main_folder=str_replace("/..","/--",$target_main_folder);
    #$target_main_folder=str_replace("\\..","\\--",$target_main_folder);
  }

  /*$page_height=100;
  if (!is_null($_GET['page_height'] && !empty($_GET['page_height'])) {
    $page_height=$_GET['page_height'];
  }*/
?>

<!DOCTYPE HTML>
<html>
<head>
<title>View Folder</title>
  <script>
    //document.getElementById("default_server_header").hidden=true;


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
<?php
  echo "<link rel='stylesheet' href='";
  if (file_exists($target_folder."/folder_style.css")) {
    echo $_GET['target_folder'];
  } else {
  /*if blank, fallback to <username>/folder_style.css*/
   $var_arr=explode("/",$_GET['target_folder']);
    echo "/".$var_arr[2];
  }
  echo "/folder_style.css'></link>";
?>


</head>
<body
  <?php
    $vtarget_folder=$_GET['target_folder'];
    $vtarget_folder=str_replace("/","_",$vtarget_folder);
    $vtarget_folder=str_replace("\\","_",$vtarget_folder);
    echo " id='view_folder".$vtarget_folder."'";
  ?>
>
  <div
  <?php
    echo "id='view_folder_background".$vtarget_folder."'";
  ?>
  ></div>
  <script src="<?php echo $_GET['target_folder'];?>/folder_script.js"></script>
  <div id="view_folder_header"></div>
  <!--<a href='#view_folder_footer'>Dive Down</a><br>-->
  <div height="200%"
<?php
   echo " id='view_subfolder".$vtarget_folder."'";
?>
  >
<?php

  //echo $target_folder;
  //if (is_dir($target_folder)) {http://spiderspeed.site:591/php/view_folder.php?target_folder=C:/Apache2.2/htdocs/global/
  PrintDir($target_folder,0,0);
  //}
  //}
?>
  </div>
  <div id="view_folder_footer"></div>
  <!--<a href='#view_folder_header'>Back To Surface</a><br>-->
</body>
</html>

