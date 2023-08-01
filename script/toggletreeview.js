//Toggle Tree View for PrintDir
  function ToggleTreeView(_e) {   
    e = document.getElementById(_e);
    e2=document.getElementById(_e.concat("_branch"));
    e3=document.getElementById(_e.concat("_button"));
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
    } else { //close
      e.style.display="none"; // folder close
      e2.style.display="none"; //branch in button close
      e3.style.display="inline-table"; //button snap back
      e3.style.marginTop="0px"; //button margin top close
    }
  }