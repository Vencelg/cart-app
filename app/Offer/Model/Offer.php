<?php

namespace CartApp\Offer\Model;

use CartApp\Core\Model\AbstractModel;

/**
 * Offer class
 */
class Offer extends AbstractModel
{
    use \CartApp\Core\Model\IdTrait;
    use \CartApp\Core\Model\CudLogTrait;

    /**
     * @var string
     */
    protected string $start;
    /**
     * @var string
     */
    protected string $finish;
    /**
     * @var int
     */
    protected int $price;
    /**
     * @var int
     */
    protected int $space;
    /**
     * @var string
     */
    protected string $departure;

    protected int $user_id;

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
     * @return void
     */
    public function initialize()
    {
        $this->setSchema('cart_app');
        $this->setSource('offer');
        $this->initCudLog();
    }

    /**
     * @return string
     */
    public function getStart(): string
    {
        return $this->start;
    }

    /**
     * @param string $start
     */
    public function setStart(string $start): void
    {
        $this->start = $start;
    }

    /**
     * @return string
     */
    public function getFinish(): string
    {
        return $this->finish;
    }

    /**
     * @param string $finish
     */
    public function setFinish(string $finish): void
    {
        $this->finish = $finish;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getSpace(): int
    {
        return $this->space;
    }

    /**
     * @param int $space
     */
    public function setSpace(int $space): void
    {
        $this->space = $space;
    }

    /**
     * @return string
     */
    public function getDeparture(): string
    {
        return $this->departure;
    }

    /**
     * @param string $departure
     */
    public function setDeparture(string $departure): void
    {
        $this->departure = $departure;
    }

    public function findForOrder(int $id)
    {
        return self::findFirst([
            'conditions' => 'id = ?1',
            'bind' => [
                1 => $id,
            ]
        ]);
    }

    /**
     * Offer validation
     *
     * @return bool
     */
    public function validation()
    {
        $validator = new \Phalcon\Validation();

        $validator->add(
            [
                'start',
                'finish',
                'price',
                'space',
                'departure',
            ],
            new \Phalcon\Validation\Validator\PresenceOf(
                [
                    'message' => [
                        'start' => 'The offer start is required',
                        'finish' => 'The offer finish is required',
                        'price' => 'The offer price is required',
                        'space' => 'The offer space is required',
                        'departure' => 'The offer departure is required',
                    ],
                ]
            )
        );

        return $this->validate($validator);
    }
}