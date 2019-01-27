;(function (window, document) {
    let pluginName = 'flexible';

    function FlexibleElement(element) {

        let self = this;
        let activePoint = null;

        (function () {
            self.frame = createFrame();
            insertFrame();
        })();

        function insertFrame() {
            let nextElement = element.nextElementSibling;

            if (nextElement !== null) {
                element.parentElement.insertBefore(self.frame, nextElement);
            } else {
                element.parentElement.appendChild(self.frame);
            }
            self.frame.appendChild(element);
        }

        function createFrame() {
            let frame = document.createElement('div');
            frame.classList.add(`${pluginName}__frame`);
            frame.style.height = element.height + 'px';
            createPoints(frame);

            frame.addEventListener('click', function (event) {
                event.stopPropagation();
                showPointContainer(event);
            });

            return frame;
        }

        function showPointContainer(event) {
            let containers = document.getElementsByClassName('flexible__points-container');
            for (let i = 0; i < containers.length; i++) {
                if (containers[i] !== self.pointsContainer) {
                    containers[i].style.display = 'none';
                }
            }

            self.pointsContainer.style.display = 'block';
        }

        function createPoints(frame) {
            let pointsContainer = document.createElement('div');
            let prefix = pluginName + '__position-';

            self.pointsContainer = pointsContainer;

            pointsContainer.classList.add(pluginName + '__points-container');

            let positions = [
                'top-left', 'top-center', 'top-right',
                'middle-left', 'middle-right',
                'bottom-left', 'bottom-center', 'bottom-right',
            ];

            for (let i = 0; i < positions.length; i++) {
                let point = document.createElement('div');
                point.classList.add(
                    'flexible__point',
                    prefix + positions[i],
                );
                point.dataset['position'] = positions[i];
                point.setAttribute('draggable', 'false');
                point.addEventListener('dragstart', function () {
                    event.preventDefault();
                    event.stopPropagation();

                    return false;
                });
                pointsContainer.appendChild(point);
            }

            pointsContainer.addEventListener('mousedown', function(event) {
                return handlePointMouseDown(event);
            });
            frame.appendChild(pointsContainer);
        }

        function handlePointMouseDown(event) {
            event.stopPropagation();
            if (!event.target.classList.contains('flexible__point') ||
                event.button !== 0) {
                return false;
            }
            activePoint = event.target;
            activePoint.startDragData = {
                frameTop: self.frame.offsetTop,
                frameLeft: self.frame.offsetLeft,
                frameRight: getElementPosition(self.frame).x + element.width,
                frameBottom: getElementPosition(self.frame).y + element.height,
                elementWidth: element.width,
                elementHeight: element.height,
                mousePosition: {
                    x: event.clientX,
                    y: event.clientY,
                },
            };

            return false;
        }

        document.addEventListener('click', function() {
            self.pointsContainer.style.display = 'none';
        });

        document.addEventListener('mouseup', function() {
            activePoint = null;
            return false;
        });

        document.addEventListener('mousemove', function(event) {
            if (!activePoint) {
                return;
            }

            let startDragData = activePoint.startDragData;

            switch (activePoint.dataset['position']) {
                case 'top-left':
                    resizeLeft(event, startDragData);
                    resizeUp(event, startDragData);
                    break;

                case 'top-right':
                    resizeRight(event, startDragData);
                    resizeUp(event, startDragData);
                    break;

                case 'top-center':
                    resizeUp(event, startDragData);
                    constrainDimension(element, startDragData, 'width');
                    break;

                case 'middle-right':
                    resizeRight(event, startDragData);
                    constrainDimension(element, startDragData, 'height');
                    break;

                case 'middle-left':
                    resizeLeft(event, startDragData);
                    constrainDimension(element, startDragData, 'height');
                    break;

                case 'bottom-left':
                    resizeLeft(event, startDragData);
                    resizeDown(event, startDragData);
                    break;

                case 'bottom-center':
                    resizeDown(event, startDragData);
                    constrainDimension(element, startDragData, 'width');
                    break;

                case 'bottom-right':
                    resizeRight(event, startDragData);
                    resizeDown(event, startDragData);
                    break;
            }
        });

        function resizeUp(event, data) {
            if (element.height !== 0 && event.pageY  < data.frameBottom) {
                self.frame.style.top = data.frameTop + (event.clientY - data.mousePosition.y) + 'px';
            }
            element.height = data.elementHeight - (event.clientY - data.mousePosition.y);
            self.frame.style.height = element.height + 'px';
        }

        function resizeDown(event, data) {
            element.height = data.elementHeight + (event.clientY - data.mousePosition.y);
            self.frame.style.height = element.height + 'px';
        }

        function resizeLeft(event, data) {
            if (element.width !== 0 && event.clientX < data.frameRight) {
                self.frame.style.left = data.frameLeft + (event.clientX - data.mousePosition.x) + 'px';
            }
            element.width = data.elementWidth - (event.clientX - data.mousePosition.x);
        }

        function resizeRight(event, data) {
            element.width = data.elementWidth + (event.clientX - data.mousePosition.x);
        }

        function constrainDimension(element, data, dimension) {
            element[dimension] = data['element' + capitalize(dimension)];
        }

        function capitalize(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function getElementPosition(element){
            let x = element.offsetLeft;
            let y  = element.offsetTop;
            let parent = element.offsetParent;

            while (parent){
                x += parent.offsetLeft;
                y += parent.offsetTop;
                parent = parent.offsetParent;
            }

            return { x, y }
        }

        return {
            getFlexible: function() {
                return self.frame;
            }
        }
    }

    HTMLElement.prototype[pluginName] = function () {
        let element = this;

        if (!element.hasOwnProperty(pluginName)) {
            element[pluginName] = new FlexibleElement(element);
        }

        return element[pluginName].getFlexible();
    };
})(window, document);
