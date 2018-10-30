<?php

namespace app\components\inputForm;


interface AvailabilityChecker
{
    /**
     * @param array $data
     * @return bool
     */
    public function isInputAvailable(array $data): bool;
}
