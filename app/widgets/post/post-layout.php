<?php
/** @var \app\widgets\post\Post $this */
/** @var \app\base\View $this->view  */

use app\components\CaseTranslator;
use app\components\Escape;
use app\widgets\inputForm\components\inputField\InputField;
use app\widgets\inputForm\components\textArea\TextArea;
use app\widgets\inputForm\InputForm;

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

$liked = $this->postData['liked'] ? 'liked' : '';

$form = new InputForm([
        'name'   => $name . '__comment-editor',
        'action' => '/post/create-comment',
        'header' => false,
    ], [
        new InputField('comment', 'text', false),
        new TextArea([
                'name' => 'comment',
                'required' => false,
        ])
    ]);
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

    <div class="<?= $name . '__interaction-container' ?>">
        <div class="<?= $name . '__like-block' ?>">
            <span class="fas fa-heart fa-2x <?= $liked ?>"></span>
            <span class="<?= $name . '__like-counter'?>">
            <?= $this->postData['likes'] ?>
        </span>
        </div>

        <div class="<?= $name . '__comment' ?>">
            <span class="far fa-comment-alt fa-2x"></span>
        </div>
    </div>

    <?php $form->render() ?>


</div>
