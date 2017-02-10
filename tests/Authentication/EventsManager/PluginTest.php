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
use Phalcon\Di;

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

        $response = Di::getDefault()->getShared('response');
        $headers = $response->getHeaders();
        $this->assertEquals('302 Found', $headers->get('Status'));
        $this->assertEquals('/login', $headers->get('Location'));

        $response->resetHeaders();
    }

    public function testAuthenticated()
    {
        Di::getDefault()->set('authUser', function() {
            return new FakeAuth();
        }, true);

        $this->runApplication('/products', Di::getDefault());

        $response = Di::getDefault()->getShared('response');
        $headers = $response->getHeaders();

//        $this->assertEmpty($headers->get('Status'));
        $this->assertEmpty($headers->get('Location'));

        $router = Di::getDefault()->getShared('router');
        $this->assertEquals('/products', $router->getMatchedRoute()->getCompiledPattern());

        $response->resetHeaders();
    }


    public function testNoAuthenticated()
    {
        Di::getDefault()->set('authUser', function() {
            return new FakeNoAuth();
        }, true);

        $this->runApplication('/products', Di::getDefault());

        $response = Di::getDefault()->getShared('response');
        $headers = $response->getHeaders();

        $this->assertEquals('302 Found', $headers->get('Status'));
        $this->assertEquals('/login', $headers->get('Location'));

        $response->resetHeaders();
    }

    public function testNoAuthenticatedInAnotherScope()
    {
        //make test for `authUser` scope which trying to access resource where `authAdmin` is required
        Di::getDefault()->set('authUser', function() {
            return new FakeAuth();
        }, true);

        $this->runApplication('/categories', Di::getDefault());

        $response = Di::getDefault()->getShared('response');
        $headers = $response->getHeaders();

        $this->assertEquals('302 Found', $headers->get('Status'));
        $this->assertEquals('/admin/login', $headers->get('Location'));

        $response->resetHeaders();

        //make test for `authAdmin` scope which trying to access resource where `authUser` is required
        Di::getDefault()->remove('authUser');
        Di::getDefault()->set('authAdmin', function() {
            return new FakeAuth();
        }, true);

        $this->runApplication('/products', Di::getDefault());

        $response = Di::getDefault()->getShared('response');
        $headers = $response->getHeaders();

        $this->assertEquals('302 Found', $headers->get('Status'));
        $this->assertEquals('/login', $headers->get('Location'));

        $response->resetHeaders();
    }

    public function testAuthenticatedMultiscope()
    {
        Di::getDefault()->set('authAdmin', function() {
            return new FakeAuth();
        }, true);

        $this->runApplication('/multiauth', Di::getDefault());

        $response = Di::getDefault()->getShared('response');
        $headers = $response->getHeaders();

        $this->assertEmpty($headers->get('Status'));
        $this->assertEmpty($headers->get('Location'));

        $router = Di::getDefault()->getShared('router');
        $this->assertEquals('/multiauth', $router->getMatchedRoute()->getCompiledPattern());

        $response->resetHeaders();
    }


    public function testNoAuthenticatedMultiscope()
    {
        Di::getDefault()->set('authAdmin', function() {
            return new FakeNoAuth();
        }, true);

        $this->runApplication('/multiauth', Di::getDefault());

        $response = Di::getDefault()->getShared('response');
        $headers = $response->getHeaders();

        $this->assertEquals('302 Found', $headers->get('Status'));
        $this->assertEquals('/admin/login', $headers->get('Location'));

        $response->resetHeaders();
    }

    /**
     * Verifies if auth is checked after forwarding from a route with no auth requirement
     */
    public function testForwardedAuthCheck()
    {
        Di::getDefault()->set('authUser', function() {
            return new FakeNoAuth();
        }, true);

        $this->runApplication('/forward', Di::getDefault());

        $response = Di::getDefault()->getShared('response');
        $headers = $response->getHeaders();

        $this->assertEquals('302 Found', $headers->get('Status'));
        $this->assertEquals('/login', $headers->get('Location'));

        $response->resetHeaders();
    }
} 