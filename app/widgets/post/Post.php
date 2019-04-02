<?php

namespace app\widgets\post;

use app\base\Widget;
use app\widgets\WidgetFillPropertiesTrait;
use app\widgets\WidgetInterface;
use app\widgets\WidgetNameGetterTrait;

class Post extends Widget implements WidgetInterface
{
    use WidgetNameGetterTrait;
    use WidgetFillPropertiesTrait;

    /** @var array  */
    private $postData;

    /** @var @var int */
    private $postId;

    /** @var string */
    private $username;

    /** @var string */
    private $date;

    /** @var int */
    private $likes;

    /** @var bool */
    private $liked;

    /** @var string */
    private $brokenFilePath;

    /** @var string */
    private $imagePath;

    /** @var array */
    private $comments;

    /** @var string */
    private $emailHash;

    public function __construct(array $postData, bool $async = false)
    {
        parent::__construct($postData, $async);
        $this->postData = $postData;
        $this->brokenFilePath = DS . 'widgets' . DS . 'post' . DS . 'broken-file.png';
    }

    public function render(array $params = []): void
    {
        include(__DIR__ . DS . 'post-layout.php');
    }
}
