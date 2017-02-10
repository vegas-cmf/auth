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

use Phalcon\Di;


class NoCredentialTest extends \PHPUnit_Framework_TestCase
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

        $auth = Di::getDefault()->get('authNoCredential');
        $this->assertTrue($auth->authenticate($user, null));

        $this->assertInstanceOf('\MongoId', $auth->getIdentity()->getId());
        $this->assertNotNull($auth->getIdentity()->getEmail());
    }

    public function testAuthenticateInvalidUser()
    {
        $user = \BaseUser::findFirst(array(array('email' => 'fake@email.com')));

        $auth = Di::getDefault()->get('authNoCredential');

        $this->assertEmpty($user);
        $this->assertNotInstanceOf('\Vegas\Security\Authentication\GenericUserInterface', $user);
        $this->setExpectedException('\PHPUnit_Framework_Error');
        //Argument 1 passed to Vegas\Security\Authentication::authenticate()
        //must implement interface Vegas\Security\Authentication\GenericUserInterface, boolean given
        $auth->authenticate($user, null);
    }
}
 