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

namespace Vegas\Security\Authentication;

use Vegas\Security\Password\PasswordInterface;
use Vegas\Session\ScopeInterface;

/**
 * @package Vegas\Security\Authentication
 */
abstract class AuthenticationAbstract
{
    /**
     * @var GenericUserInterface
     */
    protected $user;

    /**
     * @var \Vegas\Security\Password\PasswordInterface
     */
    protected $passwordManager;

    /**
     * @var \Vegas\Session\ScopeInterface
     */
    protected $sessionScope;

    /**
     *
     * @param PasswordInterface $passwordManager    Password manager for dealing with password hash
     */
    public function __construct(PasswordInterface $passwordManager)
    {
        $this->passwordManager = $passwordManager;
    }

    /**
     *
     * @param ScopeInterface $sessionScope
     */
    public function setSessionStorage(ScopeInterface $sessionScope)
    {
        $this->sessionScope = $sessionScope;
    }

    /**
     *
     * @param GenericUserInterface $user    User object with identity and password
     */
    public function setUser(GenericUserInterface $user)
    {
        $this->user = $user;
    }
} 