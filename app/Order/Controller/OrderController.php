<?php

namespace CartApp\Order\Controller;

use CartApp\Core\Controller\AbstractController;
use CartApp\Core\Exception\BaseException;
use CartApp\Order\Mapper\OrderMapper;
use CartApp\Order\Model\Order;
use CartApp\User\Model\User;

/**
 * OrderController class
 */
class OrderController extends AbstractController
{
    /**
     * @var OrderMapper
     */
    protected OrderMapper $mapper;

    /**
     * @return void
     */
    public function initialize()
    {
        $this->mapper = new OrderMapper();
    }

    /**
     * @return array
     */
    public function listAction(): array
    {
        $orders = Order::find();

        return $this->mapper->mapCollection($orders);
    }

    /**
     * @param int $id
     * @return array
     * @throws BaseException
     */
    public function getAction(int $id): array
    {
        $order = Order::find($id);

        if (!($order instanceof Order)) {
            throw new BaseException("Order with ID: $id not found.", 404);
        }

        return $this->mapper->map($order);
    }

    /**
     * @return array
     */
    public function createAction(): array
    {
        $request = $this->request->getJsonRawBody();

        $order = new Order();
        $order->setOfferId($request->offer_id);
        $order->setStatus(false);

        if (isset($request->info)) {
            $order->setInfo($request->info);
        } else {
            $order->setInfo(null);
        }

        if ($this->user instanceof User) {
            $order->setUserId($this->user->getId());
            $order->setCreatedBy($this->user);
        }

        $order->save();
        return $this->mapper->map($order);
    }

    /**
     * @param int $id
     * @return array
     * @throws BaseException
     */
    public function updateAction(int $id): array
    {
        $order = Order::findFirst($id);
        if (!($order instanceof Order)) {
            throw new BaseException("Order with ID: $id not found.", 404);
        }

        $request = $this->request->getJsonRawBody();

        $order->setStatus($request->status);
        $order->setUpdatedBy($this->user);

        if (isset($request->info)) {
            $order->setInfo($request->info);
        } else {
            $order->setInfo(null);
        }

        $order->save();

        return $this->mapper->map($order);
    }

    /**
     * @param int $id
     * @return array
     * @throws BaseException
     */
    public function deleteAction(int $id): array
    {
        $order = Order::findFirst($id);
        if (!($order instanceof Order)) {
            throw new \CartApp\Core\Exception\BaseException("Order with ID: $id not found.", 404);
        }

        $order->delete();
        return [];
    }
}