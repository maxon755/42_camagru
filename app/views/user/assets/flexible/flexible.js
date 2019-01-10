;(function(window, document) {
    let pluginName = 'flexible';

    function TransformableElement(element) {

        (function () {
            let frame = createFrame();
            element.parentElement.appendChild(frame);
            frame.appendChild(element);

            frame.addEventListener('drop', function (event) {
                event.stopPropagation();
            })

        })();

        element.onclick = function() {
            console.log('onclicked troll');
        };

        function createFrame() {
            let frame = document.createElement('div');
            frame.classList.add(`${pluginName}__frame`);
            createPoints(frame);

            return frame;
        }

        function createPoints(frame) {
            let prefix = pluginName + '__position-';

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

                addEventsToPoint(point);
                frame.appendChild(point);
            }
        }

        function addEventsToPoint(point) {
            point.setAttribute('draggable', 'true');

            point.addEventListener('dragstart', function(event) {
               this.startDragData = {
                   elementWidth: element.width,
                   elementHeight: element.height,
                   mousePosition: {
                       x: event.clientX,
                       y: event.clientY,
                   },
               };

               event.dataTransfer.setDragImage(new Image(), 0, 0);
            });

            point.addEventListener('drag', function(event) {

                let startDragData = event.target.startDragData;

                element.width = startDragData.elementWidth + (event.clientX - startDragData.mousePosition.x);
                element.height = startDragData.elementHeight;

            });
        }
    }

    HTMLElement.prototype[pluginName] = function () {
        let element = this;

        if (!element.dataset[pluginName]) {
            element.dataset[pluginName] = new TransformableElement(element);
        }

        return element.dataset[pluginName];
    };
})(window, document);
