<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
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
use Vegas\Security\Password\Adapter\Standard;
use Vegas\Tests\Stub\Models\BaseUser;

class IdentityTest extends \PHPUnit_Framework_TestCase
{
    /** @var Standard $passwordAdapter */
    private $passwordAdapter;

    const PASSWORD = 'test1234';

    protected function createTempUser()
    {
        $email = uniqid().'@'.uniqid().'.com';
        $pass = 'test1234';

        $user = new BaseUser();
        $user->email = $email;
        $user->password = $this->passwordAdapter->encryptPassword($pass);

        return $user;
    }

    protected function setUp()
    {
        $this->passwordAdapter = new \Vegas\Security\Password\Adapter\Standard(DI::getDefault());
    }

    public function testCheckIdentityGetter()
    {
        $user = $this->createTempUser();
        $identity = new Authentication\Identity($user->getAttributes());

        $identityArray = $identity->toArray();

        $this->assertEquals($user->email, $identity->getEmail());
        $this->assertEquals($user->email, $identityArray['email']);


        $this->assertNull($identity->setPassword('test'));
    }


}
 