<?php

include '../base/Application.php';
include '../base/DataBase.php';
include '../components/CaseTranslator.php';

use app\base\DataBase;

$config = require_once('database.php');

$db = DataBase::getInstance(null, $config);

$db->executeQuery('CREATE TABLE IF NOT EXISTS client (
    user_id         SERIAL PRIMARY KEY,
    username        VARCHAR(32) NOT NULL UNIQUE,
    email           VARCHAR(32) NOT NULL UNIQUE,
    password        VARCHAR(60) NOT NULL,
    first_name      VARCHAR(32),
    last_name       VARCHAR(32),
    is_active       BOOLEAN DEFAULT FALSE,
    like_notify     BOOLEAN DEFAULT TRUE,
    comment_notify  BOOLEAN DEFAULT TRUE,
    activation_code VARCHAR(16),
    activation_date TIMESTAMP DEFAULT NOW()
  );'
);

$db->useTable('client');

$db->insertIfNotExists([
    'username'      => 'test_user',
    'email'         => 'test_email@test.com',
    'password'      => password_hash('random', PASSWORD_BCRYPT),
    'first_name'    => 'test_name',
    'is_active'     => 1,
]);

$db->insertIfNotExists([
    'username'      => 'test_user2',
    'email'         => 'test_email2@test.com',
    'password'      => password_hash('random', PASSWORD_BCRYPT),
    'first_name'    => 'test_name2',
    'is_active'     => 0,
]);


$db->executeQuery('CREATE TABLE IF NOT EXISTS auth_token (
    user_id         INTEGER PRIMARY KEY REFERENCES client(user_id),
    token           VARCHAR(60)
  );'
);

$db->executeQuery('CREATE TABLE IF NOT EXISTS post (
    post_id         SERIAL PRIMARY KEY,
    user_id         INTEGER NOT NULL REFERENCES client(user_id) ON DELETE CASCADE,
    image_name      VARCHAR(32) NOT NULL,
    number          INTEGER NOT NULL,
    is_deleted      BOOLEAN DEFAULT FALSE,
    creation_date   TIMESTAMP DEFAULT NOW()
  );'
);

$db->executeQuery('CREATE TABLE IF NOT EXISTS post_like (
    post_id INTEGER REFERENCES post(post_id) ON DELETE CASCADE,
    client_id INTEGER REFERENCES client(user_id),
    PRIMARY KEY (post_id, client_id)
)');

$db->executeQuery('CREATE TABLE IF NOT EXISTS comment (
    comment_id    SERIAL PRIMARY KEY,
    post_id       INTEGER NOT NULL REFERENCES post(post_id) ON DELETE CASCADE,
    user_id       INTEGER NOT NULL REFERENCES client(user_id),
    creation_date TIMESTAMP NOT NULL DEFAULT NOW(),
    comment       text NOT NULL
)');

$db->executeQuery('CREATE TABLE IF NOT EXISTS password_token (
    user_id     INTEGER PRIMARY KEY REFERENCES client(user_id),
    token       VARCHAR(23)
)');
