<?php
date_default_timezone_set('UTC');

//Test Suite bootstrap
include __DIR__ . "/../vendor/autoload.php";

use \Vegas\Session\Adapter\Files as SessionAdapter;

define('TESTS_ROOT_DIR', dirname(__FILE__));

$configArray = require_once dirname(__FILE__) . '/config.php';

$config = new \Phalcon\Config($configArray);

// \Phalcon\Mvc\Collection requires non-static binding of service providers.
class DiProvider
{
    public function resolve(\Phalcon\Config $config)
    {
        $di = new \Phalcon\DI\FactoryDefault();
        $di->set('config', $config, true);

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
            $connectionString = "mongodb://{$config->mongo->host}:{$config->mongo->port}";
            $mongo = new \MongoClient($connectionString);
            return $mongo->selectDb($config->mongo->dbname);
        }, true);

        /**
         * Start the session the first time some component request the session service
         */
        $di->set('session', function () use ($config) {
            $sessionAdapter = new SessionAdapter($config->session->toArray());
            if (!$sessionAdapter->isStarted()) {
                $sessionAdapter->start();
            }
            return $sessionAdapter;
        }, true);

        $di->set('sessionManager', function() use ($di) {
            $session = new Vegas\Session($di->get('session'));

            return $session;
        }, true);

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

        \Phalcon\DI::setDefault($di);
    }
}

require "fixtures/BaseUser.php";

(new \DiProvider)->resolve($config);