<header class="header">
    <a href="/">
        <p class="logo">Memogram</p>
    </a>

    <?php if (isset($_COOKIE['username'])): ?>
        <?php echo $_COOKIE['username'] ?>

        <a href="/user/<?php echo $_COOKIE['username'] ?>">my page</a>
    <?php else: ?>
        <a href="/login">
            <p class="header__login">Log in</p>
        </a>
    <?php endif; ?>
</header>
