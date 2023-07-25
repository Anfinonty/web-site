<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; ?>

<!DOCTYPE HTML>
<html>
<head>
<title>Are you sure?</title>
  <style>
    body {
      text-align: center;
    }
  </style>
  <script> 
    document.getElementById("default_server_header").hidden=true;
  </script>
</head>
<body>
<h1>Are you sure you want to Eject and Log Out?</h1>
<h2>All unsaved progress will be lost.</h2>
<a href="user_act_folder.php">&nbspBack&nbsp</a>&nbsp
<a href="save_disc.php">&nbspSave&nbsp</a>&nbsp
<a href="eject_disc.php">&nbspEject&nbsp</a>
</body>
</html>

