<?php
/**
 * @author Sławomir Żytko <slawek@amsterdam-standard.pl>
 * @copyright (c) 2014, Amsterdam Standard
 */

namespace Vegas\Security\Authentication;

/**
 *
 * @package Vegas\Security\Authentication
 */
interface GenericUserInterface
{
    /**
     * Return user identity
     *
     * @return mixed
     */
    public function getIdentity();

    /**
     * Returns hashed password
     *
     * @return mixed
     */
    public function getCredential();

    /**
     * Returns additional attributes
     *
     * @return mixed
     */
    public function getAttributes();
}
 