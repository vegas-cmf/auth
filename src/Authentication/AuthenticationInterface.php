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
 
namespace Vegas\Security\Authentication;

/**
 *
 * @package Vegas\Security\Authentication
 */
interface AuthenticationInterface
{
    /**
     * @param GenericUserInterface $user
     * @param $credential
     * @return mixed
     */
    public function authenticate(GenericUserInterface $user, $credential);

    /**
     * @return mixed
     */
    public function isAuthenticated();

    /**
     * @return mixed
     */
    public function getIdentity();

    /**
     * @return mixed
     */
    public function logout();

    /**
     * @param GenericUserInterface $user
     * @return mixed
     */
    public function setUser(GenericUserInterface $user);
} 