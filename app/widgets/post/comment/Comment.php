<?php

namespace app\widgets\post\comment;

use app\base\Widget;
use app\widgets\WidgetInterface;

class Comment extends Widget implements WidgetInterface
{
    /** @var array */
    private $commentData;

    public function __construct(array $commentData)
    {
        parent::__construct();
        $this->commentData = $commentData;
    }

    public function render(array $params = []): void
    {
        // TODO: Implement render() method.
    }
}