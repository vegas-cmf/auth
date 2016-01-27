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

class EmptyCollection implements GenericUserInterface
{
    public function getSource()
    {
        return 'vegas_users';
    }

    public function getIdentity()
    {
        return null;
    }

    public function getCredential()
    {
        return null;
    }

    public function getAttributes()
    {
        return [];
    }
}