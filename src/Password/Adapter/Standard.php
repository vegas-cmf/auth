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
namespace Vegas\Security\Password\Adapter;

use \Phalcon\Di\InjectionAwareInterface;
use \Vegas\Security\Password\PasswordInterface;

/**
 * Class Standard
 * @package Vegas\Security\Password\Adapter
 */
class Standard implements PasswordInterface, InjectionAwareInterface
{
    use \Vegas\Di\InjectionAwareTrait;
    
    /**
     * Encrypts password using Phalcon Security
     *
     * @param $password
     * @param bool $salt
     * @return mixed
     */
    public function encryptPassword($password, $salt = false)
    {
        return $this->di->get('security')->hash($password);
    }

    /**
     * Validates plain password with password hash
     *
     * @param $password
     * @param $passwordHash
     * @return mixed
     */
    public function validate($password, $passwordHash)
    {
        return $this->di->get('security')->checkHash($password, $passwordHash);
    }
}
 