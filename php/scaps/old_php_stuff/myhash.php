<?php
    /*function MyHash($input) {
      $input_size=strlen($input);
      $split_at=$input_size/2;*/
      //$result="";
      /*for ($i=0;$i<$input_size;$i++) {
        $result=$result.md5($input[$i]);
      }
      echo $input." ";*/

      /*$part1="";
      for ($i=0;$i<$split_at-1;$i++) {
        $part1=$part1.$input[$i];
      }
      $part2="";
      for ($i=$split_at;$i<$input_size;$i++) {
        $part2=$part2.$input[$i];
      }
      return md5(md5($part1).md5($part2));
    }*/
?>
<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; ?>

<!DOCTYPE html>

<html>
<head></head>
<body>
<p>
<?php
  echo MyHash("...");
?>
</p>
</body>
</html>
