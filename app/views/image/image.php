
<div id="image__root">
    <div id="image__photo">
        <?php
            include_once('toolbar.php');
            include_once('camera.php');
        ?>
    </div>
    <div id="image__past-photos">

    </div>
</div>



<?php
    $this->registerJsFile('flexible/flexible.js');
    $this->registerCssFile('flexible/flexible.css');
    $this->registerCssFile('image');


