window.addEventListener('load', function() {
    "use strict";

    let capture = document.getElementById('camera__capture');
    let video = document.getElementById('camera__video');
    let canvas = document.getElementById('camera__canvas');
    let context = canvas.getContext('2d');
    let startButton = document.getElementById('camera__start-button');
    let stopButton = document.getElementById('camera__stop-button');
    let saveButton = document.getElementById('camera__save-button');
    let fileButton = document.getElementById('camera__file-button');
    let filterContainer = document.getElementById('camera__filter-container');

    let width = 640;
    let height = 480;

    canvas.setAttribute('width', width);
    canvas.setAttribute('height', height);

    let streaming = false;

    startButton.addEventListener('click', function () {
        if (!streaming) {
            clearCanvas();
            getWebCamAccess();
            saveButton.disabled = true;
        } else {
            takePicture();
            toggleStartButton();
            streaming = false;
            saveButton.disabled = false;
        }
    });

    function getWebCamAccess() {
        navigator.mediaDevices.getUserMedia({
            video: true,
            audio: false
        })
            .then(function(stream) {
                toggleStartButton();
                streamWebCam(stream);
            })
            .catch(function (error) {
                displayError(error.message)
            })
    }

    function displayError(errorText) {
        context.font = "30px Arial";
        context.fillStyle = "red";
        context.textAlign = "center";
        context.fillText(errorText, canvas.width / 2, canvas.height / 2);
    }

    function streamWebCam(stream) {
        video.srcObject = stream;

        video.onloadedmetadata = function() {
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
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);

                streaming = true;
            }
        };
    }

    stopButton.addEventListener('click', function () {
        let filters = filterContainer.children;

        stopStream();
        clearCanvas();
        removeHtmlCollection(filters);
    });

    function takePicture() {
        if (width && height) {
            context.drawImage(video, 0, 0, width, height);
        }
    }

    saveButton.addEventListener('click', function () {
        saveCanvasContent();
    });


    function clearCanvas() {
        context.clearRect(0, 0, canvas.width, canvas.height);
    }

    function saveCanvasContent() {
        let filters = filterContainer.children;

        drawFilters(filters);
        removeHtmlCollection(filters);
        saveResultImage();
    }

    function drawFilters(filters) {
        for (let i = 0; i < filters.length; i++) {
            let filter = filters[i];
            let image = filter.getElementsByTagName('img')[0];
            context.drawImage(
                image,
                filter.offsetLeft,
                filter.offsetTop,
                image.width,
                image.height,
            );
        }
    }

    function saveResultImage() {
        let src = canvas.toDataURL("image/jpeg", 0.5);
        let img = new Image();

        img.src = src;

        img.onload = function () {
            sendPhotoToServer(img)
                .then(
                    () => {
                        addImageToContainer(img);
                        alert('Image successfully uploaded');
                },
                    () => {
                        stopStream();
                        clearCanvas();
                        displayError('Upload failed. Try again.');
                })
        };
    }

    function addImageToContainer(img) {
        let container = document.getElementById('image__past-photos');

        img.style.width = img.width + 'px';
        img.style.height = img.height + 'px';
        container.appendChild(img);
    }

    function sendPhotoToServer(img) {
        return new Promise((resolve, reject) => {
            let formData    = new FormData();
            let xhr         = new XMLHttpRequest();

            formData.append('image', img.src);
            xhr.open('post', '/image/save');
            xhr.send(formData);

            xhr.onload = function () {
                let response;
                try {
                    response = JSON.parse(xhr.response)
                } catch (e) {
                    reject();
                }
                response.result ? resolve() : reject();
            };
            xhr.onerror = function () {
                reject();
            };
        });
    }

    function removeHtmlCollection(collection) {
        for (let i = collection.length - 1; i >= 0; --i) {
            collection[i].remove();
        }
    }

    function stopStream() {
        saveButton.disabled = true;
        if (!video.srcObject) {
            return;
        }
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

    fileButton.addEventListener("change", (event) => {

        let file = event.target.files[0];
        let reader = new FileReader();

        if (!isFileImage(file.type)) {
            return;
        }

        clearCanvas();

        reader.onload = (event) => {
            let image = new Image();

            image.src = event.target.result;

            image.onload = () => {
                canvas.setAttribute('width', image.width);
                canvas.setAttribute('height', image.height);
                context.drawImage(image, 0, 0, image.width, image.height);
            };
        };
        reader.readAsDataURL(file);
    });

    function isFileImage(fileType) {
        return /^image\/[a-z]+$/.test(fileType)
    }
});
