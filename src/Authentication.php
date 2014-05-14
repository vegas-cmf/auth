<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vegas\Security;

use Vegas\Security\Authentication\AuthenticationInterface;
use Vegas\Security\Authentication\GenericUserInterface;
use Vegas\Session\Scope;

/**
 * Class Authentication
 * @package Vegas\Security
 */
class Authentication
{
    const DEFAULT_SESSION_KEY = 'auth';

    /**
     * @var Authentication\AuthenticationInterface
     */
    protected $authenticator;

    /**
     * @param AuthenticationInterface $authenticator
     */
    public function __construct(AuthenticationInterface $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     *
     * @param Authentication\GenericUserInterface $user
     * @param $password
     * @return mixed
     */
    public function authenticate(GenericUserInterface $user, $password)
    {
        return $this->authenticator->authenticate($user, $password);
    }

    /**
     *
     * @return mixed
     */
    public function logout()
    {
        return $this->authenticator->logout();
    }

    /**
     * @return boolean
     */
    public function isAuthenticated()
    {
        return $this->authenticator->isAuthenticated();
    }

    /**
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->authenticator->getIdentity();
    }

    /**
     * @return AuthenticationInterface
     */
    public function getAdapter()
    {
        return $this->authenticator;
    }
}