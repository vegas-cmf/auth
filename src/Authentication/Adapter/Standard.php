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

namespace Vegas\Security\Authentication\Adapter;

use \Vegas\Security\Authentication\AuthenticationAbstract;
use \Vegas\Security\Authentication\AuthenticationInterface;
use \Vegas\Security\Authentication\Exception\InvalidCredentialException;
use \Vegas\Security\Authentication\GenericUserInterface;
use \Vegas\Security\Authentication\Identity;

/**
 * @package Vegas\Security\Authentication\Adapter
 */
class Standard extends AuthenticationAbstract implements AuthenticationInterface
{

    /**
     * Authenticates user with indicated credential
     *
     * @param \Vegas\Security\Authentication\GenericUserInterface $user
     * @param $credential
     * @throws \Vegas\Security\Authentication\Exception\InvalidCredentialException
     * @return bool
     */
    public function authenticate(GenericUserInterface $user, $credential)
    {
        $authenticationResult = $this->passwordManager->validate($credential, $user->getCredential());
        if (!$authenticationResult) {
            throw new InvalidCredentialException();
        }

        $this->store($user->getAttributes());

        return true;
    }

    /**
     * Ends session
     */
    public function logout()
    {
        return $this->sessionScope->destroy();
    }

    /**
     * @return boolean
     */
    public function isAuthenticated()
    {
        return (boolean)($this->sessionScope != null && $this->sessionScope->get('authenticated'));
    }

    /**
     * Returns array of identity
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->sessionScope->get('identity');
    }

    /**
     * Stores user object in session
     *
     * @param array $attributes
     * @return mixed
     */
    protected function store(array $attributes)
    {
        $identityObject = new Identity($attributes);
        $this->sessionScope->set('identity', $identityObject);
        $this->sessionScope->set('authenticated', true);

        return $attributes;
    }
}