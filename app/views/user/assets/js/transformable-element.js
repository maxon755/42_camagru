;(function(window, document) {
    let plugunName = 'flexible';

    function TransformableElement(element) {

        element.onclick = function() {
            console.log('onclicked troll');
        };
    }

    HTMLElement.prototype[plugunName] = function () {
        let element = this;

        if (!element.dataset[plugunName]) {
            element.dataset[plugunName] = new TransformableElement(element);
        }

        return element.dataset[plugunName];
    };
})(window, document);
