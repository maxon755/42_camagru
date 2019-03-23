<?php
/** @var \app\base\View self */
/** @var \app\base\View $this */

$username = self::$auth->getUserName();
$this->registerJsFile('/template/header/header.js', true);
?>

<nav class="nav align-items-center container-fluid">
        <a href="/" class="nav-link white nav-item">Memogram</a>

        <?php if (self::$auth->loggedIn()): ?>
            <div class="dropdown right">
                <a href="#" class="nav-link dropdown-toggle white nav-item" data-toggle="dropdown"><?= $username ?></a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/user/<?= $username ?>" >My Page</a>
                    <a class="dropdown-item" href="/settings">Settings</a>
                    <a class="dropdown-item" href="/image">Create Post</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/logout">Logout</a>
                </div>
            </div>

        <?php else: ?>
            <a class="nav-link right white nav-item" href="/login">Log in</a>

        <?php endif ?>
</nav>
