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
namespace Vegas\Security\Password;

/**
 * Interface PasswordInterface
 * @package Vegas\Security\Password
 */
interface PasswordInterface
{
    /**
     * Encrypts password
     *
     * @param $password
     * @param bool $salt
     * @return mixed
     */
    public function encryptPassword($password, $salt = false);

    /**
     * Validates password
     *
     * @param $password
     * @param $hash
     * @return mixed
     */
    public function validate($password, $hash);
}
 