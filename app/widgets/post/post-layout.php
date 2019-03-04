<?php
/** @var \app\widgets\post\Post $this */
/** @var \app\base\View $this->view  */

use app\components\CaseTranslator;
use app\components\Escape;

$this->view->registerCssFile('/widgets/post/post.css', true);


$name = CaseTranslator::toKebab($this->widgetName);
$username = $this->postData['username'];

$imagePath = $this->postData['image_path'];
if (!realpath(ROOT . $imagePath)) {
    $imagePath = $this->brokenFilePath;
}
?>

<div class="<?= $name . '__container' ?>">
    <div class="<?= $name . '__info' ?>">
        <a class="<?= $name . '__username' ?>" href="/user/<?= Escape::html($username) ?>">
            <?= Escape::html($username) ?>
        </a>
        <span class="<?= $name . '__date' ?>"><?= $this->postData['date'] ?></span>
    </div>

    <hr class="<?= $name . '__line' ?>">
    <div class="<?= $name . '__image-wrap' ?>">
        <img src="<?= $imagePath ?>" alt="post image" class="<?= $name . '__image' ?>">
    </div>

    <hr class="<?= $name . '__line' ?>">

</div>
