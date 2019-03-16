<?php

return array(
	'^$'                => 'Ribbon/index',
    '^ribbon/(.+)$'     => 'Ribbon/$1',
    '^login$'           => 'Login/index',
    '^login/(.+)$'      => 'Login/$1',
    '^logout$'          => 'Login/logout',
    '^sign-up$'         => 'SignUp/index',
    '^sign-up/(.+)$'    => 'SignUp/$1',
    '^image$'           => 'Image/index',
    '^image/(.+)$'      => 'Image/$1',
    '^settings$'        => 'Settings/index',
    '^empty/(.+)$'      => 'Empty/$1',
);
