<?php
    /** @var \app\widgets\post\Post $this */
    /** @var \app\base\View $this->view  */

    use app\components\CaseTranslator;

    $name = CaseTranslator::toKebab($this->getShortClassName());
?>

<div class="<?= $name . '__container' ?>">
    <div class="<?= $name . '__info' ?>">
        <a class="<?= $name . '__username' ?>" href="/user/<?= $this->postData['username'] ?>">
            <?= $this->postData['username'] ?>
        </a>
        <span class="<?= $name . '__date' ?>"><?= $this->postData['date'] ?></span>
    </div>

    <hr class="<?= $name . '__line' ?>">
    <?php
        $imagePath = $this->postData['image_path'];
        if (!realpath(ROOT . $imagePath)) {
            $imagePath =  DS . 'widgets' . DS . 'post' . DS . 'broken-file.png';
        }
    ?>
    <img src="<?= $imagePath ?>" alt="post image" class="<?= $name . '__image' ?>">

    <hr class="<?= $name . '__line' ?>">

</div>

<?php
    $this->view->registerCssFile('widgets/post/post.css', true);
