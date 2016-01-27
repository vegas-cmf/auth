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

namespace Vegas\Security\Authentication\Adapter;

use \Vegas\Security\Authentication\AuthenticationAbstract;
use \Vegas\Security\Authentication\AuthenticationInterface;
use \Vegas\Security\Authentication\Exception\InvalidCredentialException;
use \Vegas\Security\Authentication\GenericUserInterface;
use \Vegas\Security\Authentication\Identity;

/**
 * Class Standard
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
        $identityObject = new Identity($attributes);
        $this->sessionBag->set('identity', $identityObject);
        $this->sessionBag->set('authenticated', true);

        return $attributes;
    }
}