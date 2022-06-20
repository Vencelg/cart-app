<?php

namespace CartApp\Offer;

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
        $offer = new Group([
            'namespace' => 'CartApp\Offer',
        ]);
        $offer->setPrefix('/api/v1/offer');

        $offer->addGet('', [
            'action' => 'list',
            'controller' => 'Controller\Offer'
        ]);

        $offer->addGet('/{id:[0-9]+}', [
            'action' => 'get',
            'controller' => 'Controller\Offer'
        ]);

        $offer->addPost('', [
            'action' => 'create',
            'controller' => 'Controller\Offer'
        ]);

        $offer->addPut('/{id:[0-9]+}', [
            'action' => 'update',
            'controller' => 'Controller\Offer'
        ]);

        $offer->addDelete('/{id:[0-9]+}', [
            'action' => 'delete',
            'controller' => 'Controller\Offer'
        ]);

        $router->mount($offer);
    }
}