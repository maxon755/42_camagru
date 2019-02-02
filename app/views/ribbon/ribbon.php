<?php
    use app\widgets\post\Post;
?>

<h1>Ribbon Content</h1>

<ul>
    <li>POST1</li>
    <li>POST2</li>
    <li>POST3</li>
    <li>POST4</li>
    <li>POST5</li>
</ul>

<?php $postsData = $parameters ?>

<?php foreach ($postsData as $postData) {
        (new Post($postData))->render();
    }
?>
