<?php
/**
 * This file is part of Vegas package
 *
 * @author Arkadiusz Ostrycharz <arkadiusz.ostrycharz@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Vegas\Security\Authentication\Exception;

use \Vegas\Security\Authentication\Exception as AuthenticationException;

/**
 * NotAuthenticatedException is thrown when user is not authenticated.
 *
 * @package Vegas\Security\Authentication\Exception
 */
class NotAuthenticatedException extends AuthenticationException
{
    protected $message = 'User is not authenticated.';
} 