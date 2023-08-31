//Toggle Tree View for PrintDir
  function ToggleTreeView(_e) {   
    var i;
    var e = document.getElementById(_e); //folder directory
    var e2=document.getElementById(_e.concat("_branch"));
    var e3=document.getElementById(_e.concat("_button"));
    var e4=document.getElementById(_e.concat("_folder_tab"));
    var e5=document.getElementById(_e.concat("_last_branch"));
    var e6=document.getElementById(_e.concat("_footer"));
    var e7=document.getElementById(_e.concat("_footer_table"));
    var e8=document.getElementById(_e.concat("_footer_break"));
    var e9=document.getElementById(_e.concat("_footer_anchor"));
    var e10=document.getElementById(_e.concat("_header"));    
    var e11=document.getElementById(_e.concat("_header_table"));    

    var a=new Audio("/audio/folder_open_sound3.mp3");
    var a2=new Audio("/audio/folder_close_sound.mp3");

    _dvd="/dvd/AVRIL_LAVIGNE";
    if (e.style.display=="none") { //open
      a.play();
      e.style.display="block"; //folder open, causes the break
      e.style.borderWidth="thick"; //folder border size
      e.style.borderStyle="solid"; //folder border type
      //e.style.textAlign="center"; //centering

      e3.style.display="inline-table"; //button break
      e3.style.borderWidth="thick"; //button border size
      e3.style.borderStyle="solid"; //button border type

      if (_e!=_dvd) {
        e2.style.display="inline-table"; //branch in button open
        e5.style.display="inline-table"; //final branch open
        e5.style.textAlign="left";

        try { //if index.html exists
	  e4.style.display="block"; //open website
	  e3.style.display="block"; //<br> the button
          e5.style.display="block"; //final branch open
	  e4.style.width="100%"; //fill out the user screen
	  e4.style.height="100%";
	} catch (error) {};


	//footer
        e6.style.display="block"; //display footer
	e7.style.display="block"; //footer table
	e7.style.textAlign="center";	
	e7.style.borderStyle="solid";
	e7.style.borderWidth="thick";
        e8.style.display="block"; //footer break
        e8.style.width="100%"; //footer break

	e9.style.display="inline-table"; //footer ancho
	e9.style.marginTop="-51%";

        e10.style.display="block"; //display header
	e11.style.display="block"; //header table
	e11.style.textAlign="center";
	e11.style.borderStyle="solid";
	e11.style.borderWidth="thick";
      }
      if (!e.classList.contains("folder_opened")) { //occurs once only
        const folder_files=document.getElementsByClassName(_e);
        const folder_video_files=document.getElementsByClassName(_e.concat("_video"));
        const folder_audio_files=document.getElementsByClassName(_e.concat("_audio"));

        e.classList.add("folder_opened");
        for (i=0;i<folder_files.length;i++) {	//open branch class folder
	  folder_files[i].src=folder_files[i].id;
        }
        for (i=0;i<folder_video_files.length;i++) {	//open branch class videos in folder
	  folder_video_files[i].load();
        }
        for (i=0;i<folder_audio_files.length;i++) {	//open branch class audios in folder
	  folder_audio_files[i].load();
        }
      }
    } else { //close
      a2.play();
      e.style.display="none"; // folder close
      e2.style.display="none"; //branch in button close
      e3.style.display="inline-table"; //button snap back
      e3.style.borderWidth="none"; //button folder thick border disappear
      e3.style.borderStyle="none";
      try {e4.style.display="none";} catch (error) {} //iframe in button close
      e5.style.display="none"; //branch in button close
      e6.style.display="none"; // folder footer close
      e7.style.display="none"; // folder footer close
      e8.style.display="none"; // folder footer close
      e9.style.display="none"; // folder footer close
      e10.style.display="none"; //folder header close
      e11.style.display="none"; //folder header close
    }
  }