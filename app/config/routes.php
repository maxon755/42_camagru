<?php

return [
	'^$'                        => 'Ribbon/index',
	'^ribbon$'                  => 'Ribbon/index',
    '^ribbon/(.+)/(.+)$'        => 'Ribbon/$1/$2',
    '^ribbon/(.+)$'             => 'Ribbon/$1',
    '^login$'                   => 'Login/index',
    '^login/(.+)$'              => 'Login/$1',
    '^logout$'                  => 'Login/logout',
    '^sign-up$'                 => 'SignUp/index',
    '^sign-up/(.+)$'            => 'SignUp/$1',
    '^image$'                   => 'Image/index',
    '^image/(.+)$'              => 'Image/$1',
    '^settings$'                => 'Settings/index',
    '^settings/(.+)$'           => 'Settings/$1',
    '^restore-password$'        => 'RestorePassword/index',
    '^restore-password/(.+)$'   => 'RestorePassword/$1',
];
