<?php

namespace CartApp\Offer\Controller;

use CartApp\Core\Controller\AbstractController;
use CartApp\Core\Exception\BaseException;
use CartApp\Offer\Mapper\OfferMapper;
use CartApp\Offer\Model\Offer;
use CartApp\User\Model\User;

/**
 *  OfferController class
 */
class OfferController extends AbstractController
{
    /**
     * @var OfferMapper
     */
    protected OfferMapper $mapper;

    /**
     * @return void
     */
    public function initialize()
    {
        $this->mapper = new OfferMapper();
    }

    /**
     * @return array
     */
    public function listAction(): array
    {
        $offers = Offer::find();

        return $this->mapper->mapCollection($offers);
    }

    /**
     * @param int $id
     * @return array
     * @throws BaseException
     */
    public function getAction(int $id): array
    {
        $offer = Offer::find($id);
        if (!($offer instanceof Offer)) {
            throw new BaseException("Offer with ID: $id not found.", 404);
        }

        return $this->mapper->map($offer);
    }

    /**
     * @return array
     */
    public function createAction(): array
    {
        $request = $this->request->getJsonRawBody();

        $newOffer = new Offer();
        $newOffer->setStart($request->start);
        $newOffer->setFinish($request->finish);
        $newOffer->setPrice($request->price);
        $newOffer->setSpace($request->space);
        $newOffer->setDeparture($request->departure);



        if ($this->user instanceof User) {
            $newOffer->setUserId($this->user->getId());
            $newOffer->setCreatedBy($this->user);
        }

        $newOffer->save();

        return $this->mapper->map($newOffer);
    }

    /**
     * @param int $id
     * @return array
     * @throws BaseException
     */
    public function updateAction(int $id): array
    {
        $offer = Offer::findFirst($id);
        if (!($offer instanceof Offer)) {
            throw new \CartApp\Core\Exception\BaseException("Offer with ID: $id not found.", 404);
        }

        $request = $this->request->getJsonRawBody();

        $offer->setStart($request->start);
        $offer->setFinish($request->finish);
        $offer->setPrice($request->price);
        $offer->setSpace($request->space);
        $offer->setDeparture($request->departure);

        $offer->save();

        return $this->mapper->map($offer);
    }

    /**
     * @param int $id
     * @return array
     * @throws BaseException
     */
    public function deleteAction(int $id): array
    {
        $offer = Offer::findFirst($id);
        if (!($offer instanceof Offer)) {
            throw new \CartApp\Core\Exception\BaseException("Offer with ID: $id not found.", 404);
        }

        $offer->delete();
        return [];
    }

}