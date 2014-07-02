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
 
namespace Vegas\Security\Authentication;

/**
 * Simple class for object representation identity
 *
 * @package Vegas\Security\Authentication
 */
class Identity 
{
    /**
     * Array of identity values
     *
     * @var array
     */
    private $values = array();

    /**
     * Creates identity object from provided values
     *
     * @param $values
     */
    public function __construct($values)
    {
        $this->values = $values;
    }

    /**
     * Makes identity values accessible by method calling
     * For example for get user ID
     * <code>
     * echo $this->get('authUser')->getIdentity()->getId();
     * </code>
     *
     * @param $name
     * @param $args
     * @return null
     */
    public function __call($name, $args)
    {
        if (strpos($name, 'get') !== -1) {
            $name = lcfirst(str_replace('get', '', $name));
            if (!isset($this->values[$name])) return null;

            return $this->values[$name];
        }

        return null;
    }

    /**
     * Makes identity values accessible as object property
     * For example for get user ID
     * <code>
     * echo $this->get('authUser')->getIdentity()->id;
     * </code>
     *
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        if (!isset($this->values[$name])) return null;

        return $this->values[$name];
    }

    /**
     * Returns identity values as array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->values;
    }
}