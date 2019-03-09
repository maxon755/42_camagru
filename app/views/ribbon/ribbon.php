<?php
/** @var app\base\View $this */

use app\widgets\post\Post;
use app\widgets\ribbon\Ribbon;

$this->registerCssFile('/widgets/post/post.css', true);
$this->registerJsFile('/widgets/post/post.js', true);
?>

<h1>Ribbon Content</h1>

<div id="ribbon__container">

</div>
<div id="ribbon__spinner"></div>

<?php //$postsData = $parameters ?>
<!---->
<?php //foreach ($postsData as $postData) {
//        (new Post($postData))->render();
//    }
//?>
