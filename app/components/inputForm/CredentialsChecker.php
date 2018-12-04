<?php

namespace app\components\inputForm;


interface CredentialsChecker
{
    /**
     * @param array $data
     * @return bool
     */
    public function checkCredentials(array $data): bool;
}
