<?php

/** @var \app\widgets\post\comment\Comment $this */
/** @var \app\base\View $this->view  */

use app\components\CaseTranslator;
use app\components\Escape;

$name = CaseTranslator::toKebab($this->getWidgetName());
$currentUser = self::$auth->getUserName();

?>

<div class="<?= $name . '__container' ?>" data-comment-id="<?= $this->commentId ?>">
    <div class="<?= $name . '__info' ?>">
        <a class="<?= $name . '__username' ?>" href="/user/<?= Escape::html($this->user) ?>">
            <?= Escape::html($this->user) ?>
        </a>
        <span class="<?= $name . '__date' ?>"><?= $this->date ?></span>
    </div>

    <p><?= Escape::html($this->comment) ?></p>

    <?php if ($this->user === $currentUser): ?>
        <span class="fas fa-times"></span>
    <?php endif; ?>
</div>

