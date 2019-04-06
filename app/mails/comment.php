<?php
/** @var string $commentWriter */
/** @var string $postOwner */
/** @var string $commentText */

use app\components\Escape;

$commentText = nl2br(Escape::html($commentText));

return <<<MAIL
    <body>
        <h3>Hi, $postOwner!</h3>
        <p>We are happy to tell you, that your post was commented by <strong>$commentWriter</strong></p>
        <p>with text:</p>
        <p><i>"$commentText"</i></p>
    </body>
MAIL;
