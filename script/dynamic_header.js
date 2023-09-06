
function DisplaySessionTimer() {
  var dateStringUTC = Math.floor(Date.now()/1000);
  var s1 = parseInt(document.getElementById("user_session_expiry").innerHTML);
  var s2 = dateStringUTC;
  var time_left = s1-s2;
  if (time_left>0) {
    document.getElementById("session_limit").innerHTML=" Recharge ("+time_left+"s remaining) ";
  } else {
    document.getElementById("session_limit").innerHTML=" Recharge ";
  }


  //var dateStringUTC = new Date().toLocaleString("en-US", {timeZone: "UTC"});
  //var z2 = dateStringUTC.replace(", ", " / ");
  //var timeTxt = "Your Time Now Is: "+s1+"<br> UTC Time Now Is: "+s2;
  //var timeTxtUTC = "UTC:"+z2;
  //var timeDisplayUTC=document.getElementById("timeUTC");
  //timeDisplayUTC.innerHTML=timeTxtUTC;

  var local_tz=Intl.DateTimeFormat().resolvedOptions().timeZone;
  var dateStringLocal = new Date().toLocaleString("en-US", {timeZone: local_tz});
  var z1 = dateStringLocal.replace(", ", " / ");
  var timeTxtUser = z1;
  var timeDisplayUser=document.getElementById("timeUser");
  timeDisplayUser.innerHTML=timeTxtUser;
}

setInterval(DisplaySessionTimer,1000);