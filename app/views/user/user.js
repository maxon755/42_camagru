window.onload = function () {

    let video = document.getElementById('user__video');
    let canvas = document.getElementById('user__canvas');
    let context = canvas.getContext('2d');

    let startButton = document.getElementById('user__start-button');
    let stopButton = document.getElementById('user__stop-button');
    let snapButton = document.getElementById('user__snap-button');

    let width = 640;
    let height = 0;

    video.setAttribute('width', width);
    video.setAttribute('height', 3/4 * width);

    let streaming = false;

    startButton.addEventListener('click', function () {
        clearCanvas();

        navigator.mediaDevices.getUserMedia({
            video: true,
            audio: false
        }).then(streamWebCam)
          .catch(function () {
              console.log('something wrong');
          })
    });

    function streamWebCam(stream) {
        video.srcObject = stream;
        video.onloadedmetadata = function(e) {
            video.play();
        };
    }

    video.addEventListener('canplay', function(ev){
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth/width);

            if (isNaN(height)) {
                height = width / (4/3);
            }

            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;
        }
    });

    snapButton.addEventListener('click', function () {
        takePicture();
        stopStream();
    });

    function takePicture() {
        if (width && height) {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);
        }
    }

    function clearCanvas() {
        context.clearRect(0, 0, canvas.width, canvas.height);
    }

    function stopStream() {
        video.srcObject.getTracks()[0].stop();
    }
};
