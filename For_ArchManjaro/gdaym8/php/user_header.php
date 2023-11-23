  <?php
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
  session_start();
  if (!$_SESSION["username"]) { // no username
    $_SESSION["username"]= "M8*".GenRandString(6);
  }
//
//
//
//Fixed GLOBALS
    $SERVER_IP_ADDRESS=$_SERVER['HTTP_HOST'];
    $S="&nbsp";


//generate user_id
    //$CHAT_DIR="global/lechat.txt";
    $USER_MAX_FOLDER_NUM=10;

    $GR_WIDTH=640*5;
    $GR_HEIGHT=480*5;
    $CURSOR_GAP=8*4;

    $DVD_DIR=$_SERVER['DOCUMENT_ROOT']."/dvd";
    $GLOBAL_FOLDER=$_SERVER['DOCUMENT_ROOT']."/global";
        /**/$GLOBAL_CHAT_DIR=$GLOBAL_FOLDER."/{GlobalChat}";
	/**/$SAVED_DISCS_DIR=$GLOBAL_FOLDER."/{SavedDiscs}";


  //Protips
    $PROTIPS=array(
"Upload A index.html into your folder to set up your webpage.",
"Upload A style.css into your folder to change your Theme and Wallpaper.",
"Upload A chat_icon.jpg/png/gif into your folder to set your chat icon.",
"Upload A folder_icon.jpg/png/gif (1MB) into your folder to set your folder icon.",
"Upload A folder_style.css to style your folder",
"Upload A folder_script.js to make your folder perform script actions",

"Minecraft Server 1.8.9: gdaym8.site",
"Minecraft Server c0.30: gdaym8.site:25564",
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
"Website Phone Number: +61 8 6186 9573",

//Misc
//"OCT 8 2023 PENDULUM PERFORMS AT RAC ARENA - WA",

//Music ACDC
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/ACDC/Back%20in%20Black.wav'></audio> ACDC - Back In Black",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/ACDC/T.N.T..wav'></audio> ACDC - T.N.T.",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/ACDC/Thunderstruck.wav'></audio> ACDC - Thunderstruck",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/ACDC/Highway%20To%20Hell.wav'></audio> ACDC - Highway To Hell",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/ACDC/The%20Razor%27s%20Edge.wav'></audio> ACDC - The Razor's Edge",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/ACDC/You%20Shook%20Me%20All%20Night%20Long.wav'></audio> ACDC - You Shook Me All Night Long",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/ACDC/Dirty%20Deeds%20Done%20Dirt%20Cheap.wav'></audio> ACDC - Dirty Deeds Done Dirt Cheap",

//Music Men At Work
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Men%20At%20Work/Who%20Can%20It%20Be%20Now.wav'></audio> Men At Work - Who Can It Be Now?",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Men%20At%20Work/Down%20Under.wav'></audio> Men At Work - Down Under",

//Music Pendulum
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/9,000%20Miles.wav'></audio> Pendulum - 9,000 Miles",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Blood%20Sugar.wav'></audio> Pendulum - Blood Sugar",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Fasten%20your%20Seatbelt.wav'></audio> Pendulum - Fasten Your Seatbelt",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Crush.wav'></audio> Pendulum - Crush",
"<img src='/images/wav.bmp'></img><audio controls><source type='audio/wav' src='/audio/Music/Pendulum/Hold%20Your%20Colour.wav'></audio> Pendulum - Hold Your Colour",
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

//Dynamic GLOBALS
    $USER_TOTAL_FOLDER_NUM=0;
    $USER_FOLDERS_ARR=array();
    $USER_FILES_ARR=array();
    $RAND_TIP=rand(0,sizeof($PROTIPS)-1);
    $SESSION_USERNAME = $_SESSION["username"];
    $SELF_USER_NAME=$SESSION_USERNAME;
    $SELF_USER_FOLDER_NAME=$GLOBAL_FOLDER."/".$SELF_USER_NAME;
    $USER_SAVED_DISCS_DIR=$SAVED_DISCS_DIR."/".$SELF_USER_NAME; 
//
//Debug: Create Folders
    //mkdir($GLOBAL_CHAT_DIR,0777,true);
    //mkdir($SESSIONS_DIR,0777,true);
    //mkdir($REG_Q_DIR,0777,true);
    //mkdir($REG_EMAILS_DIR,0777,true);
    //mkdir($REG_USERS_DIR,0777,true);
    //mkdir($SAVED_DISCS_DIR,0755,true);
//
//
//
    if (is_dir($SELF_USER_FOLDER_NAME)) {
      symlink($SELF_USER_FOLDER_NAME,$_SERVER['DOCUMENT_ROOT']."/".$SESSION_USERNAME);
    }
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
      global $DVD_DIR;
      global $GLOBAL_FOLDER;

      $hidden_folders_arr=array($REG_USERS_DIR, $REG_EMAILS_DIR, $REG_Q_DIR, $SAVED_DISCS_DIR);
      $dvd_folders_arr=array($DVD_DIR."/COOL_SONGS_COLLECTION/Brand New",
			 $DVD_DIR."/COOL_SONGS_COLLECTION/Evanescence",
			 $DVD_DIR."/COOL_SONGS_COLLECTION/Linkin Park",
			 $DVD_DIR."/COOL_SONGS_COLLECTION/Saosin");
      $full_folder_directories="";
      $prev_div_id="";

      if (!in_array($folder,$hidden_folders_arr)) {
        $a = scandir($folder);
        $dir_size=sizeof($a);
        if (is_dir($folder)) {
	  if ($type==0) {
            if (file_exists($folder."/index.html")) {	      //only if index exists
//	      $folder_username=str_replace("C:/Apache2.2/htdocs","",$folder);
              $folder_username=str_replace("/var/www/html","",$folder);
              echo "<div id='".$folder_username."_folder_tab'>";

	      //echo "<iframe width='100%' height='100%' class='".$folder_username."' src='https://gdaym8.site:592/".$folder_username."/'></iframe>";
	      //echo "<iframe width='100%' height='100%' class='".$folder_username."' src='https://gdaym8.site/".$folder_username."/'></iframe>";
	      echo "<iframe width='100%' id='".$folder_username."_index_' height='100%' class='".$folder_username."' src='https://gdaym8.site/".$folder_username."/'></iframe>";
	      echo "</div><br>";
      	    }
	    echo "<script src='/script/toggletreeview.js'></script>";
	  }
	  //for each file & folder in folder
          for ($i=0;$i<$dir_size;$i++) {
	    if ($a[$i]!=="." && $a[$i]!=="..") {
              $a_f=$folder."/".$a[$i];
              switch ($type) {
                case -1: //Recursive removal of files
                  unlink($a_f);
                  break;
                case 0: // Printing files
	          //for href and div_id
//	          $div_id=str_replace("C:/Apache2.2/htdocs","",$a_f);
		  $div_id=str_replace("/var/www/html","",$a_f);
	          $div_id=str_replace(" ","%20",$div_id);
	          $div_id=str_replace("'","%27",$div_id);
	
	          //manual encoding
//	          $href_filename=str_replace("C:/Apache2.2/htdocs","",$a_f);
		  $href_filename=str_replace("/var/www/html","",$a_f);
	          $href_filename=str_replace(" ","%20",$href_filename);
	          $href_filename=str_replace("'","%27",$href_filename);
	          $file_extension=strtolower(end(explode('.',$a_f)));
	          $is_image=false;
	          $is_audio=false;
	          $is_video=false;

		  //is a folder in dvd folder
		  $is_folder_in_dvd_folder=false;
		  if (in_array($a_f,$dvd_folders_arr)) {
		    $is_folder_in_dvd_folder=true;
		  }
		
	          if (!$is_folder_in_dvd_folder &&
			(!is_dir($a_f) && 
			 $a_f!==$folder."/index.php" && 
			 $a_f!==$folder."/old_index.php" && 
			 $a_f!==$folder."/lechat.txt")
		     ) { //its a file

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
		      echo "<th colspan='2' class='table_image'><img class='".$div_id." image_in_folder' id='".$href_filename."' src='".$href_filename."'></img></th>"; //show image
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
		      echo "<th colspan='2' class='table_video'><video height='256px' width='auto' class='".$div_id."_video' controls><source type='video/".$file_extension."' class='".$div_id."' id='".$href_filename."' src='".$href_filename."'></video></th>";
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
     		      echo "<audio controls class='".$div_id."_audio'><source type='audio/".$file_extension."' class='".$div_id."' id='".$href_filename."' src='".$href_filename."'></audio>";//music player
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
	          } else if (
		      $is_folder_in_dvd_folder ||
		      (is_dir($a_f) && !in_array($a_f,$hidden_folders_arr))
		      )
		  { //end of if files else, if its a folder
	          ////Folder		
	          //for branch display
	            $tmp_folder_name=str_replace("\\","/",$a_f);
                    $tmp_folder_name_len=strlen($tmp_folder_name);

	            //$tmp_folder_name=str_replace("C:/Apache2.2/htdocs/global/","",$tmp_folder_name);
		    $tmp_folder_name=str_replace("/var/www/html/global/","",$tmp_folder_name);
	            $is_dvd_folder=false;
	            if (strlen($tmp_folder_name)==$tmp_folder_name_len) {
	              //$tmp_folder_name=str_replace("C:/Apache2.2/htdocs/dvd/","",$tmp_folder_name);
		      $tmp_folder_name=str_replace("/var/www/html/dvd/","",$tmp_folder_name);
		      $is_dvd_folder=true;
	            }
	            $folder_name_arr=explode('/',$tmp_folder_name);
	            $folder_name=end($folder_name_arr);


	            echo "<div style='display:inline-table;' id='".$div_id."_button'>";
		    if (!$is_dvd_folder) {
	              echo "<button class='folder_button' onclick='ToggleTreeView(\"" .$div_id. "\");location.href=\"#". $i ."_button\";'>";
		    } else {
	              echo "<button class='folder_button' onclick='ToggleTreeView(\"" .$div_id. "\");location.href=\"#". $i ."_dvd_button\";'>";
		    }

	            //Draw folder button
                    echo "<table class='folder_button'>";
	            echo "<tr>";
	            echo "<th rowspan='2' class='table_folder_icon'>";

		//make full folder directories
	            $full_folder_directories="";
	            for ($j=0;$j<count($folder_name_arr);$j++) { //for every previous folder
		      if (!$is_dvd_folder) {
		        $tmp_div_id="/global";
		      } else {
		        $tmp_div_id="/dvd";
		      }
		      //$full_folder_directories .= "<a href='https://gdaym8.site:592/php/view_folder.php?target_folder=";

		      //$full_folder_directories .= "<a href='https://gdaym8.site:592/";
		      $full_folder_directories .= "<a href='https://gdaym8.site/";

		      for ($k=0;$k<$j+1;$k++) {
		        $tmp_subfolder_name=$folder_name_arr[$k];
		        $tmp_subfolder_name=str_replace(" ","%20",$tmp_subfolder_name);
	      	        $tmp_subfolder_name=str_replace("'","%27",$tmp_subfolder_name);
		        $tmp_div_id.="/".$tmp_subfolder_name;
		      }
		      if ($j==$n-2) {$prev_div_id=$tmp_div_id;}
			//$full_folder_directories .= $tmp_div_id."_button'>";
		      $full_folder_directories .= $tmp_div_id."'>";
                      $full_folder_directories .= $folder_name_arr[$j];
		      $full_folder_directories .= "</a>";
		      if ($j>0) {
		        $full_folder_directories.="\\";
                      } else {
		        $full_folder_directories.=":\\";
		      }
	            }


	      	//Draw Folder Icon branch
	            echo "<table style='display:none;' class='opened_folder_branch' id='".$div_id."_branch'>";
	            echo "</table>";	

	      	//Draw folder icon image
	            for ($z=0;$z<7;$z++) {
		      if ($z<6) {
		        $folder_icon_ext="";
		        switch ($z) {
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
		        if (file_exists($a_f."/folder_icon.".$folder_icon_ext)) {
		          if (filesize($a_f."/folder_icon.".$folder_icon_ext)<1000000) { //allow if below 100mb 
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
	                echo " [".date("F/d/Y H:i:s",filectime($a_f))."]";
                      echo " (".GetConvertedFilesize(GetDirectorySize($a_f)).")";
                    echo "</td></tr>";
	            echo "</table>";
	            echo "</button>";
	            echo "</div>";
//end of button
////
////header
		    echo "<div style='display:none;' id='".$div_id."'>"; //begin folder
	            echo "<div id='".$div_id."_header' style='display:none'>";//header
	            echo "<span id='".$div_id."_header_table' class='folder_header_span' style='display:none'>";
		      echo "<table class='folder_header_table'>";
		  //echo "<td class='folder_header_part1'><button style='width:100%;'class='folder_button' onclick='TraverseIframe('".$div_id."',1);location.href=\"#".$div_id."_footer_anchor\"'>Dive Down</button></td>";
		    echo "<td class='folder_header_part4'>";
		    if (!$is_dvd_folder) {
		      echo "<button id=\"".$i."_button\" style=\"width:100%\" onclick=\"SnapIn('#" .$i. "_button',1)\">#</button>";
		    } else {
		      echo "<button id=\"".$i."_dvd_button\" style=\"width:100%\" onclick=\"SnapIn('#" .$i. "_dvd_button',1)\">#</button>";
		    }
		    echo "<td class='folder_header_part4'><button style='width:100%;'class='folder_button' onclick='SnapIn(\"#".$div_id."_footer_anchor\",0)'>!</button></td>";
		    echo "</td>";
		    echo "<td class='folder_header_part1'><button style='width:100%;'class='folder_button' onclick='TraverseIframe(\"".$div_id."\",1,0)'>↓</button></td>";
		    echo "<td class='folder_header_part1'><button style='width:100%;'class='folder_button' onclick='TraverseIframe(\"".$div_id."\",0,0)'>↖</button></td>";
		    echo "<td class='folder_header_part1'><button style='width:100%;' onclick='ToggleTreeView(\"".$div_id."\");'>=</button></td>";
		    echo "<td class='folder_header_part2'><div class='folder_full_dir'>{$full_folder_directories}</div></td>";
		    echo "<td class='folder_header_part3'><div class='folder_full_dir'>".$folder_name."</div></td>";
		    echo "</table>";
	            echo "</span>";
	            echo "</div>"; //end of header
////
////iframe
	            echo "<div>";
	            //echo "<iframe width='99%' height='85%' class='".$div_id."' id='https://gdaym8.site:592/php/view_folder.php?target_folder=".$div_id."'></iframe>";
	            echo "<iframe width='99%' height='85%' class='".$div_id."' id='https://gdaym8.site/php/view_folder.php?target_folder=".$div_id."'></iframe>";
	            echo "</div>";
////
////footer
                    echo "<span id='".$div_id."_footer' style='diplay:none;'>";
	            echo "<span id='".$div_id."_footer_table' class='folder_footer_span' style='display:none;'>"; //working
		    echo "<table class='folder_footer_table'><tr>";
		    //echo "<td class='folder_footer_part1'><button style='width:100%;'class='folder_button' onclick='TraverseIframe(\"".$div_id."\",0);location.href=\"#".$div_id."_header\"'>↑</button></td>";
		    echo "<td class='folder_footer_part3'><button style='width:100%;'class='folder_button' onclick='SnapIn(\"#".$div_id."_footer_anchor\",0)'>!</button></td>";
		    echo "<td class='folder_footer_part3'>";
		    if (!$is_dvd_folder) {
		      echo "<button style='width:100%' onclick=\"SnapIn('#".$i."_button',1)\">#</button>";
		    } else {
		      echo "<button style='width:100%' onclick=\"SnapIn('#".$i."_dvd_button',1)\">#</button>";
		    }
		    echo "</td>";
		//up down a folder traversal
		    echo "<td class='folder_footer_part1'><button style='width:100%;'class='folder_button' onclick='TraverseIframe(\"".$div_id."\",1,0)'>↓</button></td>";
		    echo "<td class='folder_footer_part1'><button style='width:100%;'class='folder_button' onclick='TraverseIframe(\"".$div_id."\",0,0)'>↑</button></td>";
		//unroll/roll iframe
		    echo "<td class='folder_footer_part1'><button style='width:100%;'class='folder_button' onclick='TraverseIframe(\"".$div_id."\",0,1);AdjustIframe(\"".$div_id."\",1);location.href=\"#".$div_id."_footer_anchor\"'>+</button></td>";
		    echo "<td class='folder_footer_part1'><button style='width:100%;'class='folder_button' onclick='TraverseIframe(\"".$div_id."\",0,1);AdjustIframe(\"".$div_id."\",0);location.href=\"#".$div_id."_footer_anchor\"'>-</button></td>";
		//close folder & label
		    echo "<td class='folder_footer_part2'><button style='width:100%;' onclick=ToggleTreeView('".$div_id."')>=</button></td>";
		    echo "<td class='folder_footer_part2'><div class='folder_full_dir'>{$full_folder_directories}</div></td>";
		    echo "</tr></table>";
	            echo "</span>";
	            echo "<div id='".$div_id."_footer_anchor' style='display:none;'>{$S}</div>";
	            //echo "<div id='".$div_id."_footer_break' style='display:none'><div class='folder_footer_break'>{$S}</div><br><br><br></div>";
	            echo "</span>";
	            echo "</div>";
////
////end of case 0 print folder
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
              } //end switch actions
	    } //end of . or ..
	    if ($type!=0) { //type 0 on surface only, others are recursive
              PrintDir($a_f,$type,$n+1);
	    }
          } //end for loop, before loop is a div	  
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
        $_t = $txt;        

	//$_t = str_replace("$e$","<div class=''></div><div class=\"\"></div></source></audio></b></h2></style></form></button></ul></details></img></iframe></span></a></d;v></div>",$_t);
	///$_t = str_replace("#e#","<div class=''></div><div class=\"\"></div></source></audio></b></h2></style></form></button></ul></details></img></iframe></span></a></d;v></div>",$_t);

	$regex_textarea="[Tt][Ee][xX][tT][Aa][Rr][Ee][Aa]";
	$_t = preg_replace("/{$regex_textarea}/i","tëxtarea",$_t);

	$regex_table="[Tt][Aa][Bb][Ll][Ee]";
	$_t = preg_replace("/{$regex_table}/i","täble",$_t);

	//$regex_div_1="d\;v";
	//$_t = preg_replace("/{$regex_div_1}/i","X_x",$_t);

	//$regex_div_2="div";
	//$_t = preg_replace("/{$regex_div_2}/i","d;v",$_t);

	$regex_php="[Pp][Hh][Pp]";
        $_t = preg_replace("/{$regex_php}/i","*php",$_t);

	$regex_wrong_src="\<[Ss][Rr][Cc]";
	$_t = preg_replace("/{$regex_wrong_src}/i","?_?",$_t);

	$regex_gamer="[Nn][Ii][Gg]{2}[Ee][Rr]";
        $_t = preg_replace("/{$regex_gamer}/i","buddy",$_t);

        $regex_meta="[mM][eE][Tt][Aa]";
        $_t = preg_replace("/{$regex_meta}/i","mëta",$_t);

	$regex_body="[Bb][Oo][Dd][Yy]";
	$_t = preg_replace("/{$regex_body}/i","bódy",$_t);

	$regex_object="[Oo][Bb][Jj][Ee][Cc][Tt]";
	$_t = preg_replace("/{$regex_object}/i","obĵect",$_t);

        $regex_data="[dD][Aa][Tt][Aa]";
        $_t = preg_replace("/{$regex_data}/i","däta",$_t);

	$regex_autoplay="[Aa][uU][Tt][Oo][Pp][Ll][Aa][Yy]";
	$_t = preg_replace("/{$regex_autoplay}/i","autopläy",$_t);

	$regex_title="[Tt][Ii][Tt][Ll][Ee]";
	$_t = preg_replace("/{$regex_title}/i","títle",$_t);

        $regex_script="[Ss][Cc][Rr][Ii][Pp][Tt]";
        $_t = preg_replace("/{$regex_script}/i","scrípt",$_t);

        $regex_xss="[Xx][Ss]{2}";
        $_t = preg_replace("/{$regex_xss}/i","X_x",$_t);

        $regex_cookie="[Cc][Oo]{2}[Kk][Ii][Ee]";
        $_t = preg_replace("/{$regex_cookie}/i","cookíe",$_t);

	$regex_hidden="[Hh][Ii][Dd]{2}[Ee][Nn]";
        $_t = preg_replace("/{$regex_hidden}/i","hídden",$_t);

        $regex_java="[jJ][Aa][Vv][Aa]";
        $_t = preg_replace("/{$regex_java}/i","jäva",$_t);

        $regex_onerror="[Oo][Nn][Ee][Rr]{2}[Oo][Rr]";
        $_t = preg_replace("/{$regex_onerror}/i","onërror",$_t);

        $regex_onload="[Oo][Nn][Ll][Oo][Aa]";
        $_t = preg_replace("/{$regex_onload}/i","onloäd",$_t);

        $regex_onproperty="[Oo][Nn][Pp][Rr][Oo][Pp][Ee][Rr][Tt][Yy]";
        $_t = preg_replace("/{$regex_onproperty}/i","onpropërty",$_t);

        $regex_statechange="[Ss][Tt][Aa][Tt][Ee][Cc][Hh][Aa][Nn][Gg][Ee]";
        $_t = preg_replace("/{$regex_statechange}/i","_stätechange",$_t);

        $regex_marquee="[Mm][Aa][Rr][Qq][Uu][Ee]{2}";
        $_t = preg_replace("/{$regex_marquee}/i","märquee",$_t);

        $regex_svg="[Ss][Vv][Gg]";
        $_t = preg_replace("/{$regex_svg}/i","śvg",$_t);

	$regex_plaintext="[Pp][Ll][Aa][Ii][Nn][Tt][Ee][Xx][Tt]";
	$_t = preg_replace("/{$regex_plaintext}/i","plaíntext",$_t);

        $regex_iframe="\<[iI][fF][rR][aA][mM][Ee]";
        $_t = preg_replace("/{$regex_iframe}/i","<iframe sandbox='allow-scripts allow-same-origin' ",$_t);


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
//HTML
    //Style
    //Includes user's style'
    echo "
  <style>

    #showfiletree {
      border:2px solid;
      overflow-y:auto;
    }


    .folder_opened, .folder_header_span, .folder_footer_span, .music_row {
      white-space:nowrap;
      overflow-x:auto;
    }

    .folder_full_dir {
      white-space:nowrap;
      overflow-x:auto;
    }

    .a_file_name{
      /*max-width: 445px;*/
      max-width: 436px;
      white-space:nowrap;
      overflow-x:auto;
    }

    .folder_full_dir {
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
      width:8%;border-width:thin;border-style:solid;
    }

    .folder_header_part2 {
      width:33%;
      border-width:thin;
      border-style:solid;
      overflow-wrap:break-word;
    }

    .folder_header_part3 {
      width:30%;
      border-width:thin;border-style:solid;text-align:center;
      overflow-wrap:breakw-word;
    }

    .folder_header_part4 {
      width:3%;border-width:thin;border-style:solid;
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
      width:8%;border-width:thin;border-style:solid;
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


    .user_chat_box {
      border-width:thin;border-style:solid;width:100%;max-height:480px;
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
    function DrawNavBar() {
      global $S;
      global $PROTIPS;
      global $RAND_TIP;
      global $SELF_USER_NAME;
      global $SELF_USER_FOLDER_NAME;

      echo "<div id='default_server_header'>";
      echo "<a class='default_server_header_txt' target='_blank' href='/'>{$S}@{$S}</a>{$S}";
      echo "<a class='default_server_header_txt' target='_blank' href='/global'>{$S}View Site Content{$S}</a>{$S}";
      echo "<a class='default_server_header_txt' target='_blank' href='/php/VidStream.php'>{$S}VidStream{$S}</a>{$S}";

      if (file_exists($SELF_USER_FOLDER_NAME)) { //User is logged in
        echo "<a class='default_server_header_txt' target='_blank' href='/php/user_act_folder.php'>{$S}Disc Management{$S}</a>{$S}";
        echo "<a class='default_server_header_txt' target='_blank' href='/global/".$SELF_USER_NAME."'>{$S}".$SELF_USER_NAME."{$S}</a>{$S}";
        if (GetDirectorySize($SELF_USER_FOLDER_NAME)>0) {
          echo "<a class='default_server_header_txt' target='_blank' href='/php/save_disc.php'>{$S}Save Disc{$S}</a>{$S}";
        }
        echo "<a class='default_server_header_txt' target='_blank' href='/php/are_you_sure.php'>{$S}Log Out{$S}</a>{$S}";

      } else { //not logged in:
        echo "<a class='default_server_header_txt' target='_blank' href='/php/login_register_form.php'>{$S}Join!{$S}</a>{$S}";
        echo "<span id='self_ip'>{$S}u:$SELF_USER_NAME{$S}</span>{$S}";
      }

      echo "{$S}<span id='timeUser' style='display:inline'></span>{$S}";

      echo "<br><div id='random_tips' style='display:inline;'>".$PROTIPS[$RAND_TIP]."</div>";
      echo '<script src="/script/dynamic_header.js"></script>';

      echo "</div>";
    //
    //
    }
  ?>

