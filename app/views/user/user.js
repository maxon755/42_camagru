window.onload = function () {

    // WebCam Stream control block

    let capture = document.getElementById('user__capture');
    let video = document.getElementById('user__video');
    let canvas = document.getElementById('user__canvas');
    let context = canvas.getContext('2d');
    let startButton = document.getElementById('user__start-button');
    let stopButton = document.getElementById('user__stop-button');

    let width = 640;
    let height = 480;

    let streaming = false;

    startButton.addEventListener('click', function () {
        toggleStartButton();

        if (!streaming) {
            clearCanvas();
            getWebCamAccess();
        } else {
            takePicture();
            streaming = false;
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

        video.onloadedmetadata = function(e) {
            video.play();
        };

        video.oncanplay = function() {
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth/width);

                if (isNaN(height)) {
                    height = width / (4/3);
                }

                capture.style.width = width + 'px';
                capture.style.height = height + 'px';

                streaming = true;
            }
        };
    }

    stopButton.addEventListener('click', function () {
        stopStream();
        clearCanvas();
    });

    function takePicture() {
        if (width && height) {
            let memsUrl = canvas.toDataURL();
            let mems = new Image();
            mems.src = memsUrl;

            mems.onload = function() {
                clearCanvas();
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);
                context.drawImage(mems, 0, 0, width, height);
            }
        }
    };


    function clearCanvas() {
        context.clearRect(0, 0, canvas.width, canvas.height);
    }

    function stopStream() {
        if (streaming) {
            toggleStartButton();
        }
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

    // Drag`n`Drop control block

    let troll = document.getElementById('user__troll-face');

    troll.ondragstart = function(event) {
        event.dataTransfer.setData("text", event.target.id);
    };

    canvas.ondragover = function(event) {
        console.log('ondragover');
        event.preventDefault();
    };

    canvas.ondrop = function(event) {
        event.preventDefault();
        let data = event.dataTransfer.getData("text");
        let image = document.getElementById(data);

        context.drawImage(image, 20, 20);
    }
};
