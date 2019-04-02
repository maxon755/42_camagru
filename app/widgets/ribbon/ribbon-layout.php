<?php

use app\components\CaseTranslator;

$this->view->registerJsFile('/widgets/post/post.js', true);
$this->view->registerJsFile('/widgets/ribbon/ribbon.js', true);

$widgetName = CaseTranslator::toKebab($this->widgetName);

$this->view->registerJsScript(<<<JS
let ribbonData = {
    'url': '$this->url',
    'offset': $this->offset,
    'limit': $this->limit,
};
JS
)
?>

<div id="<?= $widgetName . '__container' ?>"></div>

