<?php
/**
 * This file is part of Vegas package
 *
 * @author Arkadiusz Ostrycharz <arkadiusz.ostrycharz@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vegas\Security\Authentication\EventsManager\Exception;

use \Vegas\Security\Authentication\Exception as AuthenticationException;

/**
 * @package Vegas\Security\Authentication\Exception
 */
class RouteNotFoundException extends AuthenticationException
{
    protected $message = 'URL does not match any of known route.';
} 