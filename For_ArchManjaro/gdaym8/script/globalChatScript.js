


if ( window.history.replaceState ) { //prevent refresh n submit
    window.history.replaceState( null, null, window.location.href );
}
//
//
//
//
//
//
//DEFINE
const GR_WIDTH=640*5;
const GR_HEIGHT=480*5;
const CURSOR_GAP=8*4;
const MAX_MSG_COOLDOWN=1;



//
const gchat_arr=[];
//BOOLS
var flip=0;
var enable_live_chat=0;
var enable_live_peers=0;

//int
var saved_gchat_size=0;
var saved_list_of_user_ip_address_size=0;
var afk_timer=0;
var msg_cooldown=0;

//Misc
let LivePeersInterval;
let LiveChatInterval;

//call ON LOAD
window.addEventListener("load", function()
{


//Adjust iframe size
  function AdjustIframe(_e, down) {

    //folder 
    const txt = "https://gdaym8.site/php/view_folder.php?target_folder=";
    var e_txt=txt.concat(_e);
    var e = document.getElementById(e_txt);

    //index.html
    //11/11/2023 NEW! getting element within an iframe
    var innerDoc = e.contentDocument || e.contentWindow.document;
    var f_txt= _e.concat("_index_");

    var a=new Audio("/audio/paper_flip.mp3");
    var a2=new Audio("/audio/paper_flip_reverse.mp3");
    var e_height = parseInt(e.height.replace("%",""));

    var e_decrease_height=false;
    if (down) { //increase height
      a.play();
      //e.height = "".concat(e_height+85,"%");
      e.height = "".concat(e_height+42,"%");
    } else if (e_height>85) { //decrease height
      a2.play();
      //e.height = "".concat(e_height-85,"%");
      e.height = "".concat(e_height-42,"%");
      e_decrease_height=true;
    }

    try { //index.html may not always be present
      var f=innerDoc.getElementById(f_txt);
      var f_height = parseInt(f.height.replace("%",""));
      if (down) {
        //f.style.height = "50%"; decrease
        f.height = "".concat(100/(e_height/85),"%");
      } else if (e_decrease_height) {
        //f.style.height = "100%"; increase, whew, tons of maths here X_x 11/12/2023
        f.height = "".concat(100*(85/(e_height-85)),"%");
      }
    } catch (error) {}

  }


  function SnapIn(l,r) {
    location.href=l;
    if (r) {
      a = new Audio("/audio/page_snap_in.mp3");
    } else {
      a = new Audio("/audio/page_snap_in_reverse.mp3");
    }
    a.play();
  }



  //DISPLAY LIVE TIME
  LiveTimer=function() {
    /*var local_tz=Intl.DateTimeFormat().resolvedOptions().timeZone;
    var dateStringLocal = new Date().toLocaleString("en-US", {timeZone: local_tz});
    var dateStringUTC = new Date().toLocaleString("en-US", {timeZone: "UTC"});
    var s1 = dateStringLocal.replace(", ", " / ");
    var s2 = dateStringUTC.replace(", ", " / ");
    var timeTxt = "Your Time Now Is: "+s1+"<br> UTC Time Now Is: "+s2;
    var timeDisplay=document.getElementById("time");
    timeDisplay.innerHTML=timeTxt;*/

    var dateStringUTC = new Date().toLocaleString("en-US", {timeZone: "UTC"});
    var s2 = dateStringUTC.replace(", ", " / "); // one instance only
    var timeTxt = "["+s2+"]: (UTC)";
    try {
      var timeDisplay=document.getElementById("timeUTC");
      timeDisplay.innerHTML=timeTxt;

//Other functions
    } catch (e) {}
  }
//
//
//
//
  //submit msg
  SubmitMsg=function(self) {
    self.hidden=true;
    if (document.getElementById("txthere").value!="") {
      var a = new Audio("/audio/button_audio_submit.mp3");
      a.play();
    }
  }

  LiveChatButton=function(t){
    /*var a=new Audio("../audio/button_audio_live_chat_off.mp3");
    var a2=new Audio("../audio/button_audio_live_chat_on.mp3");
    if (!enable_live_chat) {
      t.innerHTML="OFF Live Chat";
      //LiveChatInterval=setInterval(UpdateChat,100,1,0); //24f = 1000ms, 1f = 1000/24  = 42
      LiveChatInterval=setInterval(UpdateChat,1000,1,0); //24f = 1000ms, 1f = 1000/24  = 42
      a2.play();
    } else {
      t.innerHTML="ON Live Chat (HIGH DATA USAGE)";
      clearInterval(LiveChatInterval);
      a.play();
    }
    afk_timer=0;
    enable_live_chat=!enable_live_chat;*/
  }

  LivePeersButton=function(t){
    /*var a=new Audio("../audio/button_audio_live_peers_off.mp3");
    var a2=new Audio("../audio/button_audio_live_peers_on.mp3");    
    var d=document.getElementById("users_onscreen");
    var d2=document.getElementById("axis_click_buttons");
    var e0=document.getElementById("btnXMinus");
    var e1=document.getElementById("btnYMinus");
    var e2=document.getElementById("btnXPlus");
    var e3=document.getElementById("btnYPlus");
    if (!enable_live_peers) {
      t.innerHTML="OFF Peers";
      d.hidden=false;
      d2.hidden=false;
      e0.hidden=false;
      e1.hidden=false;
      e2.hidden=false;
      e3.hidden=false;
//      LivePeersInterval=setInterval(UpdateLivePeers,17); //60f = 1000ms, 1f = 1000/24 //17
      LivePeersInterval=setInterval(UpdateLivePeers,34); //30f = 1000ms, 1f = 1000/24 = 33
//      LivePeersInterval=setInterval(UpdateLivePeers,42); //24f = 1000ms, 1f = 1000/24  = 42
      a2.play();
    } else {
      t.innerHTML="ON Peers (HIGH DATA USAGE)";
      d.hidden=true;
      d2.hidden=true;
      e0.hidden=true;
      e1.hidden=true;
      e2.hidden=true;
      e3.hidden=true;
      clearInterval(LivePeersInterval);
      a.play();
   }
    afk_timer=0;
    enable_live_peers=!enable_live_peers;*/
 }

  ClearTxtButton=function(){
    afk_timer=0;
    if (document.getElementById("txthere").value!="") {
      var a=new Audio("../audio/button_audio_clear.mp3");
      a.play();
    }
    afk_timer=0;
    document.getElementById('form1').reset()
  }



//=================
//
//
//
//Start On Load
  try {
    _t=document.getElementById("timeUTC");
    setInterval(LiveTimer, 1000);
  } catch (e) {}

});
