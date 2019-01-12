window.onload = function () {
    "use strict";

    const capture = document.getElementById('user__capture');
    const video = document.getElementById('user__video');
    const canvas = document.getElementById('user__canvas');
    const context = canvas.getContext('2d');
    const startButton = document.getElementById('user__start-button');
    const stopButton = document.getElementById('user__stop-button');
    const saveButton = document.getElementById('user__save-button');
    const filterContainer = document.getElementById('user__filter-container');
    const toolbar = document.getElementById('user__toolbar');

    // WebCam Stream control block

    let width = 640;
    let height = 480;

    canvas.setAttribute('width', width);
    canvas.setAttribute('height', height);

    let streaming = false;

    startButton.addEventListener('click', function () {
        toggleStartButton();

        if (!streaming) {
            clearCanvas();
            getWebCamAccess();
            saveButton.disabled = true;

        } else {
            takePicture();
            streaming = false;
            saveButton.disabled = false;
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
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);

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
        let container = document.getElementById('tmp-cont');
        let src = canvas.toDataURL("image/jpeg", 0.25);
        let img = new Image();

        img.src = src;

        img.onload = function () {
            img.style.width = img.width + 'px';
            img.style.height = img.height + 'px';
            container.appendChild(img);
        };

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

    // Drag`n`Drop control block

    let troll = document.getElementById('user__troll-face');
    troll.flexible();

    let filters = toolbar.getElementsByTagName('img');

    for (let i = 0; i < filters.length; i++) {
        filters[i].ondragstart = function(event) {
            event.dataTransfer.setData("text/json", JSON.stringify({
                isNew: true,
                id: event.target.id,
                mouseOffset: getMouseOffset(event),
            }));
        };
    }

    filterContainer.ondragover = function() {
        event.preventDefault();
    };

    filterContainer.ondrop = function(event) {
        event.preventDefault();
        event.stopPropagation();
        let data = JSON.parse(event.dataTransfer.getData("text/json"));

        if (data.isNew) {
            insertImageToFilters(data);
        } else {
            moveFilter(data);
        }
    };

    function insertImageToFilters(data) {
        let image = document.getElementById(data.id).cloneNode(true);
        image.setAttribute('draggable', 'true');
        filterContainer.appendChild(image);

        let flexContainer = image.flexible();

        flexContainer.id = 'filter-' + filterContainer.childElementCount;
        setElementPosition(event, flexContainer, data.mouseOffset);
        flexContainer.ondragstart = function(event) {
            event.dataTransfer.setData("text/json", JSON.stringify({
                isNew: false,
                id: this.id,
                mouseOffset: getMouseOffset(event),
            }));
        };
        delete flexContainer.dataset['flexible'];

    }

    function moveFilter(data) {
        let filter = document.getElementById(data.id);

        setElementPosition(event, filter, data.mouseOffset);
    }

    function setElementPosition(event, element, mouseOffset) {
        element.style.position = 'absolute';
        element.style.left = (event.pageX - capture.offsetLeft - mouseOffset.x) + 'px';
        element.style.top = (event.pageY - capture.offsetTop - mouseOffset.y) + 'px';
    }

    function getMouseOffset(event) {
        let elementPosition	= getElementPosition(event);
        return {
            x : event.pageX - elementPosition.x,
            y : event.pageY - elementPosition.y
        }
    }

    function getElementPosition(event){
        let x = event.target.offsetLeft;
        let y  = event.target.offsetTop;
        let parent = event.target.offsetParent;

        while (parent){
            x += parent.offsetLeft;
            y += parent.offsetTop;
            parent = parent.offsetParent;
        }

        return { x, y }
    }

    document.body.ondrop = function(event) {
        event.preventDefault();

        let data = JSON.parse(event.dataTransfer.getData("text/json"));

        if (data.isNew === false) {
            document.getElementById(data.id).remove();
        }
    };

    document.body.ondragover = function() {
        event.preventDefault();
    };
};
