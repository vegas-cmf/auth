<?php
//Test Suite bootstrap
include __DIR__ . "/../vendor/autoload.php";

use \Vegas\Session\Adapter\Files as SessionAdapter;

define('TESTS_ROOT_DIR', dirname(__FILE__));

$configArray = require_once dirname(__FILE__) . '/config.php';

$config = new \Phalcon\Config($configArray);
$di = new \Phalcon\DI\FactoryDefault();

/**
 * Collection manager
 */
$di->set('collectionManager', function(){
    return new \Phalcon\Mvc\Collection\Manager();
}, true);

/**
 * MongoDB connection
 */
$di->set('mongo', function() use ($config) {
    $mongo = new \MongoClient();
    return $mongo->selectDb($config->mongo->db);
}, true);

/**
 * Start the session the first time some component request the session service
 */
//$di->set('session', function () use ($config) {
//    $sessionAdapter = new SessionAdapter($config->session->toArray());
//    if (!$sessionAdapter->isStarted()) {
//        $sessionAdapter->start();
//    }
//    return $sessionAdapter;
//}, true);
//
//$di->set('sessionManager', function() use ($di) {
//    $session = new Vegas\Session($di->get('session'));
//
//    return $session;
//}, true);

/**
 * Password manager for standard user
 */
$di->set('userPasswordManager', '\Vegas\Security\Password\Adapter\Standard', true);

/**  authentications **/
//standard user
$di->set('auth', function() use ($di) {
    $adapter = new \Vegas\Security\Authentication\Adapter\Standard($di->get('userPasswordManager'));
    $adapter->setSessionStorage($di->get('sessionManager')->createScope('auth'));
    $auth = new \Vegas\Security\Authentication($adapter);

    return $auth;
}, true);
//no credential
$di->set('authNoCredential', function() use ($di) {
    $adapter = new \Vegas\Security\Authentication\Adapter\NoCredential();
    $adapter->setSessionStorage($di->get('sessionManager')->createScope('authUser'));
    $auth = new \Vegas\Security\Authentication($adapter);

    return $auth;
}, true);

//require "tests/Stub/Models/BaseUser.php";

\Phalcon\DI::setDefault($di);