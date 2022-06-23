<?php

namespace CartApp\Order\Router;

use CartApp\Core\Application\RouterInterface;
use Phalcon\Mvc\Router\Group;

/**
 * Router class
 */
class Router implements RouterInterface
{

    /**
     * @param \Phalcon\Mvc\Router $router
     * @return void
     */
    public function register(\Phalcon\Mvc\Router $router)
    {
        $order = new Group([
            'namespace' => 'CartApp\Order',
        ]);
        $order->setPrefix('/api/v1/order');

        $order->addGet('', [
            'action' => 'list',
            'controller' => 'Controller\Order'
        ]);

        $order->addGet('/{id:[0-9]+}', [
            'action' => 'get',
            'controller' => 'Controller\Order',
        ]);

        $order->addPost('', [
            'action' => 'create',
            'controller' => 'Controller\Order',
        ]);

        $order->addPut('/{id:[0-9]+}', [
            'action' => 'update',
            'controller' => 'Controller\Order',
        ]);

        $order->addDelete('/{id:[0-9]+}', [
            'action' => 'delete',
            'controller' => 'Controller\Order',
        ]);

        $router->mount($order);
    }
}