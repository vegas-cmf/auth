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

use Phalcon\Di;
use Vegas\Db\Mapping\Json;
use Vegas\Db\MappingManager;

class Bootstrap extends \Vegas\Mvc\Bootstrap
{
    public function setup()
    {
        parent::setup();
        $this->initDbMappings();

        return $this;
    }

    protected function initDbMappings()
    {
        $mappingManager = new MappingManager();
        $mappingManager->add(new Json());
    }

    /**
     * Start handling MVC requests
     *
     * @param null $uri
     * @return string
     */
    public function run($uri = null)
    {
        return $this->application->handle($uri)->getContent();
    }
} 