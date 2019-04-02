<?php
/** @var app\base\View $this */

use app\widgets\ribbon\Ribbon;

$this->registerCssFile('/widgets/post/post.css', true);

$username = $parameters['username'] ?? null;
?>

<?php (new Ribbon([
    'url'       => '/ribbon/get-posts/' . $username,
    'offset'    => 0,
    'limit'     => 1,
]))->render(); ?>

<div id="ribbon__spinner"></div>
