<?php

namespace app\widgets;

interface WidgetInterface
{
    public function render(array $params = []): void;
}