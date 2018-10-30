<?php

namespace app\components\inputForm;


interface Checker
{
    /**
     * @param array $itemsToCheck
     * @return bool
     */
    public function check(array $itemsToCheck): bool;
}
