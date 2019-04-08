<?php
/** @var \app\base\View $this */

$images = [
    'troll-face',
    'troll-face-red',
    'duck-face',
    'happy-face',
    'happy-girl',
    'omg-face',
    'or-girl',
    'sad-face',
    'why',
    'yao-min',
]
?>

<div id="toolbar__container">
        <?php
            foreach ($images as $image) {
                echo <<<IMG
                <img
                    id="toolbar__$image"
                    src="/views/$this->viewName/assets/$image.png"
                    alt="Troll face"
                    draggable="true">
IMG;
            }
        ?>
</div>
