<?php
/** @var array $data */

use app\components\Escape;

$liker       = Escape::html($data['liker']);
$postOwner   = Escape::html($data['post_owner']);

return <<<MAIL
    <body>
        <h3>Hi, $postOwner!</h3>
        <p>We are happy to tell you, that your post was liked by <strong>$liker</strong></p>
        <p>You are awesome!</p>
    </body>
MAIL;
