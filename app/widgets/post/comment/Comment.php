<?php

namespace app\widgets\post\comment;

use app\base\Widget;
use app\widgets\WidgetFillPropertiesTrait;
use app\widgets\WidgetInterface;
use app\widgets\WidgetNameGetterTrait;

class Comment extends Widget implements WidgetInterface
{
    use WidgetNameGetterTrait;
    use WidgetFillPropertiesTrait;

    /** @var array */
    private $commentId;

    private $userId;

    /** @var string */
    private $user;

    /** @var string */
    private $date;

    /** @var string */
    private $comment;

    public function __construct(array $commentData, bool $async = false)
    {
        parent::__construct($commentData, $async);
        $this->commentData = $commentData;
    }

    public function render(array $params = []): void
    {
        include(__DIR__ . DS . 'comment-layout.php');
    }
}