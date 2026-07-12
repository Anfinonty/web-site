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
//GLOBALS
  var is_focus_txthere=0;
  let list_of_user_ip_address=[];
  let list_of_usernames=[];
  let display_x=[];
  let display_y=[];
  //let sprite_is_afk=[];
  //let sprite_hover=[];
  let display_chat_onscreen_timer=[];
//
//

//CHAT FUNCTIONS
  function get_start_reverse(_a,_L) {
    var start=0;
    for (i=0;i<_L;i++) {
      if (!gchat_arr[_L-i-1].includes("<div class='a_chat'>[")) {start++;} 
      else {return start;}
    }
    return 0;
  }

  ViewOrder=function(o,f,w,_chathere_txt,silent) {
    var i;      
    var chathere_txt=_chathere_txt;//chathere.innerHTML;
    var ip_address="";
    var username="";
    var href_ip_address=""; 
    var href_username="";
    var arr_str;
    var latest_ip_address="";
    var is_anon=0;
    const regex_ip_address=/\[(\/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\]/g;
    const regex_username=/\[(\/[A-Za-z0-9_]{1,16})\]/g;

    afk_timer=0;


  //Split chat by #e#
    if (o) {
      const regex_usplit=/[\$|\#]e[\$|\#]/ig //Legacy
      //const regex_usplit=/[\#]e[\#]/ig
      const _arr=chathere_txt.split(regex_usplit);
    //latest chat
      for (i=0;i<_arr.length-1;i++) {
        arr_str=_arr[i];
        ip_address="";
        href_ip_address="";
        username="";

       href_username="";

        is_anon=0;
        if (arr_str.match(/\]\[\/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/g)!=null) {
          is_anon=1;
        }
        if (is_anon) {
          try { //Link IP address to account
            ip_address=regex_ip_address.exec(arr_str)[1];            
            href_ip_address="[<a href='/global/"+ip_address+"'>"+ip_address+"</a>]";
          } catch(err) {}
          gchat_arr[i]=arr_str.replace(regex_ip_address,href_ip_address);
        } else {
          try { //Link IP username to account
            username=regex_username.exec(arr_str)[1];            
            href_username="[<a href='/global/"+username+"'>"+username+"</a>]";
          } catch(err) {}
          gchat_arr[i]=arr_str.replace(regex_username,href_username);
        }
      }
    }

  //Setup Chat
    var _L=gchat_arr.length;    
    const _end="<div class=''></div><div class=\"\"></div></source></audio></b></h2></style></form></button></ul></img></iframe></span></a></d;v></div>"; //fancy overflow container
    var start=get_start_reverse(gchat_arr,_L);

  //latest txt
    //const regex_beginning=/\[\d+\/\d+\/\d+\s\d+\:\d+\:\d+\]\[\<a\shref\=\'\/global\/\/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\'\>\/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\<\/a\>\]\s/ig;
    const regex_normal_ip_address=/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/;
    const regex_sqbracket_space = /\]\s(.*)/;
    const regex_sqbracket = /\](.*)/;

  //audio
    var a=new Audio("/audio/button_audio_flip1.mp3");
    var a2=new Audio("/audio/button_audio_flip2.mp3");
    var txt="";
    if (w) {
      //var start=0;
      for (i=start;i<_L;i++) {
        txt+="<div class='a_chat'>"+gchat_arr[_L-i-1]+_end;
      }
      if (!silent) {a.play();}
    } else {
      for (i=0;i<_L;i++) {txt+="<div class='a_chat'>"+gchat_arr[i]+_end;}
      if (!silent) {a2.play();}
    }
    if (f) {flip=!w;}
    chathere.innerHTML=txt;

  //Clean Fragments
    txt=chathere.innerHTML; //Get html after above process
    chathere.textContent=txt; //display as plaintxt
    txt=chathere.textContent;

    txt=txt.replace(/\&lt\;\&gt\;/ig,"<br>");
    txt=txt.replace(/\&lt\; d\;v\=\"\"\&gt\;/ig,"<br>");
    txt=txt.replace(/\&lt\;\=\"\" d\;v\=\"\"\&gt\;/ig,"<br>");

    chathere.innerHTML=txt;      
  }
//
//
//
//
//
// 

//Function to Update Chat
  UpdateChat=function(silent,silent2) {
    var i;
    //chathere.innerHTML="";
    req = new XMLHttpRequest();
    req.onreadystatechange = function() {
      if (this.readyState==4 && this.status==200) {
        var _t = String(this.responseText);
        if (saved_gchat_size!=_t.length) {
          saved_gchat_size=_t.length;
          if (!silent2) {
            var a=new Audio("/audio/chat_update.mp3")
            a.play();
          }        
        } else {
          return 0;
        }
        //chathere.textContent=_t; //debug mode
        //_t = chathere.textContent;

        _t = _t.replace(/d;v/ig,"X_x");//prevents onmouseover overflow
        _t = _t.replace(/div/ig,"d;v");

        const regex_wrong_src=/\<[Ss][Rr][Cc]/ig;
        _t = _t.replace(regex_wrong_src,"?_?");

        const regex_gamer=/[Nn][Ii][Gg]{2}[Ee][Rr]/ig;
        _t = _t.replace(regex_gamer,"Nigeria");

        const regex_gamer2=/[Nn][Ii][Gg]{2}[Aa]/ig;
        _t = _t.replace(regex_gamer2,"Homie");

        const regex_textarea=/[Tt][Ee][xX][tT][Aa][Rr][Ee][Aa]/ig;
        _t = _t.replace(regex_textarea,"text@rea");

        const regex_table=/[Tt][Aa][Bb][Ll][Ee]/ig;
        _t = _t.replace(regex_table,"t@ble");

        const regex_plaintext=/[Pp][Ll][Aa][Ii][Nn][Tt][Ee][Xx][Tt]/ig;
        _t = _t.replace(regex_plaintext,"pl@intext");

        const regex_object=/[Oo][Bb][Jj][Ee][Cc][Tt]/ig;
        _t = _t.replace(regex_object,"0bject");

        const regex_php=/[Pp][Hh][Pp]/ig;
        _t = _t.replace(regex_php,")hp");

        const regex_meta=/[mM][eE][Tt][Aa]/ig;
        _t = _t.replace(regex_meta,"m3ta");

        const regex_data=/[dD][Aa][Tt][Aa]/ig;
        _t = _t.replace(regex_data,"d@ta");

       const regex_autoplay=/[Aa][uU][Tt][Oo][Pp][Ll][Aa][Yy]/ig;
        _t = _t.replace(regex_autoplay,"@utoplay");

        const regex_script=/[Ss][Cc][Rr][Ii][Pp][Tt]/ig;
        _t = _t.replace(regex_script,"$cript");

        const regex_xss=/[Xx][Ss]{2}/ig;
        _t = _t.replace(regex_xss,"X_x");

        const regex_body=/[Bb][Oo][Dd][Yy]/ig;
        _t = _t.replace(regex_body,"bod¥");

        const regex_hidden=/[Hh][Ii][Dd][Dd][Ee][Nn]/ig;
        _t = _t.replace(regex_hidden,"h1dden");

        const regex_cookie=/[Cc][Oo]{2}[Kk][Ii][Ee]/ig;
        _t = _t.replace(regex_cookie,"c00kie");
        
        const regex_java=/[jJ][Aa][Vv][Aa]/ig;
        _t = _t.replace(regex_java,"j@va");

        const regex_onerror=/[Oo][Nn][Ee][Rr]{2}[Oo][Rr]/ig;
        _t = _t.replace(regex_onerror,"0n3rr0r");

        const regex_onload=/[Oo][Nn][Ll][Oo][Aa]/ig;
        _t = _t.replace(regex_onload,"0nl0a");

        const regex_onproperty=/[Oo][Nn][Pp][Rr][Oo][Pp][Ee][Rr][Tt][Yy]/ig;
        _t = _t.replace(regex_onproperty,"0npr0perty");

        const regex_statechange=/[Ss][Tt][Aa][Tt][Ee][Cc][Hh][Aa][Nn][Gg][Ee]/ig;
        _t = _t.replace(regex_statechange,"_st@techange");

        const regex_title=/[Tt][Ii][Tt][Ll][Ee]/ig;
        _t = _t.replace(regex_title,"t1tle");

        const regex_marquee=/[Mm][Aa][Rr][Qq][Uu][Ee]{2}/ig;
        _t = _t.replace(regex_marquee,"m@rquee");

        const regex_svg=/[Ss][Vv][Gg]/ig;
        _t = _t.replace(regex_svg,"$vg");

        const regex_chathere=/[Cc][Hh][Aa][Tt][Hh][Ee][Rr][Ee]/ig;
        _t = _t.replace(regex_chathere,"ch@there");

        const regex_id=/[Ii][Dd]\=\"/ig; //prevents no style showing
        _t = _t.replace(regex_id,"1d=''");        
	_t = _t.replace(/\/\>/ig,"XD"); //Wrong End Sharp Bracket
        _t = _t.replace(/\&\#/ig,"XD"); //Encoding Char

        _t = _t.replace(/\%28/ig,"X_x");            //"(" in an encoded            


        //Short cuts
        _t = _t.replace(/\#i\#/ig,"<img src='");
        _t = _t.replace(/\#\_i\#/ig,"'>");



//Misc, commented out as they arent used
        //const regex_alert=/[Aa][Ll][Ee][Rr][Tt]/ig;
        //_t = _t.replaceAll(regex_alert,"@lert");

        //const regex_xml=/[Xx][Mm][Ll]/ig;
        //_t = _t.replaceAll(regex_xml,"X_x");

        //const regex_form=/[Ff][Oo][Rr][Mm]/ig;
        //_t = _t.replaceAll(regex_form,"f0rm");        //const regex_xlink=/[xX][Ll][Ii][Nn][Kk]/ig;
        //_t = _t.replaceAll(regex_xlink,"xl1nk_");        //const regex_window=/[Ww][Ii][Nn][Dd][Oo][Ww]/ig;
        //_t = _t.replaceAll(regex_window,"w1ndow");
       
        //const regex_worksinie=/[wW][Oo][rR][Kk][Ss][Ii][Nn][Ii][Ee]/ig;
        //_t = _t.replaceAll(regex_worksinie,"w0rksin1e");

        //const regex_ifphp=/[iI][fF][rR][aA][M][eE][pP][Hh][pP]/ig;
        //_t = _t.replaceAll(regex_ifphp,"1fr4mephp");
        //const regex_vulnerable=/[Vv][Uu][Ll][Nn][Ee][Rr][Aa][Bb][Ll][Ee]/ig;
        //_t = _t.replaceAll(regex_vulnerable,"vulner@bl3");

        //const regex_button=/[Bb][Uu][Tt]{2}[Oo][Nn]/ig
        //_t = _t.replaceAll(regex_button,"butt0n");

        //const regex_confirm=/[Cc][Oo][Nn][Ff][Ii][Rr][Mm]/ig;
        //_t = _t.replaceAll(regex_confirm,"c0nfirm");

        //const regex_prompt=/[Pp][Rr][Oo][Mm][Pp][Tt]/ig;
        //_t = _t.replaceAll(regex_prompt,"pr0mpt");
        
       // const regex_document=/[dD][oO][cC][uU]/ig;
       // _t = _t.replaceAll(regex_document,"d0cu");

        //const regex_absolute=/[aA][bB][Ss][oO][Ll][Uu][Tt][Ee]/ig;
        //_t = _t.replaceAll("@bsolute","@bsolute");

        //_t = _t.replaceAll("t:set","");

        //chathere.innerHTML=_t; //end
        //chathere.textContent=_t;

        ViewOrder(1,0,!flip,_t,silent);
      }
    };
    req.open("GET","../oldchat/totalchat.txt?",true);
    req.send();
  }

  //DISPLAY LIVE TIME
  LiveTimer=function() {
    var dateStringUTC = new Date().toLocaleString("en-US", {timeZone: "UTC"});
    var s2 = dateStringUTC.replace(", ", " / "); // one instance only
    var timeTxt = "["+s2+"]: (UTC)";
    var timeDisplay=document.getElementById("timeUTC");
    timeDisplay.innerHTML=timeTxt;
  }   
//
//
//
//
//
//==cursor ACTIONS====
  TxtHereOnFocus=function() {
    afk_timer=0;
    is_focus_txthere=1;
  }

  TxtHereOnBlur=function() {
    afk_timer=0;
    is_focus_txthere=0;
  }

//=================//
//
//
//Start On Load
  UpdateChat(1,1);
  setInterval(LiveTimer, 1000);
});



