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

namespace Vegas\Tests\Security\Authentication\Adapter;

use \Phalcon\DI;
use Phalcon\Session\Bag;
use Vegas\Security\Authentication;
use Vegas\Tests\Stub\Models\BaseUser;
use Vegas\Tests\Stub\Models\EmptyCollection;

class NoCredentailAdapterTest extends \PHPUnit_Framework_TestCase
{
    /** @var Authentication $auth */
    private $auth;

    const AUTH_SCOPE_NAME = 'test';

    const PASSWORD = 'test1234';

    protected function createTempUser()
    {
        $email = uniqid().'@'.uniqid().'.com';
        $pass = self::PASSWORD;
        $user = new BaseUser();
        $user->email = $email;
        $user->password = DI::getDefault()->get('security')->hash($pass);

        return $user;
    }

    protected function setUp()
    {
        $passwordAdapter = new \Vegas\Security\Password\Adapter\Standard(DI::getDefault());
        $adapter = new \Vegas\Security\Authentication\Adapter\NoCredential($passwordAdapter);
        $adapter->setSessionStorage(new Bag(self::AUTH_SCOPE_NAME));

        $this->auth = new \Vegas\Security\Authentication($adapter);
    }

    public function testShouldAuthorizeUser()
    {
        $user = $this->createTempUser();
        $this->auth->authenticate($user, null);

        $this->assertTrue($this->auth->isAuthenticated());
    }

    public function testShouldCheckUserEntity()
    {
        $user = $this->createTempUser();
        $this->auth->authenticate($user, self::PASSWORD);

        $identity = $this->auth->getIdentity();
        $this->assertEquals($user->email, $identity->email);
    }

    public function testShouldLogoutUser()
    {
        $user = $this->createTempUser();
        $this->auth->authenticate($user, self::PASSWORD);
        $this->auth->logout();

        $this->assertFalse($this->auth->isAuthenticated());
    }

    public function testShouldCheckInvalidEntity()
    {
        $empty = new EmptyCollection();
        $this->setExpectedException('\Vegas\Security\Authentication\Exception\IdentityNotFoundException');

        $this->auth->authenticate($empty, self::PASSWORD);
    }
}
 