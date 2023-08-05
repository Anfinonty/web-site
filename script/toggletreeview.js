//Toggle Tree View for PrintDir
  function ToggleTreeView(_e) {   
    var i;
    e = document.getElementById(_e); //folder directory
    e2=document.getElementById(_e.concat("_branch"));
    e3=document.getElementById(_e.concat("_button"));
    const folder_files=document.getElementsByClassName(_e);
    const folder_video_files=document.getElementsByClassName(_e.concat("_video"));
    const folder_audio_files=document.getElementsByClassName(_e.concat("_audio"));
    _dvd="/dvd/AVRIL_LAVIGNE";
    if (e.style.display=="none") { //open
      e.style.display="block"; //folder open
      e.style.borderWidth="thick"; //folder border size
      e.style.borderStyle="solid"; //folder border type
      if (_e!=_dvd) {
        e.style.marginBottom="32px"; //folder bottom margin
        e2.style.display="inline-table"; //branch in button open
        e3.style.marginTop="32px"; //button margin top open
      }
      e3.style.display="block"; //button
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
      e3.style.marginTop="0px"; //button margin top close
      /*for (i=0;i<folder_files.length;i++) {	//close branch class folder
	folder_files[i].src="";
      }*/
    }
  }