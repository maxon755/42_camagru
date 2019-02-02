<?php

namespace app\widgets\inputForm;


interface AvailabilityChecker
{
    /**
     * @param array $data
     * @return bool
     */
    public function isInputAvailable(array $data): bool;
}
