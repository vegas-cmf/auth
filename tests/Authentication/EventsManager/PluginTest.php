<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Vegas\Tests\Security\Authentication\EventsManager;

use Composer\Factory;
use Phalcon\DI;

class FakeAuth {

    public function isAuthenticated()
    {
        return true;
    }
}

class FakeNoAuth {

    public function isAuthenticated()
    {
        return false;
    }
}

class PluginTest extends \PHPUnit_Framework_TestCase
{
    private function runApplication($url, DI\FactoryDefault $di = null)
    {
        require_once dirname(__DIR__) . '/../fixtures/app/Bootstrap.php';
        $config = require dirname(__DIR__) . '/../fixtures/app/config/config.php';
        $config = new \Phalcon\Config($config);
        $bootstrap = new \Bootstrap($config);
        if ($di != null) {
            $bootstrap->setDi($di);
        }

        $bootstrap->setup()->run($url);
    }

    public function testNoAuthentication()
    {
        $this->runApplication('/products', null);

        $response = DI::getDefault()->getShared('response');
        $headers = $response->getHeaders();
        $this->assertEquals('302 Found', $headers->get('Status'));
        $this->assertEquals('/login', $headers->get('Location'));

        $response->resetHeaders();
    }

    public function testAuthenticated()
    {
        DI::getDefault()->set('authUser', function() {
            return new FakeAuth();
        }, true);

        $this->runApplication('/products', DI::getDefault());

        $response = DI::getDefault()->getShared('response');
        $headers = $response->getHeaders();

//        $this->assertEmpty($headers->get('Status'));
        $this->assertEmpty($headers->get('Location'));

        $router = DI::getDefault()->getShared('router');
        $this->assertEquals('/products', $router->getMatchedRoute()->getCompiledPattern());

        $response->resetHeaders();
    }


    public function testNoAuthenticated()
    {
        DI::getDefault()->set('authUser', function() {
            return new FakeNoAuth();
        }, true);

        $this->runApplication('/products', DI::getDefault());

        $response = DI::getDefault()->getShared('response');
        $headers = $response->getHeaders();

        $this->assertEquals('302 Found', $headers->get('Status'));
        $this->assertEquals('/login', $headers->get('Location'));

        $response->resetHeaders();
    }

    public function testNoAuthenticatedInAnotherScope()
    {
        //make test for `authUser` scope which trying to access resource where `authAdmin` is required
        DI::getDefault()->set('authUser', function() {
            return new FakeAuth();
        }, true);

        $this->runApplication('/categories', DI::getDefault());

        $response = DI::getDefault()->getShared('response');
        $headers = $response->getHeaders();

        $this->assertEquals('302 Found', $headers->get('Status'));
        $this->assertEquals('/admin/login', $headers->get('Location'));

        $response->resetHeaders();

        //make test for `authAdmin` scope which trying to access resource where `authUser` is required
        DI::getDefault()->remove('authUser');
        DI::getDefault()->set('authAdmin', function() {
            return new FakeAuth();
        }, true);

        $this->runApplication('/products', DI::getDefault());

        $response = DI::getDefault()->getShared('response');
        $headers = $response->getHeaders();

        $this->assertEquals('302 Found', $headers->get('Status'));
        $this->assertEquals('/login', $headers->get('Location'));

        $response->resetHeaders();
    }

    public function testAuthenticatedMultiscope()
    {
        DI::getDefault()->set('authAdmin', function() {
            return new FakeAuth();
        }, true);

        $this->runApplication('/multiauth', DI::getDefault());

        $response = DI::getDefault()->getShared('response');
        $headers = $response->getHeaders();

        $this->assertEmpty($headers->get('Status'));
        $this->assertEmpty($headers->get('Location'));

        $router = DI::getDefault()->getShared('router');
        $this->assertEquals('/multiauth', $router->getMatchedRoute()->getCompiledPattern());

        $response->resetHeaders();
    }


    public function testNoAuthenticatedMultiscope()
    {
        DI::getDefault()->set('authAdmin', function() {
            return new FakeNoAuth();
        }, true);

        $this->runApplication('/multiauth', DI::getDefault());

        $response = DI::getDefault()->getShared('response');
        $headers = $response->getHeaders();

        $this->assertEquals('302 Found', $headers->get('Status'));
        $this->assertEquals('/admin/login', $headers->get('Location'));

        $response->resetHeaders();
    }
} 