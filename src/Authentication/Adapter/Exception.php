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

use Vegas\Security\Authentication\Exception as AuthenticationException;

/**
 * Class Exception
 * @package Vegas\Security\Authentication\Adapter
 */
class Exception extends AuthenticationException
{
    protected $message = 'Authentication adapter error';
} 