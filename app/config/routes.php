<?php

return array(
	'^$'                => 'Ribbon/index',
    '^login$'           => 'Login/index',
    '^login/(.+)$'      => 'Login/$1',
    '^logout$'          => 'Login/logout',
    '^sign-up$'         => 'SignUp/index',
    '^sign-up/(.+)$'    => 'SignUp/$1',
    '^image$'           => 'Image/index',
    '^image/(.+)$'      => 'Image/$1',
    '^empty/(.+)$'      => 'Empty/$1',
);
