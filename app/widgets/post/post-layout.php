<?php
    /** @var \app\widgets\post\Post $this */
    /** @var \app\base\View $this->view  */
?>

<div class="post__container">
    <p><?php echo $this->postData['date'] ?></p>
    <a href="/user/<?php echo $this->postData['username'] ?>">
        <?php echo $this->postData['username'] ?>
    </a>
    <?php
        $imagePath = $this->postData['image_path'];
        if (!realpath(ROOT . $imagePath)) {
            $imagePath =  DS . 'widgets' . DS . 'post' . DS . 'broken-file.png';
        }
    ?>
    <img src="<?php echo $imagePath ?>" alt="post image" class="post__image">
</div>

<?php
    $this->view->registerCssFile('widgets/post/post.css', true);
