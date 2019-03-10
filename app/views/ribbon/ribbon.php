<?php
/** @var app\base\View $this */

use app\widgets\inputForm\InputForm;
use app\widgets\post\Post;
use app\widgets\ribbon\Ribbon;

$this->registerCssFile('/widgets/post/post.css', true);
$this->registerJsFile('/widgets/post/post.js', true);

$form = new InputForm('testForm', 'www', '/action/', 'post', [
        new app\widgets\inputForm\components\inputField\InputField('comment', 'text', false),
]);

$form->render();
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
