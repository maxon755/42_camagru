;(function (window, document) {
    let pluginName = 'flexible';

    function TransformableElement(element) {

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

            return frame;
        }

        function createPoints(frame) {
            let pointsContainer = document.createElement('div');
            let prefix = pluginName + '__position-';

            pointsContainer.classList.add(pluginName + '__pointsContainer');

            let positionClasses = [
                'top-left', 'top-center', 'top-right',
                'middle-left', 'middle-right',
                'bottom-left', 'bottom-center', 'bottom-right',
            ];

            for (let i = 0; i < positionClasses.length; i++) {
                let point = document.createElement('div');
                point.classList.add(
                    'flexible__point',
                    prefix + positionClasses[i],
                );
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
            activePoint = this;
            this.startDragData = {
                elementWidth: element.width,
                elementHeight: element.height,
                mousePosition: {
                    x: event.clientX,
                    y: event.clientY,
                },
            };

            return false;
        }

        document.addEventListener('mouseup', function () {
            activePoint = null;
            return false;
        });

        document.addEventListener('mousemove', function (event) {
            if (!activePoint) {
                return;
            }
            let startDragData = activePoint.startDragData;

            element.width = startDragData.elementWidth + (event.clientX - startDragData.mousePosition.x);
            element.height = startDragData.elementHeight;

        });

        return {
            getFlexible: function() {
                return self.frame;
            }
        }
    }

    HTMLElement.prototype[pluginName] = function () {
        let element = this;

        if (!element.hasOwnProperty(pluginName)) {
            element[pluginName] = new TransformableElement(element);
        }

        return element[pluginName].getFlexible();
    };
})(window, document);
