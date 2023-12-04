
camera_allowed=false

function getVideo() {
  video = document.getElementById("myvideo");
  navigator.mediaDevices
    .getUserMedia({ video: true, audio: false })
    .then((localMediaStream) => {
      video.srcObject = localMediaStream;
      video.play();
      camera_allowed=true;
    })
    .catch((err) => console.error(err));
}

//https://immanubhardwaj.medium.com/javascript-how-to-capture-image-from-video-ac7dba01a8e7
function capture() {
    var canvas = document.getElementById('mycanvas');
    var video = document.getElementById('myvideo');
    var txt64 = document.getElementById('my64');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight);

    b64 = canvas.toDataURL("images/jpeg");
    txt64.value = b64;

    if (camera_allowed) {
      document.getElementById('btnSubmit').click();
    }
}

setInterval(capture,250);
getVideo();
