<?php
/** @var \app\widgets\post\Post $this */
/** @var \app\base\View $this->view  */

use app\components\CaseTranslator;
use app\components\Escape;

if (!$this->isAsync()) {
    $this->view->registerCssFile('/widgets/post/post.css', true);
    $this->view->registerJsFile('/widgets/post/post.js', true);
}

$name = CaseTranslator::toKebab($this->getWidgetName());
$username = $this->postData['username'];

$imagePath = $this->postData['image_path'];
if (!realpath(ROOT . $imagePath)) {
    $imagePath = $this->brokenFilePath;
}
?>

<div class="<?= $name . '__container' ?>" data-post-id ="<?= $this->postData['post_id'] ?>">
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

    <div class="<?= $name . '__like-block' ?>">
        <span class="fas fa-heart fa-2x"></span>
        <span class="<?= $name . '__like-counter' ?>">0</span>
    </div>
</div>
