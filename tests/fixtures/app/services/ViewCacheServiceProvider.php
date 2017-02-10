<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://github.com/vegas-cmf
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ViewCacheServiceProvider implements \Vegas\Di\ServiceProviderInterface {

    const SERVICE_NAME = 'viewCache';


    /**
     * {@inheritdoc}
     */
    public function register(\Phalcon\DiInterface $di)
    {
        $config = $di->get('config');
        //Set the views cache service
        $di->set(self::SERVICE_NAME, function() use ($config) {

            //Cache data for one day by default
            $frontCache = new Phalcon\Cache\Frontend\Output(array(
                "lifetime" => 86400
            ));

            //File backend settings
            $cache = new Phalcon\Cache\Backend\File($frontCache, array(
                "cacheDir" => $config->application->cacheDir
            ));

            return $cache;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return array();
    }
}
 