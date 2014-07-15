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
 
namespace Vegas\Security\Authentication\Exception;

use \Vegas\Security\Authentication\Exception as AuthenticationException;

/**
 * IdentityNotFoundException is thrown when identity does not exist
 *
 * @package Vegas\Security\Authentication\Exception
 */
class IdentityNotFoundException extends AuthenticationException
{
    protected $message = 'Identity not found';
} 