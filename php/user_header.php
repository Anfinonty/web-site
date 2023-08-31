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

    function MyHash2($input) {
      $input_size=strlen($input);
      $split_at=$input_size/2;
      $part1="";
      for ($i=0;$i<$split_at;$i++) {
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
    $USER_IP_ADDRESS = MyHash2($_SERVER['REMOTE_ADDR']);


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
	/**/$SAVED_DISCS_DIR=$GLOBAL_FOLDER."/{SavedDiscs}";
        /**/$SESSIONS_DIR=$GLOBAL_FOLDER."/{Sessions}";
              /**/$TOKEN_DIR=$SESSIONS_DIR."/token.txt";
              /**/$JUSERS_DIR=$SESSIONS_DIR."/joined_users.txt";
              /**/$SELF_USER_SESSION=$SESSIONS_DIR."/".$USER_IP_ADDRESS.".txt";


  //Protips
    $PROTIPS=array(
"Upload A index.html into your folder to set up your webpage.",
"Upload A style.css into your folder to change your Theme and Wallpaper.",
"Upload A chat_icon.jpg/png/gif into your folder to set your chat icon.",
"Upload A folder_icon.jpg/png/gif (1MB) into your folder to set your folder icon.",

//"This web-site's Minecraft Server goes by the same URL or IP Address.",
//"This web-site's Minecraft Server Address is: $SERVER_IP_ADDRESS",
"This web-site's Live Updates is faster on Private Browsing modes.",
"HTML Works in the Chat.",
"#i# [image/gif link] #_i# is a shortcut for embedding gifs or images.",
"#au# [audio link] #_au# is a shortcut for embedding audio.",
"If the page isn't updating properly, clear your cache.",
"Sound Effects are From www.fesliyanstudios.com.",
"WinXP Symlink by Masatoshi Kimura https://schinagl.priv.at/nt/hardlinkshellext/hardlinkshellext.html",
"This website supports both http:// and https://.",
"spider.bmp drawn by hoobsug.",
"Website pen-tested by clovis.",
"HTTPS assist by Professor8404 and y4my4m.",

//Misc
"OCT 8 2023 PENDULUM PERFORMS AT RAC ARENA - WA",

//Music ACDC
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/ACDC/Back%20in%20Black.wav'></audio> ACDC - Back In Black",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/ACDC/T.N.T..wav'></audio> ACDC - T.N.T.",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/ACDC/Thunderstruck.wav'></audio> ACDC - Thunderstruck",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/ACDC/Highway%20To%20Hell.wav'></audio> ACDC - Highway To Hell",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/ACDC/The%20Razor%27s%20Edge.wav'></audio> ACDC - The Razor's Edge",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/ACDC/You%20Shook%20Me%20All%20Night%20Long.wav'></audio> ACDC - You Shook Me All Night Long",

//Music Men At Work
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Men%20At%20Work/Who%20Can%20It%20Be%20Now.wav'></audio> Men At Work - Who Can It Be Now?",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Men%20At%20Work/Down%20Under.wav'></audio> Men At Work - Down Under",

//Music Pendulum
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/9,000%20Miles.wav'></audio> Pendulum - 9,000 Miles",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Blood%20Sugar.wav'></audio> Pendulum - Blood Sugar",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Fasten%20your%20Seatbelt.wav'></audio> Pendulum - Fasten Your Seatbelt",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Crush.wav'></audio> Pendulum - Crush",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Hold%20Your%20Colour.wav'></audio>",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Granite.wav'></audio> Pendulum - Granite",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Propane%20Nightmares.wav'></audio> Pendulum - Propane Nightmares",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Slam.wav'></audio> Pendulum - Slam",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Sounds%20of%20Life.wav'></audio> Pendulum - Sounds of Life",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/The%20Island%20-%20Pt.%201%20(Dawn).wav'></audio> Pendulum - The Island - Pt. 1 (Dawn)",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/The%20Island%20-%20Pt.%202%20(Dusk).wav'></audio> Pendulum - The Island - Pt. 2 (Dusk)",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/The%20Tempest.wav'></audio> Pendulum - The Tempest",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/The%20Vulture.wav'></audio> Pendulum - The Vulture",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Watercolour.wav'></audio> Pendulum - Watercolour",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Witchcraft.wav'></audio> Pendulum - Witchcraft",

//Music Wolfmother
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Wolfmother/Joker%20&%20The%20Thief.wav'></audio> Wolfmother - Joker & The Thief"
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
    $USER_SAVED_DISCS_DIR=$SAVED_DISCS_DIR."/".$SELF_USER_NAME;  
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
    mkdir($SAVED_DISCS_DIR,0777,true);
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
      global $SAVED_DISCS_DIR;
      global $SESSIONS_DIR;
      global $DVD_DIR;
      global $GLOBAL_FOLDER;
      $full_folder_directories="";
      $prev_div_id="";
      if ($folder!=$REG_USERS_DIR &&
	  $folder!=$REG_EMAILS_DIR &&
	  $folder!=$REG_Q_DIR &&
	  $folder!=$SAVED_DISCS_DIR &&
	  $folder!=$SESSIONS_DIR
	) {
        $a = scandir($folder);
        $dir_size=sizeof($a);
        if (is_dir($folder)) {
	  if ($type==0) {	  
	    //foldername
	    if ($n>0 || $n==-1) {
	      if ($n==-1) { //exception
	        echo "<script src='/script/toggletreeview.js'></script>";//call script on surface
	      }	

	      //for branch display
	      $tmp_folder_name=str_replace("C:/Apache2.2/htdocs/global/","",$folder);
	      $folder_name_arr=explode('/',$tmp_folder_name);
	      $folder_name=end($folder_name_arr);


	      //for href and div_id
	      $div_id=str_replace("C:/Apache2.2/htdocs","",$folder);
	      $div_id=str_replace(" ","%20",$div_id);
	      $div_id=str_replace("'","%27",$div_id);

	      echo "<div style='display:inline-table;' id='".$div_id."_button'>";
	      echo "<button class='folder_button' onclick=ToggleTreeView('".$div_id."')>";

	      //Draw folder button
              echo "<table class='folder_button'>";
	      echo "<tr>";
	      echo "<th rowspan='2' class='table_folder_icon'>";

	      //Draw Folder Icon branch
	      echo "<table style='display:none;' class='opened_folder_branch' id='".$div_id."_branch'>";
	      for ($j=0;$j<$n-1;$j++) { //for every previous folder
		echo "<tr><td>";
                for ($k=0;$k<$j;$k++) {echo "____";} //branch printing
                echo "|__→";
		echo "<u>".$folder_name_arr[$j]."</u></td></tr>";
	      }
	      echo "</table>";

	      //Draw folder icon image
	      for ($i=0;$i<7;$i++) {
		if ($i<6) {
		  $folder_icon_ext="";
		  switch ($i) {
		    case 0;
		      $folder_icon_ext="gif";
		      break;
		    case 1;
		      $folder_icon_ext="apng";
		      break;
		    case 2;
		      $folder_icon_ext="png";
		      break;
		    case 3;
		      $folder_icon_ext="jpg";
		      break;
		    case 4;
		      $folder_icon_ext="jpeg";
		      break;
		    case 5;
		      $folder_icon_ext="bmp";
		      break;
		  }
		  if (file_exists($folder."/folder_icon.".$folder_icon_ext)) {
		    if (filesize($folder."/folder_icon.".$folder_icon_ext)<1000000) {
                      echo "<img src='".$div_id."/folder_icon.".$folder_icon_ext."' class='special_folder_icon'></img></th>";
		      break;
		    }
		  }
	        } else { //default icon
                  echo "<img src='/images/folder.bmp' class='default_folder_icon'></img></th>";
		}
	      }

              echo "<td class='folder_name'>".$folder_name." <span class='folder_sub_name'>[<a href='".$div_id."'>visit</a>]</span></td>"; //print foldername
	        echo "</tr>";
	        echo "<tr class='folder_metadata'><td>";
	          echo " [".date("F/d/Y H:i:s",filectime($folder))."]";
                echo " (".GetConvertedFilesize(GetDirectorySize($folder)).")";
              echo "</td></tr>";
	      echo "</table>";
	      echo "</button>";
	      //end of button

	      if (file_exists($folder."/index.html")) {	      //only if index exists
              	echo "<div style='display:none;' id='".$div_id."_folder_tab'>";
	        echo "<iframe width='100%' height='100%' class='".$div_id."' id='https://gdaym8.site/".$div_id."/'></iframe>";
		echo "</div>";
	      } else {
		echo "<br>";
	      }

	      //print last branch
	      echo "<div class='showfiletree_branch' style='display:none;' id='".$div_id."_last_branch'>"; //start of final branch
	      echo "<span class='folder_sub_name'>";	      

              for ($j=0;$j<$n-1;$j++) {echo "____";} //branch printing
              echo "|<br>";
	      
              for ($j=0;$j<$n-1;$j++) {echo "____";} //branch printing
              echo "|__→</span>";
	      echo "[<a href='".$div_id."'>".$folder_name."</a>]{$S}{$S}";

	      //echo "[<a href='#default_server_header'>↑X</a>]{$S}{$S}";

	      echo "<br>";

              for ($j=0;$j<$n-1;$j++) {echo "____";} //branch printing		
	      echo "|</span>";
	      echo "<br>";
	      echo "</div>"; //end of final branch

	      echo "</div>";//end of folder div

	      if ($n==-1) { //exception
		$n=1;
	      }

	      //make full folder directories
	      for ($j=0;$j<$n;$j++) { //for every previous folder
		$tmp_div_id="/global";
		$full_folder_directories .= "<a href='#";
		for ($k=0;$k<$j+1;$k++) {
		  $tmp_subfolder_name=$folder_name_arr[$k];
		  $tmp_subfolder_name=str_replace(" ","%20",$tmp_subfolder_name);
	      	  $tmp_subfolder_name=str_replace("'","%27",$tmp_subfolder_name);
		  $tmp_div_id.="/".$tmp_subfolder_name;
		}
		if ($j==$n-2) {$prev_div_id=$tmp_div_id;}
		$full_folder_directories .= $tmp_div_id."_button'>";
                $full_folder_directories .= $folder_name_arr[$j];
		$full_folder_directories .= "</a>";
		if ($j>0) {
		  $full_folder_directories.="\\";
                } else {
		  $full_folder_directories.=":\\";
		}
	      }		    


	      echo "<div style='display:none;' id='".$div_id."'>"; //begin folder
	      echo "<div id='".$div_id."_header' style='display:none'>";//header
	      echo "<span id='".$div_id."_header_table' style='display:none'>";
		echo "<table class='folder_header_table'>";
		  echo "<td class='folder_header_part1'><button style='width:100%;'class='folder_button' onclick='location.href=\"#".$div_id."_footer_anchor\"'>Dive Down</button></td>";
		  echo "<td class='folder_header_part1'><button style='width:100%;' onclick=ToggleTreeView('".$div_id."')>Close Folder</button></td>";
		  echo "<td class='folder_header_part2'><div class='folder_full_dir'>{$full_folder_directories}</div></td>";
		  echo "<td class='folder_header_part3'>".$folder_name."</td>";
		  echo "<td class='folder_header_part4'>";
		    echo "<button style='width:100%' onclick=\"ToggleTreeView('".$div_id."');location.href='#".$prev_div_id."_header_table'\">←</button>";
		  echo "</td>";
		echo "</table>";
	      echo "</span>";
	      echo "</div>"; //end of header
	    } else { //files on surface are open
	      echo "<script src='/script/toggletreeview.js'></script>";//call script on surface
	      echo "<div id='".$div_id."'>"; //begin div, opened div	
	    } //end of if surface or non-surface
	  }// end of if type==0 beginning

	  //for each file & folder in folder
          for ($i=0;$i<$dir_size;$i++) {
	    if ($a[$i]!=="." && $a[$i]!=="..") {
              $a_f=$folder."/".$a[$i];
              switch ($type) {
                case -1: //Recursive removal of files
                  unlink($a_f);
                  break;
                case 0: // Printing files
	          //manual encoding
	          $href_filename=str_replace("C:/Apache2.2/htdocs","",$a_f);
	          $href_filename=str_replace(" ","%20",$href_filename);
	          $href_filename=str_replace("'","%27",$href_filename);
	          $file_extension=strtolower(end(explode('.',$a_f)));
	          $is_image=false;
	          $is_audio=false;
	          $is_video=false;
	          if (!is_dir($a_f) && $a_f!==$folder."/index.php" && $a_f!==$folder."/lechat.txt") { //its a file

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
		      $file_extension=="mov" ||
		      $file_extension=="webm" ||
		      $file_extension=="webp"
		    ) {
		      $is_video=true;
		    }
		    $a_f_size=filesize($a_f);

		    //--- image files ---
	            if ($is_image) {
		      echo "<table class='image_icon_main' style='display:inline-table;'>";
		      echo "<tr>";	  
		      echo "<th colspan='2' class='table_image'><img class='".$div_id." image_in_folder' id='".$href_filename."'></img></th>"; //show image
		      echo "</tr><tr>";
		      echo "<th rowspan='2' class='table_image_icon'>";
		      if (!($file_extension=="gif" || $file_extension=="apng")) {
	                echo "<img src='/images/".$file_extension.".bmp' class='file_icon'></img>"; //still image bmp			
		      } else {
	                echo "<img src='/images/".$file_extension.".gif' class='file_icon'></img>"; //moving image bmp
		      }
		      echo "</th>";
		      echo "<td class='a_file_name_cell'><div class='a_file_name'><a class='filename' href='".$href_filename."'>".$a[$i]."</a></div></td>";
		      echo "</tr>";
		      echo "<tr class='image_metadata'><td>";
		      if (filemtime($a_f)!=NULL) { 		//print date creation
		        echo "[".date("m/d/Y H:i:s",filectime($a_f))."]";
		      }
		      if ($a_f_size!=NULL) {		//print filesize
                        echo " ".GetConvertedFilesize($a_f_size);
		      }
		      echo "</td></tr>";
		      echo "</table>";

		    //--- video files ---
		    } else if ($is_video) {
		      echo "<table class='video_icon_main' style='display:inline-table;'>";
		      echo "<tr>";
		      echo "<th colspan='2' class='table_video'><video height='256px' width='auto' class='".$div_id."_video' controls><source type='video/".$file_extension."' class='".$div_id."' id='".$href_filename."'></video></th>";
		      echo "</tr><tr>";
		      echo "<th rowspan='2' class='table_video_icon'>";
	                echo "<img src='/images/".$file_extension.".bmp' class='file_icon'></img>"; //video bmp			
		      echo "</th>";
		      echo "<td class='a_file_name_cell'><div class='a_file_name'><a class='file_name' href='".$href_filename."'>".$a[$i]."</a></div></td>";
		      echo "</tr>";
		      echo "<tr class='video_metadata'><td>";
		      if (filemtime($a_f)!=NULL) { 		//print date creation
		        echo "[".date("m/d/Y H:i:s",filectime($a_f))."]";
		      }
		      if ($a_f_size!=NULL) {		//print filesize
                        echo " ".GetConvertedFilesize($a_f_size);
		      }
		      echo "</td></tr>";
		      echo "</table>";

		    //--- music files ---
		    } else if ($is_audio) { //display music
		      echo "<div class='music_row'>";
		      echo "<table class='music_icon_main'>";
		      echo "<tr>";
		        echo "<td rowspan='2' class='table_music_icon'>";
	                  echo "<img src='/images/".$file_extension.".bmp' class='file_icon'></img>"; //music bmp
		        echo "</td>";
		        echo "<td>";
		          echo "<a class='file_name' href='".$href_filename."'>".$a[$i]."</a>"; //music href
		      echo "</td></tr>";

		      echo "<tr class='music_metadata'><td>";
		      if (filemtime($a_f)!=NULL) { 		//print date creation
		        echo " [".date("m/d/Y H:i:s",filectime($a_f))."]";
		      }
		      if ($a_f_size!=NULL) {		//print filesize
                        echo " ".GetConvertedFilesize($a_f_size);
		      }
		      echo "</td></tr>";

		      echo "<tr><td></td>";
		      echo "<td class='music_player' colspan='2'>";                    
     		      echo "<audio controls class='".$div_id."_audio'><source type='audio/".$file_extension."' class='".$div_id."' id='".$href_filename."'></audio>";//music player
		      echo "</td></tr>";
		      echo "</table></div>";

		    //--- regular files ---
		    } else {
		      echo "<table class='file_icon_main' style='display:inline-table;'>";
		      echo "<tr>";
		      echo "<th colspan='2' class='regular_files_null'>{$S}</th>";
		      echo "</tr>";
		      echo "<tr>";
		        echo "<th rowspan='2' class='table_file_icon'><img src='/images/".$file_extension.".bmp' class='file_icon'></img></th>"; //normal file bmp
		        echo "<td class='a_file_name_cell'><div class='a_file_name'><a class='file_name' href='".$href_filename."'>".$a[$i]."</a></div></td>";
		      echo "</tr>";
		      echo "<tr class='file_metadata'><td>";
		      if (filemtime($a_f)!=NULL) { 		//print date creation
		        echo "[".date("m/d/Y H:i:s",filectime($a_f))."]";
		      }
		      if ($a_f_size!=NULL) {		//print filesize
                        echo " ".GetConvertedFilesize($a_f_size);
		      }
		      echo "</td></tr>";
		      echo "</table>";
		    }
	          } //end of if files
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
              } //end switch actions
	    } //end of . or ..
            PrintDir($a_f,$type,$n+1);
          } //end for loop, before loop is a div
	  if ($type==0) {
	    echo "</div>";
	    if ($folder!=$GLOBAL_FOLDER && $folder!=$DVD_DIR && $folder!=$DVD_DIR."/AVRIL_LAVIGNE") {
              echo "<span id='".$div_id."_footer' style='diplay:none;'>";
	      echo "<span id='".$div_id."_footer_table' style='display:none;'>"; //working
		echo "<table class='folder_footer_table'><tr>";
		  echo "<td class='folder_footer_part1'><button style='width:100%;'class='folder_button' onclick='location.href=\"#".$div_id."_header\"'>Back To Top</button></td>";
		  echo "<td class='folder_footer_part1'><button style='width:100%;' onclick=ToggleTreeView('".$div_id."')>Close Folder</button></td>";
		  echo "<td class='folder_footer_part2'><div class='folder_full_dir'>{$full_folder_directories}</div></td>";
		  echo "<td class='folder_footer_part3'>";
		    echo "<button style='width:100%' onclick=\"ToggleTreeView('".$div_id."');location.href='#".$prev_div_id."_header_table'\">←</button>";
		  echo "</td>";
		echo "</tr></table>";
	      echo "</span>";
	      echo "<div id='".$div_id."_footer_anchor' style='display:none;'>{$S}</div>";
	      echo "<div id='".$div_id."_footer_break' style='display:none'><div class='folder_footer_break'>{$S}</div><br><br><br></div>";
	      echo "</span>";
	    }
	  } //close div of folder
        }//end main, if is dir
      }//end if non-valid files
      if ($type==-1) {rmdir($folder);} //recursive remove folder
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
	 $tmp_username=GetUsernameFromIpAddress($session_user_ip_address);
	 PrintDir($SAVED_DISCS_DIR."/".$tmp_username,-1,0); //Delete folder from {SavedDiscs}
         //unlink($SAVED_DISCS_DIR."/WEB_SITE_DISC_".$tmp_username.".zip");
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
    }

    .a_file_name{
      /*max-width: 445px;*/
      max-width: 436px;
      white-space:nowrap;
      overflow-x:auto;
    }



    .special_folder_icon {
      height:64px;width:auto;
    }

    .default_folder_icon {
      width:32px;height:auto;
    }

    .folder_name {
      font-size:20px;
    }


    .folder_sub_name {
      font-size:16px;
    }

    .folder_header_table {
      border-style:solid;border-width:thick;width:100%;
    }

    .folder_header_part1 {
      width:16%;border-width:thin;border-style:solid;
    }

    .folder_header_part2 {
      width:33%;border-width:thin;border-style:solid;
    }

    .folder_header_part3 {
      width:30%;border-width:thin;border-style:solid;text-align:center;
    }

    .folder_header_part4 {
      width:3%;border-width:thin;border-style:solid;
    }

    .folder_full_dir {
      white-space:nowrap;overflow-x:auto;width:100%;
    }


    .image_in_folder {
      width:auto;height:256px;
    }

    .file_icon {
      width:32px;height:auto;
    }

    .file_name {
      font-size:20px;
    }

    .music_row {
      border: 2px solid;
      width:100%;
    }

    .regular_files_null {
      height:256px;
    }



    .folder_footer_table {
      border-style:solid;border-width:thick;width:100%;
    }

    .folder_footer_part1 {
      width:33%;border-width:thin;border-style:solid;
    }


    .folder_footer_part2 {
      width:30%;border-width:thin;border-style:solid;
    }

    .folder_footer_part3 {
      width:3%;border-width:thin;border-style:solid;
    }

    .folder_footer_break {
      border-width:thick;border-style:solid;
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
    echo '<script src="/script/dynamic_header.js"></script>';

    echo "</div>";
    //
    //
  ?>


