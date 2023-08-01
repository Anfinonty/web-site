  <?php

//
//
//
//Hashing
    function MyHash($input) {
      $input_size=strlen($input);
      $split_at=$input_size/2;
      $part1="";
      for ($i=0;$i<$split_at-1;$i++) {
        $part1=$part1.$input[$i];
      }
      $part2="";
      for ($i=$split_at;$i<$input_size;$i++) {
        $part2=$part2.$input[$i];
      }
      return md5(md5($part1).md5($part2));
    }
//
//
//
//
//
//Generate Random String
    function GenRandString($string_len) {
      $lechars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-!@#.*`";
      $lechars_len=strlen($lechars);
      $randString="";
      for ($i=0;$i<$string_len;$i++) {
	$randString.=$lechars[rand(0,($lechars_len-1))];
      }
      return $randString;
   }
//
//
//
//Fixed GLOBALS
    $SERVER_IP_ADDRESS=$_SERVER['HTTP_HOST'];
    $S="&nbsp";


//generate user_id
    $USER_IP_ADDRESS = MyHash($_SERVER['REMOTE_ADDR']);


    $CHAT_DIR="global/lechat.txt";
    $USER_MAX_FOLDER_NUM=10;

    $GR_WIDTH=640*5;
    $GR_HEIGHT=480*5;
    $CURSOR_GAP=8*4;

    $DVD_DIR=$_SERVER['DOCUMENT_ROOT']."/dvd";
    $GLOBAL_FOLDER=$_SERVER['DOCUMENT_ROOT']."/global";
        /**/$REG_USERS_DIR=$GLOBAL_FOLDER."/{RegisteredUsers}";
        /**/$REG_EMAILS_DIR=$GLOBAL_FOLDER."/{RegisteredEmails}";
        /**/$REG_Q_DIR=$GLOBAL_FOLDER."/{RegQ}";
        /**/$SESSIONS_DIR=$GLOBAL_FOLDER."/{Sessions}";
              /**/$TOKEN_DIR=$SESSIONS_DIR."/token.txt";
              /**/$JUSERS_DIR=$SESSIONS_DIR."/joined_users.txt";
              /**/$SELF_USER_SESSION=$SESSIONS_DIR."/".$USER_IP_ADDRESS.".txt";


  //Protips
    $PROTIPS=array(
"Upload A index.html into your folder to set up your webpage.",
"Upload A style.css into your folder to change your Theme and Wallpaper.",
"Upload A chat_icon.jpg/png/gif into your folder to set your chat icon.",

//"This web-site's Minecraft Server goes by the same URL or IP Address.",
//"This web-site's Minecraft Server Address is: $SERVER_IP_ADDRESS",
"This web-site's Live Updates is faster on Private Browsing modes.",
"HTML Works in the Chat.",
"#i# [image/gif link] #_i# is a shortcut for embedding gifs or images.",
"#au# [audio link] #_au# is a shortcut for embedding audio.",
"If the page isn't updating properly, clear your cache.",
"Sound Effects are From www.fesliyanstudios.com.",
"WinXP Symlink by Masatoshi Kimura https://schinagl.priv.at/nt/hardlinkshellext/hardlinkshellext.html",
"This website supports both http:// and https://."
);


  //Max Storage Per User
//    $MAX_STORAGE=10485760;
//    $MAX_STORAGE=104857600;
//    $MAX_STORAGE=36700160; //35MB
//    $MAX_STORAGE=1048576000; //1000MB
    $MAX_STORAGE=734003200; //700MB

//
//
//
    function GetUsernameFromIpAddress($_ip_address) {
      global $SESSIONS_DIR;
      $_user_session_filename=$SESSIONS_DIR."/".$_ip_address.".txt";
      if (file_exists($_user_session_filename)) {
        $user_session=htmlspecialchars(strval(file_get_contents($_user_session_filename)));
        $user_session_arr=explode(",",$user_session);
        $user_name=$user_session_arr[3];

        if ($user_name!=$_ip_address && $user_name!="") {
          return $user_name;
        }
      }
      //0= x, 1= y, 2=session expiry, 3=username
      return $_ip_address;
    }
//Dynamic GLOBALS
    $USER_TOTAL_FOLDER_NUM=0;
    $USER_FOLDERS_ARR=array();
    $USER_FILES_ARR=array();
    $RAND_TIP=rand(0,sizeof($PROTIPS)-1);
    $SELF_USER_NAME=GetUsernameFromIpAddress($USER_IP_ADDRESS);
    $SELF_USER_FOLDER_NAME=$GLOBAL_FOLDER."/".$SELF_USER_NAME;
//
//
//
//
//No Caching Attempts
    //https://www.php.net/manual/en/function.header.php
    //header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1.
    //header("Pragma: no-cache"); // HTTP 1.0.
    //header("Expires: 0"); // Proxies.

    //header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    //header("Cache-Control: post-check=0, pre-check=0", false);
    //header("Pragma: no-cache");

    //https://stackoverflow.com/questions/13640109/how-to-prevent-browser-cache-for-php-site
    //header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
    //header('Cache-Control: no-store, no-cache, must-revalidate');
    //header('Cache-Control: post-check=0, pre-check=0', FALSE);
    //header('Pragma: no-cache');

    //https://stackoverflow.com/questions/49547/how-do-we-control-web-page-caching-across-all-browsers 04/19/2023
    header("Cache-Control: no-cache, no-store, must-revalidate"); //HTTP 1.1
    header("Pragma: no-cache"); //HTTP 1.0
    header("Expires: 0"); //Proxies
//  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
//
//
//
//Debug: Create Folders
    mkdir($SESSIONS_DIR,0777,true);
    mkdir($REG_Q_DIR,0777,true);
    mkdir($REG_EMAILS_DIR,0777,true);
    mkdir($REG_USERS_DIR,0777,true);

//
//
//
//Useful File-folder FUNCTIONS
    function GetDirectorySize($path){
      $bytestotal = 0;
      $path = realpath($path);
      if($path!==false && $path!='' && file_exists($path)){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
          $bytestotal += $object->getSize();
        }
      }
      return $bytestotal;
    }

    function GetConvertedFilesize($f_size) {
      $nf_size=$f_size."b";
      if ("1024"<$f_size && $f_size<"1048576") {
        $nf_size=round($f_size/"1024",3)."k";
      } else if ($f_size>"1048576") {
        $nf_size=round($f_size/"1048576",3)."M";
      }
      return $nf_size;
    }

    function PrintDir($folder,$type,$n) {
      global $S;
      global $USER_TOTAL_FOLDER_NUM;
      global $USER_FOLDERS_ARR;
      global $USER_FILES_ARR;
      global $SELF_USER_FOLDER_NAME;
      global $REG_USERS_DIR;
      global $REG_EMAILS_DIR;
      global $REG_Q_DIR;
      global $SESSIONS_DIR;
      global $DVD_DIR;
      if ($folder!=$REG_USERS_DIR &&
	  $folder!=$REG_EMAILS_DIR &&
	  $folder!=$REG_Q_DIR &&
	  $folder!=$SESSIONS_DIR
	) {
      $a = scandir($folder);
      $dir_size=sizeof($a);
      if ($dir_size>2) {
        if ($type==0) {
	  if ($n>0) {
	    if ($folder!=$DVD_DIR."/AVRIL_LAVIGNE") {
              echo "<details><summary>";
	    } else {
              echo "<details open><summary>";
	    }
	  } else {
            echo "<details open><summary>";
	  }
          for ($j=0;$j<$n;$j++) {echo "___";}
          echo"|</summary>";
        }
        for ($i=2;$i<$dir_size;$i++) {
          $a_f=$folder."/".$a[$i];
          switch ($type) {
            case -1: //Recursive removal of files
              unlink($a_f);
              break;
            case 0: // Printing
	      //echo str_replace("C:/Apache2.2/htdocs","",$a_f);
	      //manual encoding
	      $href_filename=str_replace("C:/Apache2.2/htdocs","",$a_f);
	      $href_filename=str_replace(" ","%20",$href_filename);
	      $href_filename=str_replace("'","%27",$href_filename);
	      $file_extension=strtolower(end(explode('.',$a_f)));
	      $is_image=false;
	      $is_audio=false;
	      $is_video=false;
	      if (!is_dir($a_f)) { //its a file
		//determiine file type
		if ($file_extension=="png" ||
		    $file_extension=="jpg" ||
		    $file_extension=="jpeg" ||
		    $file_extension=="apng" ||
		    $file_extension=="bmp" ||
		    $file_extension=="gif") {
		  $is_image=true;
		} else if (
		  $file_extension=="mp3" ||
		  $file_extension=="ogg" ||
		  $file_extension=="flac" ||
		  $file_extension=="wav"
		) {
		  $is_audio=true;
		} else if (
		  $file_extension=="mp4" ||
		  $file_extension=="mk4" ||
		  $file_extension=="mov"
		) {
		  $is_video=true;
		}
		$a_f_size=filesize($a_f);

		//--- image files ---
	        if ($is_image) {
		  echo "<table class='image_icon_main' style='display:inline-table;'>";
		  echo "<tr>";	  
		    echo "<th class='table_image_icon'><img src='".$href_filename."' style='width:256px;height:auto;'></img></th>";
		  echo "</tr><tr>";	  	
		    echo "<td><a style='font-size:20px;' href='".$href_filename."'>".$a[$i]."</a></td>";
		  echo "</tr>";
		  echo "<tr class='image_metadata'><td>";
		    if (filemtime($a_f)!=NULL) { 		//print date creation
		      echo "[".date("m/d/Y H:i:s",filectime($a_f))."]";
		    }
		    if ($a_f_size!=NULL) {		//print filesize
                      echo "[".GetConvertedFilesize($a_f_size)."]"." ";
		    }
		  echo "</td></tr>";
		  echo "</table>";

		//--- video files ---
		} else if ($is_video) {
		  echo "<table class='video_icon_main' style='display:inline-table;'>";
		  echo "<tr>";	  
		    echo "<th class='table_video_icon'><video width='256px' height='auto' controls><source type='video/".$file_extension."' src='".$href_filename."'></video></th>";
		  echo "</tr><tr>";	  	
		    echo "<td><a style='font-size:20px;' href='".$href_filename."'>".$a[$i]."</a></td>";
		  echo "</tr>";
		  echo "<tr class='video_metadata'><td>";
		    if (filemtime($a_f)!=NULL) { 		//print date creation
		      echo "[".date("m/d/Y H:i:s",filectime($a_f))."]";
		    }
		    if ($a_f_size!=NULL) {		//print filesize
                      echo "[".GetConvertedFilesize($a_f_size)."]"." ";
		    }
		  echo "</td></tr>";
		  echo "</table>";

		//--- music files ---
		} else if ($is_audio) { //display music
		  echo "<table class='music_icon_main'>";
		  echo "<tr>";
		    echo "<td rowspan='2' class='table_music_icon'>";
                      for ($j=0;$j<$n;$j++) {echo "___";} //audio branch printing
		      echo "__→";
	              echo "<img src='/images/".$file_extension.".bmp' style='width:32px;height:auto;'></img>"; //music bmp		    
		    echo "</td>";
		    echo "<td>";
		      echo "<a style='font-size:20px;' href='".$href_filename."'>".$a[$i]."</a>"; //music href
		  echo "</td></tr>";

		  echo "<tr class='music_metadata'><td>";
		    if (filemtime($a_f)!=NULL) { 		//print date creation
		      echo " [".date("m/d/Y H:i:s",filectime($a_f))."]";
		    }
		    if ($a_f_size!=NULL) {		//print filesize
                      echo " ".GetConvertedFilesize($a_f_size)." ";
		    }
		  echo "</td></tr>";

		  echo "<tr><td class='music_player' colspan='2'>";
                    for ($j=0;$j<$n;$j++) {echo "___";} //audio blank branch printing
		    echo "__→";
     		    echo"<audio controls><source type='audio/".$file_extension."' src='".$href_filename."'></audio>";//music player
		  echo "</td></tr>";
		  echo "</table>";

		//--- regular files ---
		} else {
		  echo "<table class='file_icon_main' style='display:inline-table;'>";
		  echo "<tr>";
		    echo "<th rowspan='2' class='table_file_icon'><img src='/images/".$file_extension.".bmp' style='width:32px;height:auto;'></img></th>"; //normal file bmp
		    echo "<td><a style='font-size:20px;' href='".$href_filename."'>".$a[$i]."</a></td>";
		  echo "</tr>";
		  echo "<tr class='file_metadata'><td>";
		    if (filemtime($a_f)!=NULL) { 		//print date creation
		      echo "[".date("m/d/Y H:i:s",filectime($a_f))."]";
		    }
		    if ($a_f_size!=NULL) {		//print filesize
                      echo "[".GetConvertedFilesize($a_f_size)."]"." ";
		    }
		  echo "</td></tr>";
		  echo "</table>";
		  //if ($i-2%3==0) {
		    //echo "<br>";
		  //}
		}
	      } else {//its a folder
		//echo "<br>";
		echo "<table class='folder_icon_main'>";
		echo "<tr>";
		  echo "<th rowspan='2' class='table_folder_icon'>";
                  for ($j=0;$j<$n;$j++) {echo "___";} //print branch
                  echo "__→";
		  echo "<img src='/images/folder.bmp' style='width:32px;height:auto;'></img></th>";
                  echo "<td><a style='font-size:20px;' href='".$href_filename."'>".$a[$i]."</a></td>";
		echo "</tr>";
		echo "<tr class='folder_metadata'><td>";
		  echo " [".date("F/d/Y H:i:s",filectime($a_f))."]";
                  echo " (".GetConvertedFilesize(GetDirectorySize($a_f)).")";
		echo "</td></tr>";
		echo "</table>";
	      }
              break;
            case 1: //Count Folders
              if (is_dir($a_f)) {$USER_TOTAL_FOLDER_NUM++;}
              break;
            case 10:
              if (is_dir($a_f)) {array_push($USER_FOLDERS_ARR,str_replace($SELF_USER_FOLDER_NAME,"",$a_f));}
              break;
            case 11:
              if (!is_dir($a_f)) {array_push($USER_FILES_ARR,str_replace($SELF_USER_FOLDER_NAME,"",$a_f));}
              break;
          }
          PrintDir($a_f,$type,$n+1);
        }
        if ($type==0){echo "</details>";}        
      }}
      if ($type==-1) {rmdir($folder);}
    }
//
//
//
//Chat Filter Funnctions
    function ChatShortcuts($txt) {
      //$_t = htmlspecialchars($txt);
      $_t=$txt;
      $r1="\#[Ii]\#";
      $r2="\#\_[Ii]\#";
      $_t = preg_replace("/{$r1}/i","<img src='",$_t);
      $_t = preg_replace("/{$r2}/i","'>",$_t);

      $au1="\#[Aa][Uu]\#";
      $au2="\#\_[Aa][Uu]\#";
      $_t = preg_replace("/{$au1}/i","<audio controls><source src='",$_t);
      $_t = preg_replace("/{$au2}/i","'></audio>",$_t);

      return $_t;
    }    

    function TheFilter($txt) {
        $_t = htmlspecialchars($txt);        
	$regex_php="[Pp][Hh][Pp]";
        $_t = preg_replace("/{$regex_php}/i",")hp",$_t);
        $regex_meta="[mM][eE][Tt][Aa]";
        $_t = preg_replace("/{$regex_meta}/i","m3ta",$_t);

        $regex_data="[dD][Aa][Tt][Aa]";
        $_t = preg_replace("/{$regex_data}/i","d@ta",$_t);
       
        $regex_script="[Ss][Cc][Rr][Ii][Pp][Tt]";
        $_t = preg_replace("/{$regex_script}/i","\$cript",$_t);

        $regex_xss="[Xx][Ss]{2}";
        $_t = preg_replace("/{$regex_xss}/i","X_x",$_t);

        $regex_cookie="[Cc][Oo]{2}[Kk][Ii][Ee]";
        $_t = preg_replace("/{$regex_cookie}/i","c00kie",$_t);
        
        $regex_java="[jJ][Aa][Vv][Aa]";
        $_t = preg_replace("/{$regex_java}/i","j@va",$_t);

        $regex_onerror="[Oo][Nn][Ee][Rr]{2}[Oo][Rr]";
        $_t = preg_replace("/{$regex_onerror}/i","0n3rr0r",$_t);

        $regex_onload="[Oo][Nn][Ll][Oo][Aa]";
        $_t = preg_replace("/{$regex_onload}/i","0nl0a",$_t);

        $regex_onproperty="[Oo][Nn][Pp][Rr][Oo][Pp][Ee][Rr][Tt][Yy]";
        $_t = preg_replace("/{$regex_onproperty}/i","0npr0perty",$_t);

        $regex_statechange="[Ss][Tt][Aa][Tt][Ee][Cc][Hh][Aa][Nn][Gg][Ee]";
        $_t = preg_replace("/{$regex_statechange}/i","_st@techange",$_t);
        $regex_marquee="[Mm][Aa][Rr][Qq][Uu][Ee]{2}";
        $_t = preg_replace("/{$regex_marquee}/i","m@rquee",$_t);
        $regex_svg="[Ss][Vv][Gg]";
        $_t = preg_replace("/{$regex_svg}/i","$vg",$_t);

        $_t = str_replace("\\/>","XD",$_t); //Wrong End Sharp Bracket
        $_t = str_replace("\\u","XD",$_t); //Encoding Char
        $_t = str_replace("\\U","XD",$_t);
        $_t = str_replace("\&\#","XD",$_t); //Encoding Char
        $_t = str_replace("%28","X_x",$_t);            //"(" in an encoded

        return $_t;
    }

//
//
//
//SESSION
    //Token for shared files
    function TokenAvailable() {
      global $TOKEN_DIR;
      if (file_exists($TOKEN_DIR)) {return true;}
      return false;
    }

    function TakeToken() {
      global $TOKEN_DIR;
      unlink($TOKEN_DIR);
    }

    function PutBackToken() {
      global $TOKEN_DIR;
      $fp=fopen($TOKEN_DIR,"w");
      fwrite($fp,"...");
      fclose($fp);
    }

    function WriteUpdatedSharedTxt($_dir,$_txt) {
      if (TokenAvailable()) {
        TakeToken();
        $fp=fopen($_dir,"w");
        fwrite($fp,$_txt);
        fclose($fp);
        PutBackToken();
      }
    }

//Action for ALL USERS on join
//
//
  //Delete Expired users
   $session_files=scandir($SESSIONS_DIR);
   $juser_txt="";
   for ($i=0;$i<sizeof($session_files);$i++) {
     $session_file_name=$session_files[$i];
     if ($session_file_name!="token.txt" && $session_file_name!="joined_users.txt" && $session_file_name!="." && $session_file_name!="..") {
       $session_user_ip_address=str_replace(".txt","",$session_file_name);
       $file_content=htmlspecialchars(strval(file_get_contents($SESSIONS_DIR."/".$session_file_name)));
       $file_content_arr=explode(",",$file_content);
       $session_user_expiry_time=$file_content_arr[2];      
       if (time()>$session_user_expiry_time) {//Delete expired session user
         unlink($GLOBAL_FOLDER."/WEB_SITE_DISC_".GetUsernameFromIpAddress($session_user_ip_address).".zip");
         //PrintDir($GLOBAL_FOLDER."/".GetUsernameFromIpAddress($session_user_ip_address),-1,0);//autoeject - legacy
         unlink($SESSIONS_DIR."/".$session_file_name);
       } else {
         $juser_txt=$juser_txt.$session_user_ip_address."#".GetUsernameFromIpAddress($session_user_ip_address).",";
       }
     }
   }
   WriteUpdatedSharedTxt($JUSERS_DIR,$juser_txt);
//
//
   //Brand new user based on ip,append to list
   if (!in_array($USER_IP_ADDRESS.".txt",$session_files)) { 
     if (TokenAvailable()) {//append
        TakeToken();
        $fp=fopen($JUSERS_DIR,"a");
        fwrite($fp,$USER_IP_ADDRESS."#".$SELF_USER_NAME.",");
        fclose($fp);
        PutBackToken();
      }//Write in /SESSIONS/ Folder
      $short_time_expire=time()+"40"; //40 seconds
      $fp=fopen($SELF_USER_SESSION,"w");
      fwrite($fp,"0,0,".$short_time_expire.",".$USER_IP_ADDRESS);
      fclose($fp);
   }
//
//
//
//HTML
    //Style
    //Includes user's style'
    echo "
  <style>
    #showfiletree {
      border:2px solid;
      overflow-y: auto;
      max-height: 480px;
    }
  </style>";
    echo "<link rel='stylesheet' href='/global/".$SELF_USER_NAME."/style.css'>";
//
//
//
    //remove self .zip
    $self_zip=$GLOBAL_FOLDER."/WEB_SITE_DISC_".$SELF_USER_NAME.".zip";
    if (file_exists($self_zip)) {unlink($self_zip);}
//
//
//
    //Header For navigation
    echo "<div id='default_server_header'>";
    echo "<a class='default_server_header_txt' href='/'>{$S}@{$S}</a>{$S}";
    echo "<a class='default_server_header_txt' href='/global'>{$S}View Site Content{$S}</a>{$S}";
    if (file_exists($SELF_USER_FOLDER_NAME)) {//User is logged in
      echo "<a class='default_server_header_txt' href='/php/user_act_folder.php'>{$S}Disc Management{$S}</a>{$S}";
      echo "<a class='default_server_header_txt' href='/global/".$SELF_USER_NAME."'>{$S}".$SELF_USER_NAME."{$S}</a>{$S}";
      if (GetDirectorySize($SELF_USER_FOLDER_NAME)>0) {
        echo "<a class='default_server_header_txt' href='/php/save_disc.php'>{$S}Save Disc{$S}</a>{$S}";
      }
      echo "<a class='default_server_header_txt' href='/php/are_you_sure.php'>{$S}Log Out{$S}</a>{$S}";

    } else { //not logged in:

      //echo "<a class='default_server_header_txt' href='/php/insert_disc.php'>{$S}Insert Disc{$S}</a>{$S}"; //legacy
      echo "<a class='default_server_header_txt' href='/php/user_login.php'>{$S}Login{$S}</a>{$S}";
      echo "<a class='default_server_header_txt' href='/php/user_registration.php'>{$S}Get Code{$S}</a>{$S}";
      echo "<a class='default_server_header_txt' href='/php/user_registration2.php'>{$S}Register{$S}</a>{$S}";
    }
    $user_details=htmlspecialchars(strval(file_get_contents($SELF_USER_SESSION)));
    $user_details_arr=explode(",",$user_details);
    $user_time_expiry=$user_details_arr[2];

    echo "<a href='/php/recharge.php' id='session_limit'></a>";
    echo "<span id='user_session_expiry' hidden>{$user_time_expiry}</span>";

    echo "{$S}<span id='self_ip'>{$S}u:$USER_IP_ADDRESS{$S}</span>{$S}";

    //echo "{$S}<span id='timeUTC' style='display:inline'></span>{$S}";

    echo "{$S}<span id='timeUser' style='display:inline'></span>{$S}";

    echo "<br><div id='random_tips' style='display:inline;'>~{$S}".$PROTIPS[$RAND_TIP]."{$S}~</div>";

    echo "</div>";
    echo '<script src="/script/dynamic_header.js"></script>';
    //
    //
  ?>


