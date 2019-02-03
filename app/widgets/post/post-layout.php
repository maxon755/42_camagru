<?php
    /** @var \app\widgets\post\Post $this */
    /** @var \app\base\View $this->view  */

    use app\components\CaseTranslator;

    $name = CaseTranslator::toKebab($this->getShortClassName());
?>

<div class="<?php echo $name . '__container' ?>">
    <div class="<?php echo $name . '__info' ?>">
        <a class="<?php echo $name . '__username' ?>" href="/user/<?php echo $this->postData['username'] ?>">
            <?php echo $this->postData['username'] ?>
        </a>
        <span class="<?php echo $name . '__date' ?>"><?php echo $this->postData['date'] ?></span>
    </div>

    <hr class="<?php echo $name . '__line' ?>">
    <?php
        $imagePath = $this->postData['image_path'];
        if (!realpath(ROOT . $imagePath)) {
            $imagePath =  DS . 'widgets' . DS . 'post' . DS . 'broken-file.png';
        }
    ?>
    <img src="<?php echo $imagePath ?>" alt="post image" class="<?php echo $name . '__image' ?>">

    <hr class="<?php echo $name . '__line' ?>">

</div>

<?php
    $this->view->registerCssFile('widgets/post/post.css', true);
