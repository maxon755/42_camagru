window.onload = function () {

    let capture = document.getElementById('user__capture');
    let video = document.getElementById('user__video');
    let canvas = document.getElementById('user__canvas');
    let context = canvas.getContext('2d');
    let startButton = document.getElementById('user__start-button');

    let width = 640;
    let height = 480;

    let streaming = false;

    // video.setAttribute('width', width);
    // video.setAttribute('height', height);
    // canvas.setAttribute('width', width);
    // canvas.setAttribute('height', height);

    startButton.addEventListener('click', function () {
        clearCanvas();
        toggleStartButton();

        if (!streaming) {
            getWebCamAccess()
        } else {
            takePicture();
            stopStream();
        }
    });

    function getWebCamAccess() {
        navigator.mediaDevices.getUserMedia({
            video: true,
            audio: false
        })
        .then(streamWebCam)
        .catch(function () {
            console.log('something wrong');
        })
    }

    function streamWebCam(stream) {
        video.srcObject = stream;

        video.oncanplay = function(e) {
            if (!streaming) {
                console.log('canplay');
                height = video.videoHeight / (video.videoWidth/width);

                if (isNaN(height)) {
                    height = width / (4/3);
                }

                capture.style.width = width + 'px';
                capture.style.height = height + 'px';

                // capture.setAttribute('width', width);
                // capture.setAttribute('height', height);
                // canvas.setAttribute('width', width);
                // canvas.setAttribute('height', height);
                streaming = true;
            }
        };

        video.onloadedmetadata = function(e) {
            console.log('loaded meta data');
            video.play();
        };
    }

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
        streaming = false;
    }

    function toggleStartButton() {

        let circle = startButton.getElementsByClassName('fa-play-circle')[0];
        let camera = startButton.getElementsByClassName('fa-camera')[0];

        if (!streaming) {
            circle.style.display = "none";
            camera.style.display = "inline-block";
        } else {
            circle.style.display = "inline-block";
            camera.style.display = "none";
        }
    }
};
