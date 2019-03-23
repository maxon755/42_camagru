<header class="header">
    <a href="/">
        <p class="logo">Memogram</p>
    </a>

    <?php if (self::$auth->loggedIn()): ?>
        <?= $_COOKIE['username'] ?>

        <a href="/user/<?= $_COOKIE['username'] ?>">my page</a>
        <a href="/settings">settings</a>
    <?php else: ?>
        <a href="/login">
            <p class="header__login">Log in</p>
        </a>
    <?php endif ?>

    <a href="/image">Create image</a>

    <a href="/logout">logout</a>
</header>
