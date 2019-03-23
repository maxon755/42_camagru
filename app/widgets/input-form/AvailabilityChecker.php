<?php

namespace app\widgets\inputForm;


interface AvailabilityChecker
{
    /**
     * @param array $where
     * @return bool
     */
    public function isInputAvailable(array $where): bool;
}
