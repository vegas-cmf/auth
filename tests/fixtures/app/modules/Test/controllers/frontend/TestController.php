<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @Testpage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Test\Controllers\Frontend;

use Vegas\Mvc\ControllerAbstract;

class TestController extends ControllerAbstract
{
    public function indexAction()
    {
        $this->response->setStatusCode(200, 'index OK');
        return $this->jsonResponse(array('test' => 'value'));
    }

    public function createAction()
    {
        $this->response->setStatusCode(200, 'create OK');
        return $this->jsonResponse(array('test' => 'value'));
    }

    public function updateAction()
    {
        $this->response->setStatusCode(200, 'update OK');
        return $this->jsonResponse(array('test' => 'value'));
    }

    public function deleteAction()
    {
        $this->response->setStatusCode(200, 'delete OK');
        return $this->jsonResponse(array('test' => 'value'));
    }

    public function showAction()
    {
        $this->response->setStatusCode(200, 'show OK');
        return $this->jsonResponse(array('test' => 'value'));
    }
} 