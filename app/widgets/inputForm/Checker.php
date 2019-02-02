<?php

namespace app\widgets\inputForm;


interface Checker
{
    /**
     * @param array $itemsToCheck
     * @return bool
     */
    public function check(array $itemsToCheck): bool;
}
