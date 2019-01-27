<header class="header">
    <a href="/">
        <p class="logo">Memogram</p>
    </a>

    <?php if (self::$auth->loggedIn()): ?>
        <?php echo $_COOKIE['username'] ?>

        <a href="/user/<?php echo $_COOKIE['username'] ?>">my page</a>
    <?php else: ?>
        <a href="/login">
            <p class="header__login">Log in</p>
        </a>
    <?php endif; ?>

    <a href="/image">Create image</a>

    <a href="/logout">logout</a>
</header>
