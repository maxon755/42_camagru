<?php

return array(
	'^$'                => 'Ribbon/index',
    '^login$'           => 'Login/index',
    '^login/(.+)$'      => 'Login/$1',
    '^sign-up$'         => 'SignUp/index',
    '^sign-up/(.+)$'    => 'SignUp/$1',
    '^empty/(.+)$'      => 'Empty/$1',
);
