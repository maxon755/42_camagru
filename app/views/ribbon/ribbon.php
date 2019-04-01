<?php
/** @var app\base\View $this */

use app\widgets\ribbon\Ribbon;

$this->registerCssFile('/widgets/post/post.css', true);

?>

<?php (new Ribbon([
    'url'       => '/ribbon/get-posts',
    'offset'    => 0,
    'limit'     => 1,
]))->render(); ?>
<div id="ribbon__spinner"></div>
