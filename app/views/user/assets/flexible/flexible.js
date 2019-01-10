;(function (window, document) {
    let pluginName = 'flexible';

    function TransformableElement(element) {

        let activePoint = null;

        (function () {
            let frame = createFrame();
            element.parentElement.appendChild(frame);
            frame.appendChild(element);
        })();

        element.onclick = function () {
            console.log('onclicked troll');
        };

        function createFrame() {
            let frame = document.createElement('div');
            frame.classList.add(`${pluginName}__frame`);
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

                pointsContainer.appendChild(point);
            }

            pointsContainer.addEventListener('mousedown', function(event) {
                return handlePointMouseDown(event);
            });
            frame.appendChild(pointsContainer);
        }

        function handlePointMouseDown(event) {
            if (!event.target.classList.contains('flexible__point') ||
                event.button !== 0) {
                return;
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

            // console.log('mouse down event:');
            // console.log(this.startDragData);
            // return false;
        }

        document.addEventListener('mouseup', function () {
            activePoint = null;
            return false;
        });

        document.addEventListener('mousemove', function (event) {
            if (!activePoint) {
                return;
            }
            // console.log('mouse move event:');
            // console.dir(activePoint);
            // console.log(event.target);

            let startDragData = activePoint.startDragData;

            element.width = startDragData.elementWidth + (event.clientX - startDragData.mousePosition.x);
            element.height = startDragData.elementHeight;

        });
    }

    HTMLElement.prototype[pluginName] = function () {
        let element = this;

        if (!element.dataset[pluginName]) {
            element.dataset[pluginName] = new TransformableElement(element);
        }

        return element.dataset[pluginName];
    };
})(window, document);
