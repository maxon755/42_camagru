<?php

namespace app\components;


interface Checker
{
    /**
     * @param array $itemsToCheck
     * @return bool
     */
    public function check(array $itemsToCheck): bool;
}
