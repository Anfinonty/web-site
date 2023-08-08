//Toggle Tree View for PrintDir
  function ToggleTreeView(_e) {   
    var i;
    e = document.getElementById(_e); //folder directory
    e2=document.getElementById(_e.concat("_branch"));
    e3=document.getElementById(_e.concat("_button"));
    e4=document.getElementById(_e.concat("_folder_tab"));
    e5=document.getElementById(_e.concat("_last_branch"));
    const folder_files=document.getElementsByClassName(_e);
    const folder_video_files=document.getElementsByClassName(_e.concat("_video"));
    const folder_audio_files=document.getElementsByClassName(_e.concat("_audio"));

    _dvd="/dvd/AVRIL_LAVIGNE";
    if (e.style.display=="none") { //open
      e.style.display="block"; //folder open, causes the break
      e.style.borderWidth="thick"; //folder border size
      e.style.borderStyle="solid"; //folder border type

      e3.style.display="inline-table"; //button break
      e3.style.borderWidth="thick"; //button border size
      e3.style.borderStyle="solid"; //button border type

      if (_e!=_dvd) {
        //e.style.marginBottom="32px"; //folder bottom margin
        //e3.style.marginTop="32px"; //button margin top open

        e2.style.display="inline-table"; //branch in button open
        e5.style.display="inline-table"; //final branch open

        try {
	  e4.style.display="block";
	  e3.style.display="block";
          e5.style.display="block"; //final branch open
	  e4.style.width="100%";
	  e4.style.height="100%";
	} catch (error) {}; //folder tab open
      }
      for (i=0;i<folder_files.length;i++) {	//open branch class folder
	folder_files[i].src=folder_files[i].id;
      }
      for (i=0;i<folder_video_files.length;i++) {	//open branch class videos in folder
	folder_video_files[i].load();
      }
      for (i=0;i<folder_audio_files.length;i++) {	//open branch class audios in folder
	folder_audio_files[i].load();
      }
    } else { //close
      e.style.display="none"; // folder close
      e2.style.display="none"; //branch in button close
      e3.style.display="inline-table"; //button snap back
      e3.style.borderWidth="none";
      e3.style.borderStyle="none";

      try {e4.style.display="none";} catch (error) {} //iframe in button close
      e5.style.display="none"; //branch in button close


      //e3.style.marginTop="0px"; //button margin top close
      /*for (i=0;i<folder_files.length;i++) {	//close branch class folder
	folder_files[i].src="";
      }*/
    }
  }