<?php

include '../base/Application.php';
include '../base/DataBase.php';
include '../components/CaseTranslator.php';

use app\base\DataBase;
use app\base\Application;

$config = require_once('database.php');

$db = DataBase::getInstance(null, $config);

$db->executeQuery('CREATE TABLE IF NOT EXISTS "User" (
    user_id         SERIAL PRIMARY KEY,
    username        VARCHAR(32) NOT NULL UNIQUE,
    email           VARCHAR(32) NOT NULL UNIQUE,
    password        VARCHAR(60) NOT NULL,
    first_name      VARCHAR(32),
    last_name       VARCHAR(32),
    is_active       BOOLEAN DEFAULT FALSE,
    activation_date TIMESTAMP DEFAULT current_timestamp
  );'
);

$db->useTable('User');

$db->insertIfNotExists([
    'username'      => 'test_user',
    'email'         => 'test_email@test.com',
    'password'      => password_hash('test_password', PASSWORD_BCRYPT),
    'first_name'    => 'test_name',
    'is_active'     => 1,
]);

$db->insertIfNotExists([
    'username'      => 'test_user2',
    'email'         => 'test_email2@test.com',
    'password'      => password_hash('test_password', PASSWORD_BCRYPT),
    'first_name'    => 'test_name2',
    'is_active'     => 0,
]);


$db->executeQuery('CREATE TABLE IF NOT EXISTS "tt" (
    user_id         SERIAL PRIMARY KEY,
    username        VARCHAR(32) NOT NULL UNIQUE
  );'
);

$db->useTable('tt');

$db->insertIfNotExists([
    'username'  => 'maks',
]);
