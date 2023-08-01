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
//
//
//
//Gets the integer id based on the unique ip address via for loop
  function GetIdFromIpAddress(_ip_address) {
    var i;
    for (i=0;i<list_of_user_ip_address.length;i++) {
      if (_ip_address==list_of_user_ip_address[i]) {return i;}
    }
    return 0;
  }

//Get the interger id based on the unique username via for loop
  function GetIdFromUsername(_username) {
    var i;
    for (i=0;i<list_of_user_ip_address.length;i++) {
      if (_username==list_of_usernames[i]) {return i;}
    }
    return 0;
  }

//CHAT FUNCTIONS
  //get the latest part of the chat
  function get_start_reverse(_a,_L) {
    var start=0;
    for (i=0;i<_L;i++) {
      if (!gchat_arr[_L-i-1].includes("<div class='a_chat'>[")) {start++;} 
      else {return start;}
    }
    return 0;
  }


  //view in earliest-to-latest or latest-to-earliest
  ViewOrder=function(o,f,w,_chathere_txt,silent) {
    var i;      
    var chathere_txt=_chathere_txt;//chathere.innerHTML;
    var ip_address="";
    var username="";
    var href_ip_address=""; 
    var href_username="";    var arr_str;
    var latest_ip_address="";
    var is_anon=0;

    const regex_ip_address=/\[(\/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\]/g;
    const regex_username=/\[(\/[A-Za-z0-9_]{1,16})\]/g;

    afk_timer=0;


  //Split chat by #e#
    if (o) {
      //const regex_usplit=/[\$|\#]e[\$|\#]/ig //Legacy
      const regex_usplit=/[\#]e[\#]/ig
      const _arr=chathere_txt.split(regex_usplit);
    //latest chat line
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
          try { //Link IP address to account - Legacy
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
    //const regex_normal_ip_address=/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/; //Legacy
    const regex_normal_ip_address=/[a-zA-Z0-9]{32,32}/;

    //old const with /s at the end - not supported in older browsers
    //const regex_sqbracket_space = /\]\s(.*)/s;
    //const regex_sqbracket = /\](.*)/s;

    const regex_sqbracket_space = /\]\s(.*)/;
    const regex_sqbracket = /\](.*)/;


    var latest_txt=gchat_arr[_L-start-1];
    var chatbubble_arr=latest_txt.split(regex_sqbracket_space);
    var chatbubble_part2=chatbubble_arr[1];
    var chatbubble_part1=chatbubble_arr[0].split(regex_sqbracket)[1]+"]";
    latest_ip_address=chatbubble_part1.match(regex_normal_ip_address);
    if (latest_ip_address!=null) {
      display_chat_onscreen_timer[GetIdFromIpAddress(latest_ip_address)]=1000;
    } else {
      // /s is not supported in older browsers
      //var latest_username=chatbubble_part1.match(/\>\/(.*)\<\/a\>\]/s)[1];

      var latest_username=chatbubble_part1.match(/\>\/(.*)\<\/a\>\]/ig)[1];
      display_chat_onscreen_timer[GetIdFromUsername(latest_username)]=1000;
      latest_ip_address=latest_username;
    }
    latest_txt="<div id='a_chat_bubble'>"+chatbubble_part1+"<br>"+chatbubble_part2+_end;
    latest_txt=latest_txt.replace("\n",""); //one instance
    latest_txt=latest_txt.replace(/\n/ig,"<br>"); //replace all instances of /n via regex

    //replaceAll is not supported in older browsers
    //latest_txt=latest_txt.replaceAll("\n","<br>");

    var sprite_latest_speaker=document.getElementById("name_sprite_"+latest_ip_address);
    try { //attempt at finding latest speaker if he exists
      sprite_latest_speaker.innerHTML=latest_txt;
    } catch (err) {}

  //audio
    var a=new Audio("/audio/button_audio_flip1_new.mp3");
    var a2=new Audio("/audio/button_audio_flip2_new.mp3");
    var txt="";
    if (w) {
      //var start=0;
      for (i=start;i<_L;i++) {
        txt+="<div class='a_chat'>"+gchat_arr[_L-i-1]+_end;
      }
      if (!silent) {a.play();} //play flip audio if not silent
    } else {
      for (i=0;i<_L;i++) {txt+="<div class='a_chat'>"+gchat_arr[i]+_end;}
      if (!silent) {a2.play();} //play unflip audio if not silent
    }
    if (f) {flip=!w;} //bool/unbool

    chathere.innerHTML=txt;
  //Clean Fragments
    txt=chathere.innerHTML; //Get html after above process
    chathere.textContent=txt; //display as plaintxt
    txt=chathere.textContent; //assign to var

    //replaceAll is not supported in older browsers
//    txt=txt.replaceAll("&lt;&gt;","<br>");
//    txt=txt.replaceAll("&lt; d;v=\"\"&gt;","<br>");
//    txt=txt.replaceAll("&lt;=\"\" d;v=\"\"&gt;","<br>");
    //begin clearing fragments
    txt=txt.replace(/\&lt\;\&gt\;/ig,"<br>");
    txt=txt.replace(/\&lt\; d\;v\=\"\"\&gt\;/ig,"<br>");
    txt=txt.replace(/\&lt\;\=\"\" d\;v\=\"\"\&gt\;/ig,"<br>");
    //show txt in chatbox
    chathere.innerHTML=txt;      
  }
//
//
//
//
//
//Get list of users from Sessions.joined users
  function GetUsersList() {
    var i;
    req = new XMLHttpRequest();
    req.onreadystatechange = function() {
      if (this.readyState==4 && this.status==200) {
        const tmp_list_of_user_ip_address=String(this.responseText).split(",");
        tmp_list_of_user_ip_address.pop();
        for (i=0;i<tmp_list_of_user_ip_address.length;i++) {
          list_of_user_ip_address[i]=tmp_list_of_user_ip_address[i].split("#")[0];
          list_of_usernames[i]=tmp_list_of_user_ip_address[i].split("#")[1];
        }
      }
    };
    req.open("GET","global/{Sessions}/joined_users.txt",true);
    req.send();
  }

//Check if user has a chat-icon
  function IsUserIconExists(_ip_address,_ext) {
    var request;
    if (window.XMLHttpRequest)
      request = new XMLHttpRequest();
    else
      request = new ActiveXObject("Microsoft.XMLHTTP");
    request.open('GET', '/global/'+_ip_address+'/chat_icon.'+_ext, false);
    request.send();
    if (request.status === 404) {
      return false;
    }
    return true;
  }


//initialize live-peers chat icons
  function InitUsersDiv() {
    var i;
    var _ip_address="";
    var txt="";
    const default_icon_link="/images/spider.bmp";
    var set_icon_link="";
    for (i=0;i<list_of_user_ip_address.length;i++) {
      _ip_address=list_of_usernames[i];
      if (IsUserIconExists(_ip_address,"gif")) {
        set_icon_link="/global/"+_ip_address+"/chat_icon.gif";
      } else if (IsUserIconExists(_ip_address,"apng")) {
        set_icon_link="/global/"+_ip_address+"/chat_icon.apng";
      } else if (IsUserIconExists(_ip_address,"png")) {
        set_icon_link="/global/"+_ip_address+"/chat_icon.png";
      } else if (IsUserIconExists(_ip_address,"jpg")) {
        set_icon_link="/global/"+_ip_address+"/chat_icon.jpg";
      } else if (IsUserIconExists(_ip_address,"jpeg")) {
        set_icon_link="/global/"+_ip_address+"/chat_icon.jpeg";
      } else {
        set_icon_link=default_icon_link;
      }
      if (txt.match("id='sprite_"+_ip_address+"'")==null) {//check 4 duplicates
        txt+=
        "<div "+
        //"onmouseover='MoveBehind("+i+",this)' "+ 
          "id='sprite_"+_ip_address+"'>"+
            "<img id='img_sprite_"+_ip_address+"' src='"+set_icon_link+"'>"+
            "<nobr id='name_sprite_"+_ip_address+"' class='user_chat'>"+
                _ip_address+
            "</nobr>"+
        "</div>";
      }
    }
    document.getElementById("users_onscreen").innerHTML=txt;
  }

//initialize style of the user chat-icon
  function InitUsersDivStyle() {
    var i;
    var d;
    var dimg;
    var dtxt;
    for (i=0;i<list_of_user_ip_address.length;i++) {
      //div same size as img
      d=document.getElementById("sprite_"+list_of_usernames[i]);
      d.style.position = "absolute";
      d.style.width="2%";
      d.style.display="inline";
      dimg=document.getElementById("img_sprite_"+list_of_usernames[i]);
      dimg.style.height = "auto";
      dimg.style.maxWidth = "100%";
      dimg.style.maxHeight = "100%";
      d.style.position = "absolute";
      //dimg.style.display = "inline";

      dtxt=document.getElementById("name_sprite_"+list_of_usernames[i]);
      dtxt.style.position = "absolute";
    }
  }

//Initialize the invisible buttons that allow touchscreen/cursor hover = move chat_icon along
 function InitMouseClickButtons() {
    var x,y;
    for (y=0;y<GR_HEIGHT;y+=CURSOR_GAP) {
      for (x=0;x<GR_WIDTH;x+=CURSOR_GAP) {
        var c=document.getElementById("btnAxisClick"+"_x"+x+"_y"+y);
        try {
          c.style.position="absolute";
          c.style.left=x+"px";
          c.style.top=y+"px";
          c.style.width=CURSOR_GAP+"px";
          c.style.height=CURSOR_GAP+"px";
          c.style.opacity="0";
          c.style.zIndex="-1";
        } catch (err) {}
      }
    }
  }

//Legacy -- Make screen absolute
/*  function InitAbsoluteAxisScreen() {
    var bx1=document.getElementById("btnXMinus");
    var bx2=document.getElementById("btnXPlus");
    var by1=document.getElementById("btnYMinus");
    var by2=document.getElementById("btnYPlus");
    var default_server_header=document.getElementById("default_server_header");
    var default_chatroom_greet=document.getElementById("default_chatroom_greet");
    var chatbox_actions=document.getElementById("chatbox_actions");

    var users_onscreen=document.getElementById("users_onscreen");
    var btnSubmit=document.getElementById("btnSubmit");
    var txthere=document.getElementById("txthere");
    var chathere=document.getElementById("chathere");
    var random_tips=document.getElementById("random_tips");

    bx1.style.position="absolute";
    by1.style.position="absolute";
    bx2.style.position="absolute";
    by2.style.position="absolute";
    
    by1.style.left="32px";
    by2.style.left="56px";
    bx2.style.left="80px";

    bx1.style.top="64px";
    by1.style.top="64px";    
    by2.style.top="64px";
    bx2.style.top="64px";

    bx1.style.zIndex="1";
    bx2.style.zIndex="1";
    by1.style.zIndex="1";
    by2.style.zIndex="1";

    users_onscreen.zIndex="1";
    
    default_server_header.style.position="absolute";
    default_server_header.style.zIndex="1";

    default_chatroom_greet.style.position="absolute";
    default_chatroom_greet.style.top="8px";

    chatbox_actions.style.position="absolute";
    chatbox_actions.style.top="164px";
    chatbox_actions.style.zIndex="1";

    btnSubmit.style.position="absolute";
    btnSubmit.style.top="228px";
    btnSubmit.style.zIndex="1";
    
    txthere.style.position="absolute";
    txthere.style.top="252px";
    txthere.style.zIndex="1";

    random_tips.style.position="absolute";
    random_tips.style.top="384px";
    random_tips.style.zIndex="1";

    chathere.style.position="absolute";
    chathere.style.top="424px";
    chathere.style.width=GR_WIDTH+"px";
    chathere.style.zIndex="1";

  }*/


//Initialize peers graphics
  function PeersScreenInit() {
    GetUsersList();
    var luser_len=list_of_user_ip_address.length;
    if (luser_len!=saved_list_of_user_ip_address_size) {
      var a1=new Audio("../audio/user_leave.mp3");
      var a2=new Audio("../audio/user_join.mp3");
      if (saved_list_of_user_ip_address_size>0) { //valid change
        if (enable_live_peers) { //peers is ON          
	  if (luser_len>saved_list_of_user_ip_address_size) {
	    a2.play(); //play userjoin audio
          } else {
	    a1.play();
	  }//play user leave audio
        }
        updated_peers_screen_init=1;
      }
      saved_list_of_user_ip_address_size=luser_len;
      InitUsersDiv();
      InitUsersDivStyle();
    }
  }
//
//
//
  //Function to Update Characteronscreen
  function GetUserFromServer(ip_address,i) {
    req = new XMLHttpRequest();
    req.onreadystatechange = function() {
      if (this.readyState==4 && this.status==200) {
        const xy=String(this.responseText).split(",");
        display_x[i]=xy[0];
        display_y[i]=xy[1];
        var user_time=xy[2];
      }
    };
    req.open("GET","/global/{Sessions}/"+ip_address+".txt",true);
    req.send();
  }

  //UpdateLivePeers
  function UpdateLivePeers() {
    var i;
    for (i=0;i<list_of_user_ip_address.length;i++) {
      GetUserFromServer(list_of_user_ip_address[i],i);
      var d=document.getElementById("sprite_"+list_of_usernames[i]);
      var dimg=document.getElementById("img_sprite_"+list_of_usernames[i]);
      var dname=document.getElementById("name_sprite_"+list_of_usernames[i]);
    //Sprite Hover
      /*if (sprite_hover[i]>0) {
        //d.style.zIndex=-1;
        sprite_hover[i]--;
      } else {
        //d.style.zIndex=1;
      }*/
    //display chat onscreen
      if (display_chat_onscreen_timer[i]>0 && enable_live_chat) {
        display_chat_onscreen_timer[i]--;
      } else {
        try{
        dname.innerHTML=list_of_usernames[i];
        } catch (err) {}
      }
    //sprite axis
      try {
        d.style.left=display_x[i]+"px";
        d.style.top=display_y[i]+"px";
      } catch (err) {}
    }
  }

  //Function to Update Chat
  UpdateChat=function(silent,silent2) {
    var i;
    //chathere.innerHTML="";
    req = new XMLHttpRequest();
    req.onreadystatechange = function() {
      if (this.readyState==4 && this.status==200) {
        var _t = String(this.responseText);
//        console.log(_t);
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
        //_t = chathere.textContent; //debug mode

        //Older browser versions do not support replaceAll

       /*_t = _t.replaceAll("d;v","X_x");//prevents onmouseover overflow
        _t = _t.replaceAll("div","d;v");

        const regex_wrong_src=/\<[Ss][Rr][Cc]/ig;
        _t = _t.replaceAll(regex_wrong_src,"?_?");

        const regex_gamer=/[Nn][Ii][Gg]{2}[Ee][Rr]/ig;
        _t = _t.replaceAll(regex_gamer,"Buddy");

        const regex_gamer2=/[Nn][Ii][Gg]{2}[Aa]/ig;
        _t = _t.replaceAll(regex_gamer2,"Homie");

        const regex_textarea=/[Tt][Ee][xX][tT][Aa][Rr][Ee][Aa]/ig;
        _t = _t.replaceAll(regex_textarea,"text@rea");

        const regex_table=/[Tt][Aa][Bb][Ll][Ee]/ig;
        _t = _t.replaceAll(regex_table,"t@ble");

        const regex_plaintext=/[Pp][Ll][Aa][Ii][Nn][Tt][Ee][Xx][Tt]/ig;
        _t = _t.replaceAll(regex_plaintext,"pl@intext");

        const regex_object=/[Oo][Bb][Jj][Ee][Cc][Tt]/ig;
        _t = _t.replaceAll(regex_object,"0bject");

        const regex_php=/[Pp][Hh][Pp]/ig;
        _t = _t.replaceAll(regex_php,")hp");

        const regex_meta=/[mM][eE][Tt][Aa]/ig;
        _t = _t.replaceAll(regex_meta,"m3ta");

        const regex_data=/[dD][Aa][Tt][Aa]/ig;
        _t = _t.replaceAll(regex_data,"d@ta");

       const regex_autoplay=/[Aa][uU][Tt][Oo][Pp][Ll][Aa][Yy]/ig;
        _t = _t.replaceAll(regex_autoplay,"@utoplay");

        const regex_script=/[Ss][Cc][Rr][Ii][Pp][Tt]/ig;
        _t = _t.replaceAll(regex_script,"$cript");

        const regex_xss=/[Xx][Ss]{2}/ig;
        _t = _t.replaceAll(regex_xss,"X_x");

        const regex_body=/[Bb][Oo][Dd][Yy]/ig;
        _t = _t.replaceAll(regex_body,"bod¥");

        const regex_hidden=/[Hh][Ii][Dd][Dd][Ee][Nn]/ig;
        _t = _t.replaceAll(regex_hidden,"h1dden");

        const regex_cookie=/[Cc][Oo]{2}[Kk][Ii][Ee]/ig;
        _t = _t.replaceAll(regex_cookie,"c00kie");
        
        const regex_java=/[jJ][Aa][Vv][Aa]/ig;
        _t = _t.replaceAll(regex_java,"j@va");

        const regex_onerror=/[Oo][Nn][Ee][Rr]{2}[Oo][Rr]/ig;
        _t = _t.replaceAll(regex_onerror,"0n3rr0r");

        const regex_onload=/[Oo][Nn][Ll][Oo][Aa]/ig;
        _t = _t.replaceAll(regex_onload,"0nl0a");

        const regex_onproperty=/[Oo][Nn][Pp][Rr][Oo][Pp][Ee][Rr][Tt][Yy]/ig;
        _t = _t.replaceAll(regex_onproperty,"0npr0perty");

        const regex_statechange=/[Ss][Tt][Aa][Tt][Ee][Cc][Hh][Aa][Nn][Gg][Ee]/ig;
        _t = _t.replaceAll(regex_statechange,"_st@techange");

        const regex_title=/[Tt][Ii][Tt][Ll][Ee]/ig;
        _t = _t.replaceAll(regex_title,"t1tle");

        const regex_marquee=/[Mm][Aa][Rr][Qq][Uu][Ee]{2}/ig;
        _t = _t.replaceAll(regex_marquee,"m@rquee");

        const regex_svg=/[Ss][Vv][Gg]/ig;
        _t = _t.replaceAll(regex_svg,"$vg");

        const regex_chathere=/[Cc][Hh][Aa][Tt][Hh][Ee][Rr][Ee]/ig;
        _t = _t.replaceAll(regex_chathere,"ch@there");

        const regex_id=/[Ii][Dd]\=\"/ig; //prevents no style showing
        _t = _t.replaceAll(regex_id,"1d=''");

        _t = _t.replaceAll("\/>","XD"); //Wrong End Sharp Bracket
        _t = _t.replaceAll("\&\#","XD"); //Encoding Char

        _t = _t.replaceAll("%28","X_x");            //"(" in an encoded            

        //Short cuts
        _t = _t.replaceAll("#i#","<img src='");
        _t = _t.replaceAll("#_i#","'>");
*/

//        _t = _t.replace("d;v","X_x");//prevents onmouseover overflow
//        _t = _t.replace("div","d;v");

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
        //_t = _t.replaceAll(regex_form,"f0rm");

        //const regex_xlink=/[xX][Ll][Ii][Nn][Kk]/ig;
        //_t = _t.replaceAll(regex_xlink,"xl1nk_");

        //const regex_window=/[Ww][Ii][Nn][Dd][Oo][Ww]/ig;
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
    req.open("GET","global/lechat.txt?",true);
    req.send();
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
    var timeDisplay=document.getElementById("timeUTC");
    timeDisplay.innerHTML=timeTxt;

//Other functions
    if (enable_live_peers) {
      PeersScreenInit();
    }
    if (afk_timer>60) {//60 seconds
      if (enable_live_chat) {
        document.getElementById("live_chat_btn").click();
      }
      if (enable_live_peers) {
        document.getElementById("live_peers_btn").click();
      }
    } else {
      afk_timer++;
    }
   // console.log(afk_timer);
    if (msg_cooldown>0) {
      msg_cooldown++;
      document.getElementById("btnSubmit").hidden = true;
      if (msg_cooldown>MAX_MSG_COOLDOWN) {
        msg_cooldown=0;
        document.getElementById("btnSubmit").hidden = false;
        document.getElementById("cleartxt").click();
      }
    }
  }   
//
//
//
  //Client On Keypress
  document.addEventListener("keydown", function(event) {
      /*if (event.keyCode == '13') {//EntER
        document.getElementById("cleartxt").click(); 
      }*/
      afk_timer=0;
      if (enable_live_peers && !is_focus_txthere) {
        if (event.keyCode == '39') {
          document.getElementById("btnXPlus").click(); 
        }
        if (event.keyCode == '37') {//left
          document.getElementById("btnXMinus").click(); 
        }
        if (event.keyCode == '40') {//down
          document.getElementById("btnYPlus").click(); 
        }
        if (event.keyCode == '38') {//up
          document.getElementById("btnYMinus").click(); 
        }
      }
  });
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

  //submit msg
  SubmitMsg=function(self) {
    self.hidden=true;
    if (document.getElementById("txthere").value!="") {
      var a = new Audio("/audio/button_audio_submit.mp3");
      a.play();
    }
    afk_timer=0;
    msg_cooldown=1;
  }

  /*MoveBehind=function(i,d) {
    //d.style.zIndex=-1;
    sprite_hover[i]=15;
  }*/

  LiveChatButton=function(t){
    var a=new Audio("../audio/button_audio_live_chat_off.mp3");
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
    enable_live_chat=!enable_live_chat;
  }

  LivePeersButton=function(t){
    var a=new Audio("../audio/button_audio_live_peers_off.mp3");
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
    enable_live_peers=!enable_live_peers;
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
  InitMouseClickButtons();
  //InitAbsoluteAxisScreen();
  UpdateChat(1,1);
  setInterval(LiveTimer, 1000);

});


