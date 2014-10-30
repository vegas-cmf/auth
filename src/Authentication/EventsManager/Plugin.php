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
    protected $authSessionKeys;

    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @throws Exception\RouteNotFoundException
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $this->authSessionKeys = $this->getAuthenticationScopes();

        //checks if authentication was disabled
        if ($this->isAuthenticationDisabled()) {
            return true;
        }

        return $this->authenticate();
    }

    /**
     * @return bool
     */
    protected function authenticate()
    {
        //find the default route for current authentication scope
        $authRoute = $this->getAuthDefaultRoute();

        foreach ($this->authSessionKeys As $authSessionKey) {
            if ($this->getDI()->has($authSessionKey) && $this->getDI()->get($authSessionKey)->isAuthenticated()) {
                return true;
            }
        }

        return $this->setNotAuthenticated($authRoute);
    }

    /**
     * Return array of all used authentication scopes for current route.
     *
     * @return array
     */
    protected function getAuthenticationScopes()
    {
        $matchedRoute = $this->router->getMatchedRoute();
        if (!$matchedRoute) {
            return array(false);
        }

        $paths = $matchedRoute->getPaths();

        if (empty($paths['auth'])) {
            return array(false);
        }

        $auth = json_decode($paths['auth']);
        if (is_array($auth)) {
            return $auth;
        }

        return array($paths['auth']);
    }

    /**
     * @return \Phalcon\Mvc\Router\RouteInterface
     */
    protected function getAuthDefaultRoute()
    {
        //finds root route
        $rootRoute = $this->router->getRouteByName('root');

        $config = $this->getDI()->get('config');
        if (!isset($config->auth)) {
            return $rootRoute;
        }

        $authConfig = $config->auth->toArray();

        foreach ($this->authSessionKeys As $authSessionKey) {
            if (isset($authConfig[$authSessionKey])) {
                return $this->router->getRouteByName($authConfig[$authSessionKey]['route']);
            }
        }

        return $rootRoute;
    }

    /**
     * @return bool
     */
    protected function isAuthenticationDisabled()
    {
        foreach ($this->authSessionKeys As $authSessionKey) {
            if ($authSessionKey == 'disabled' || !$authSessionKey) {
                return true;
            }
        }
        return false;
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

            if (!$response->isSent()) {
                $response->send();
            }
        }

        //needs to stop dispatching
        return false;
    }
}