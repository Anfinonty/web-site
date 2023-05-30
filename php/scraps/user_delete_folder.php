<!DOCTYPE html>
<html>
<head>
  <title>Delete Folder</title>
  <script>
    if ( window.history.replaceState ) { //prevent refresh n submit
        window.history.replaceState( null, null, window.location.href );
    }
  </script>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; ?>
  <h2>Create Folder</h2>

  <form method="post" id="form1">
    <input type="text" id="txthere" name="txthere" maxlength="128">
    <input type="submit" name="submit" value="Submit">
  </form>

  <?php
    if (isset($_POST['submit'])){
      $set_foldername=$_POST["txthere"];
      $user_ip_address=$_SERVER['REMOTE_ADDR'];
      if (mkdir($user_filename."/".$set_foldername,0777,true)) {
        echo "<br> File Deletion Successful! :D <br>";
      } else {
        echo "<br> File Creation Unsuccessful :( <br>";
      }
    }
    echo "<br><h3>Your Files</h3>";
    PrintDir($user_filename);
  ?>

</body>
</html>
