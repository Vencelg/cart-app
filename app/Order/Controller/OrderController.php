<?php

namespace CartApp\Order\Controller;

use CartApp\Core\Controller\AbstractController;
use CartApp\Core\Exception\BaseException;
use CartApp\Order\Mapper\OrderMapper;
use CartApp\Order\Model\Order;
use CartApp\Order\Validator\CreateActionValidator;
use CartApp\Order\Validator\UpdateActionValidator;
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
        $validator = new CreateActionValidator([
            'offer_id' => $request->offer_id,
        ]);

        $validation = $validator->validate();

        if ($validation['errorsSet']) {
            throw new BaseException($validation['messages'], 422);
        }

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
        $request = $this->request->getJsonRawBody();
        $validator = new UpdateActionValidator([
            'info' => $request->info,
            'status' => $request->status,
        ]);

        $validation = $validator->validate();

        if ($validation['errorsSet']) {
            throw new BaseException($validation['messages'], 422);
        }

        $order = Order::findFirst($id);
        if (!($order instanceof Order)) {
            throw new BaseException("Order with ID: $id not found.", 404);
        }

        $order->setStatus($request->status ?? $order->isStatus());
        $order->setInfo($request->info ?? $order->getInfo());
        $order->setUpdatedBy($this->user);

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