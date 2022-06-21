<?php

namespace CartApp\Order\Model;

use CartApp\Core\Model\AbstractModel;

/**
 * Order class
 */
class Order extends AbstractModel
{
    use \CartApp\Core\Model\IdTrait;
    use \CartApp\Core\Model\CudLogTrait;

    /**
     * @var int
     */
    protected int $user_id;
    /**
     * @var int
     */
    protected int $offer_id;
    /**
     * @var string|null
     */
    protected ?string $info;
    /**
     * @var bool
     */
    protected bool $status;

    /**
     * @return void
     */
    public function initialize()
    {
        $this->setSchema('cart_app');
        $this->setSource('order');
        $this->initCudLog();
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getOfferId(): int
    {
        return $this->offer_id;
    }

    /**
     * @param int $offer_id
     */
    public function setOfferId(int $offer_id): void
    {
        $this->offer_id = $offer_id;
    }

    /**
     * @return string|null
     */
    public function getInfo(): ?string
    {
        return $this->info;
    }

    /**
     * @param string|null $info
     */
    public function setInfo(?string $info): void
    {
        $this->info = $info;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function validation()
    {
        $validator = new \Phalcon\Validation();

        $validator->add(
            [
                'offer_id',
                'status',
            ],
            new \Phalcon\Validation\Validator\PresenceOf(
                [
                    'message' => [
                        'offer_id' => 'The order offer_id is required',
                        'status' => 'The order status is required',
                    ],
                ]
            )
        );

        return $this->validate($validator);
    }
}