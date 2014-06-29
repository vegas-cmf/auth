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

use Vegas\Mvc\Controller\ControllerAbstract;
use Vegas\Http\Response\Json as JsonResponse;

class TestController extends ControllerAbstract
{
    public function indexAction()
    {
        $response = new JsonResponse();
        $response->success()->setData(array('test' => 'value'))->setMessage('index OK');
        return $this->jsonResponse($response);
    }

    public function createAction()
    {
        $response = new JsonResponse();
        $response->success()->setData(array('test' => 'value'))->setMessage('create OK');
        return $this->jsonResponse($response);
    }

    public function updateAction()
    {
        $response = new JsonResponse();
        $response->success()->setData(array('test' => 'value'))->setMessage('update OK');
        return $this->jsonResponse($response);
    }

    public function deleteAction()
    {
        $response = new JsonResponse();
        $response->success()->setData(array('test' => 'value'))->setMessage('delete OK');
        return $this->jsonResponse($response);
    }

    public function showAction()
    {
        $response = new JsonResponse();
        $response->success()->setData(array('test' => 'value'))->setMessage('show OK');
        return $this->jsonResponse($response);
    }
} 