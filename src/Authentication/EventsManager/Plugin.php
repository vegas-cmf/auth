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
 
namespace Vegas\Security\Authentication\EventsManager;

use Phalcon\Events\Event,
    Phalcon\Mvc\User\Plugin as UserPlugin,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Acl;
use Vegas\Security\Authentication;

/**
 * Class Plugin
 * @package Vegas\Security\Authentication\EventsManager
 */
class Plugin extends UserPlugin
{
    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $matchedRoute = $this->router->getMatchedRoute();
        $paths = $matchedRoute->getPaths();
        if (!isset($paths['auth'])) {
            //authentication is disabled by default
            $authSessionKey = false;
        } else {
            $authSessionKey = $paths['auth'];
        }

        //checks if authentication was disabled
        if ($this->isAuthenticationDisabled($authSessionKey)) {
            return true;
        }

        //find the default route for current authentication scope
        $authRoute = $this->getAuthDefaultRoute($authSessionKey);

        if (!$this->getDI()->has($authSessionKey)) {
            return $this->setNotAuthenticated($authRoute);
        }

        //checks authentication
        $isAuthenticated = $this->getDI()->get($authSessionKey)->isAuthenticated();
        if (!$isAuthenticated) {
            return $this->setNotAuthenticated($authRoute);
        }
        return true;
    }

    /**
     * @param $authSessionKey
     * @return \Phalcon\Mvc\Router\RouteInterface
     */
    protected function getAuthDefaultRoute($authSessionKey)
    {
        //finds root route
        $rootRoute = $this->router->getRouteByName('root');

        $config = $this->getDI()->get('config');
        if (!isset($config->auth)) {
            return $rootRoute;
        }

        $authConfig = $config->auth->toArray();

        if (!isset($authConfig[$authSessionKey])) {
            return $rootRoute;
        }

        return $this->router->getRouteByName($authConfig[$authSessionKey]['route']);
    }

    /**
     * @param $authSessionKey
     * @return bool
     */
    protected function isAuthenticationDisabled($authSessionKey)
    {
        return ($authSessionKey == 'disabled' || !$authSessionKey);
    }

    /**
     * @param \Phalcon\Mvc\Router\RouteInterface $authRoute
     * @return bool
     */
    protected function setNotAuthenticated(\Phalcon\Mvc\Router\RouteInterface $authRoute)
    {
        if ($authRoute->getRouteId() != $this->router->getMatchedRoute()->getRouteId()) {
            //stores url which requires authentication
            $currentUrl = array();
            parse_str($this->request->getServer('QUERY_STRING'), $currentUrl);
            if (isset($currentUrl['_url'])) {
                $this->session->set('redirect_url', $currentUrl['_url']);
            }

            $response = $this->getDI()->getShared('response');
            $response->redirect(array(
                'for'   =>  $authRoute->getName()
            ));
        }

        //needs to stop dispatching
        return false;
    }
}