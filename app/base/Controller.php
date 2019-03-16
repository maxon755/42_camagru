<?php

namespace app\base;

class Controller extends Application
{
    protected function render($renderUnit, $useComponents, array $parameters = [])
    {
        (View::getInstance())->render($renderUnit, $useComponents, $parameters);
    }

    /**
     * @param bool $success
     * @param array $data
     * @return string
     */
    protected function jsonResponse(bool $success, array $data = []): string
    {
        return json_encode(array_merge([
            'success' => $success,
        ], $data));
    }
}
