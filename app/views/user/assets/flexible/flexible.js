;(function(window, document) {
    let pluginName = 'flexible';

    function TransformableElement(element) {

        element.onclick = function() {
            console.log('onclicked troll');
        };
    }

    HTMLElement.prototype[pluginName] = function () {
        let element = this;

        if (!element.dataset[pluginName]) {
            element.dataset[pluginName] = new TransformableElement(element);
        }

        return element.dataset[pluginName];
    };
})(window, document);
