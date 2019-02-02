<div class="post__container">
    <p><?php echo $this->postData['date'] ?></p>
    <a href="/user/<?php echo $this->postData['username'] ?>">
        <?php echo $this->postData['username'] ?>
    </a>
    <img src="<?php echo $this->postData['image_path'] ?>" alt="">
</div>