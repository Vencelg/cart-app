<?php

namespace CartApp\Offer\Controller;

use CartApp\Core\Controller\AbstractController;
use CartApp\Core\Exception\BaseException;
use CartApp\Offer\Mapper\OfferMapper;
use CartApp\Offer\Model\Offer;
use CartApp\Offer\Validator\CreateActionValidator;
use CartApp\Offer\Validator\UpdateActionValidator;
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
     * @throws BaseException
     */
    public function createAction(): array
    {
        $request = $this->request->getJsonRawBody();
        $validator = new CreateActionValidator([
            'start' => $request->start,
            'finish' => $request->finish,
            'price' => $request->price,
            'space' => $request->space,
            'departure' => $request->departure,
        ]);

        $validation = $validator->validate();

        if ($validation['errorsSet']) {
            throw new BaseException($validation['messages'], 422);
        }

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
        $request = $this->request->getJsonRawBody();
        $validator = new UpdateActionValidator([
            'start' => $request->start,
            'finish' => $request->finish,
            'price' => $request->price,
            'space' => $request->space,
            'departure' => $request->departure,
        ]);

        $validation = $validator->validate();

        if ($validation['errorsSet']) {
            throw new BaseException($validation['messages'], 422);
        }

        $offer = Offer::findFirst($id);
        if (!($offer instanceof Offer)) {
            throw new \CartApp\Core\Exception\BaseException("Offer with ID: $id not found.", 404);
        }

        $offer->setStart($request->start ?? $offer->getStart());
        $offer->setFinish($request->finish ?? $offer->getFinish());
        $offer->setPrice($request->price ?? $offer->getPrice());
        $offer->setSpace($request->space ?? $offer->getSpace());
        $offer->setDeparture($request->departure ?? $offer->getDeparture());
        $offer->setUpdatedBy($this->user);

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