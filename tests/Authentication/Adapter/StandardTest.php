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

use \Phalcon\Di;
use Vegas\Db\Decorator\CollectionAbstract;
use Vegas\Security\Authentication\GenericUserInterface;

class StandardTest extends \PHPUnit_Framework_TestCase
{

    public static function setUpBeforeClass()
    {
        $sm = Di::getDefault()->get('sessionManager');
        if ($sm->isStarted()) {
            $sm->destroy();
        }
    }

    protected function createTempUser()
    {
        $email = uniqid().'@'.uniqid().'.com';
        $pass = 'test1234';
        $user = new \BaseUser();
        $user->email = $email;
        $user->raw_password = $pass;
        $user->save();

        return $user;
    }

    public function testAuthenticateValidUser()
    {
        $user = $this->createTempUser();

        $auth = Di::getDefault()->get('auth');
        $this->assertTrue($auth->authenticate($user, 'test1234'));

        $this->assertInstanceOf('\MongoId', $auth->getIdentity()->getId());
        $this->assertNotNull($auth->getIdentity()->getEmail());
    }

    public function testAuthenticateInvalidUser()
    {
        $user = $this->createTempUser();

        $auth = Di::getDefault()->get('auth');

        $this->setExpectedException('\Vegas\Security\Authentication\Exception\InvalidCredentialException');
        $auth->authenticate($user, 'pass1234');
    }
}
 