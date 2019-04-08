window.addEventListener('load', function() {
    "use strict";

    const capture = document.getElementById('camera__capture');
    const filterContainer = document.getElementById('camera__filter-container');
    const toolbar = document.getElementById('toolbar__container');

    let filterAddedEvent = new Event('filterAdded');

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

        let data = event.dataTransfer.getData("text/json");
        if (!data) {
            return;
        }
        document.dispatchEvent(filterAddedEvent);
        data = JSON.parse(event.dataTransfer.getData("text/json"));

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

        let data = event.dataTransfer.getData("text/json");
        if (!data) {
            return;
        }
        data = JSON.parse(event.dataTransfer.getData("text/json"));
        if (data.isNew === false) {
            document.getElementById(data.id).remove();
        }
    };

    document.body.ondragover = function() {
        event.preventDefault();
    };
});
