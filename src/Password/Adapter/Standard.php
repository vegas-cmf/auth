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
namespace Vegas\Security\Password\Adapter;

use \Phalcon\DI;
use \Vegas\Security\Password\PasswordInterface;

/**
 * Class Standard
 * @package Vegas\Security\Password\Adapter
 */
class Standard implements PasswordInterface
{
    /** @var \Phalcon\DiInterface $di */
    protected $di;

    /**
     * Standard constructor.
     * @param \Phalcon\DiInterface $di
     */
    public function __construct(\Phalcon\DiInterface $di)
    {
        $this->di = $di;
    }

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
 