<?php
/** @var array $data */

use app\components\Escape;

$commentWriter  = Escape::html($data['comment_writer']);
$postOwner      = Escape::html($data['post_owner']);
$commentText    = nl2br(Escape::html($data['comment_text']));

return <<<MAIL
    <body>
        <h3>Hi, $postOwner!</h3>
        <p>We are happy to tell you, that your post was commented by <strong>$commentWriter</strong></p>
        <p>with text:</p>
        <p><i>"$commentText"</i></p>
    </body>
MAIL;
