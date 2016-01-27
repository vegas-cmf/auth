<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vegas\Tests\Stub\Models;

use Vegas\Security\Authentication\GenericUserInterface;

class BaseUser implements GenericUserInterface
{
    public $email;

    public $password;

    public function getSource()
    {
        return 'vegas_users';
    }

    public function getIdentity()
    {
        return $this->email;
    }

    public function getCredential()
    {
        return $this->password;
    }

    public function getAttributes()
    {
        $userData['email'] = $this->email;

        return $userData;
    }
}