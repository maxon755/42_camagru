;(function(window, document) {
    let pluginName = 'flexible';

    function TransformableElement(element) {

        (function () {
            let frame = createFrame();
            element.parentElement.appendChild(frame);
            frame.appendChild(element);

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

                frame.appendChild(point);
            }
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
