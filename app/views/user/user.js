window.onload = function () {

    let video = document.getElementById('user__video');
    let canvas = document.getElementById('user__canvas');
    let context = canvas.getContext('2d');

    let startButton = document.getElementById('user__start-button');
    let stopButton = document.getElementById('user__stop-button');
    let snapButton = document.getElementById('user__snap-button');

    startButton.addEventListener('click', function () {
        navigator.mediaDevices.getUserMedia({
            video: {
                width: 600,
                height: 420,
            },
        }).then(streamWebCam);
    });

    function streamWebCam(stream) {
        video.srcObject = stream;
        video.play();
    }

    stopButton.addEventListener('click', function () {
        video.srcObject.getTracks()[0].stop();
    });

    snapButton.addEventListener('click', function () {
        context.drawImage(video, 0, 0);
    })
};