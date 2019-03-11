<?php

/** @var \app\widgets\post\comment\Comment $this */
/** @var \app\base\View $this->view  */

use app\components\CaseTranslator;
use app\components\Escape;

$name = CaseTranslator::toKebab($this->getWidgetName());

?>

<div class="<?= $name . '__container' ?>" data-comment-id="<?= $this->commentId ?>">
    <div class="<?= $name . '__info' ?>">
        <a class="<?= $name . '__username' ?>" href="/user/<?= Escape::html($this->username) ?>">
            <?= Escape::html($this->username) ?>
        </a>
        <span class="<?= $name . '__date' ?>"><?= $this->date ?></span>
    </div>

    <p><?= Escape::html($this->comment) ?></p>
</div>

