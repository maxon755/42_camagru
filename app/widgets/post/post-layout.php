<?php
/** @var \app\widgets\post\Post $this */
/** @var \app\base\View $this->view  */

use app\components\CaseTranslator;
use app\components\Escape;
use app\widgets\inputForm\components\textArea\TextArea;
use app\widgets\inputForm\InputForm;
use app\widgets\post\comment\Comment;

if (!$this->isAsync()) {
    $this->view->registerCssFile('/widgets/post/post.css', true);
    $this->view->registerJsFile('/widgets/post/post.js', true);
}

$name = CaseTranslator::toKebab($this->getWidgetName());

$imagePath = $this->imagePath;
if (!realpath(ROOT . $imagePath)) {
    $imagePath = $this->brokenFilePath;
}

$liked = $this->liked ? 'liked' : '';

$form = new InputForm([
        'name'   => $name . '__comment-editor',
        'action' => '/ribbon/create-comment',
        'header' => false,
    ], [
        new TextArea([
            'name' => 'comment',
            'rows' => 5,
        ])
    ]);
?>

<div class="<?= $name . '__container' ?>" data-post-id ="<?= $this->postId ?>">
    <div class="<?= $name . '__info' ?>">
        <a class="<?= $name . '__username' ?>" href="/user/<?= Escape::html($this->username) ?>">
            <?= Escape::html($this->username) ?>
        </a>
        <span class="<?= $name . '__date' ?>"><?= $this->date ?></span>
    </div>

    <hr class="<?= $name . '__line' ?>">
    <div class="<?= $name . '__image-wrap' ?>">
        <img src="<?= $imagePath ?>" alt="post image" class="<?= $name . '__image' ?>">
    </div>

    <hr class="<?= $name . '__line' ?>">

    <div class="<?= $name . '__interaction-container' ?>">
        <div class="<?= $name . '__like-block' ?>">
            <span class="fas fa-heart like fa-2x <?= $liked ?>"></span>
            <span class="<?= $name . '__like-counter'?>">
            <?= $this->likes ?>
        </span>
        </div>

        <div class="<?= $name . '__comment' //fa-comment-alt?>">
            <span class="far fa-edit fa-2x comment-icon"></span>
        </div>
    </div>

    <?php $form->render() ?>

    <div class="<?= $name . '__comments-container' ?>">
        <?php foreach ($this->comments as $commentData) {
            (new Comment($commentData, $this->isAsync()))->render();
        } ?>
    </div>
</div>

