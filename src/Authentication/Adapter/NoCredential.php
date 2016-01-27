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

namespace Vegas\Security\Authentication\Adapter;

use \Vegas\Security\Authentication\AuthenticationAbstract;
use \Vegas\Security\Authentication\AuthenticationInterface;
use Vegas\Security\Authentication\Exception\IdentityNotFoundException;
use \Vegas\Security\Authentication\GenericUserInterface;
use \Vegas\Security\Authentication\Identity As AuthenticationIdentity;

/**
 * Class NoCredential
 * @package Vegas\Security\Authentication\Adapter
 */
class NoCredential extends AuthenticationAbstract implements AuthenticationInterface
{
    /**
     * Authenticates user with identity
     *
     * @param \Vegas\Security\Authentication\GenericUserInterface $user
     * @param $credential
     * @throws \Vegas\Security\Authentication\Exception\IdentityNotFoundException
     * @return bool
     */
    public function authenticate(GenericUserInterface $user, $credential)
    {
        $userAttributes = $user->getAttributes();
        if (empty($userAttributes)) {
            throw new IdentityNotFoundException();
        }
        $this->store($user->getAttributes());

        return true;
    }

    /**
     * Ends session
     */
    public function logout()
    {
        $this->sessionBag->destroy();
    }

    /**
     * @return boolean
     */
    public function isAuthenticated()
    {
        return (boolean)($this->sessionBag != null && $this->sessionBag->get('authenticated'));
    }

    /**
     * Returns array of identity
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->sessionBag->get('identity');
    }

    /**
     * Stores user object in session
     *
     * @param array $attributes
     * @return mixed
     */
    protected function store(array $attributes)
    {
        $identityObject = new AuthenticationIdentity($attributes);
        $this->sessionBag->set('identity', $identityObject);
        $this->sessionBag->set('authenticated', true);

        return $attributes;
    }
}