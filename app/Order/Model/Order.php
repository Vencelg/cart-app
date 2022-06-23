<?php

namespace CartApp\Order\Model;

use CartApp\Core\Model\AbstractModel;
use CartApp\Offer\Model\Offer;
use CartApp\Order\Mapper\OrderMapper;

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
        $this->belongsTo(
            'offer_id', '\CartApp\Offer\Model\Offer', 'id',
            [
                'alias' => 'offer'
            ]
        );
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
     * @return Offer|null
     */
    public function getOffer(): ?Offer
    {
        return $this->getRelated('offer');
    }

    /**
     * @param Offer $offer
     * @return $this
     */
    public function setOffer(Offer $offer): self
    {
        $this->__set('offer', $offer);
        return $this;
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
     * @return void
     */
    public function beforeDelete(): void
    {
        $mqtt = $this->getDI()->getShared(\CartApp\Core\Service\MqttService::class);
        $mqtt->publish("deletedOrder/" . $this->getCreatedBy()->getId(), json_encode([
            'message' => 'Your ride order has been declined'
        ]));
    }

    /**
     * @return void
     */
    public function afterCreate(): void
    {
        $mqtt = $this->getDI()->getShared(\CartApp\Core\Service\MqttService::class);
        $offer = Offer::find($this->getOfferId());
        $mapper = new OrderMapper();
        $mqtt->publish("createdOrder/" . $this->getCreatedBy()->getId(), json_encode(['order' => $mapper->map($this)]));
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