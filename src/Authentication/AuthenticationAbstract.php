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

namespace Vegas\Security\Authentication;

use Phalcon\Session\Bag;
use Phalcon\Session\BagInterface;
use Vegas\Security\Password\PasswordInterface;

/**
 * @package Vegas\Security\Authentication
 */
abstract class AuthenticationAbstract
{
    /**
     * @var \Vegas\Security\Password\PasswordInterface
     */
    protected $passwordManager;

    /**
     * @var \Phalcon\Session\Bag
     */
    protected $sessionBag;

    /**
     *
     * @param PasswordInterface $passwordManager    Password manager for dealing with password hash
     */
    public function __construct(PasswordInterface $passwordManager = null)
    {
        $this->passwordManager = $passwordManager;
    }

    /**
     * @param BagInterface $sessionBag
     */
    public function setSessionStorage(BagInterface $sessionBag)
    {
        $this->sessionBag = $sessionBag;
    }

}