<?php

namespace CartApp\Offer\Mapper;

use CartApp\Offer\Model\Offer;

/**
 * OfferMapper class
 */
class OfferMapper extends \CartApp\Core\Mapper\AbstractMapper
{
    use \CartApp\Core\Mapper\CudLogMapperTrait;

    /**
     * @param Offer $source
     * @param int $depth
     * @return array
     */
    public function map($source, int $depth = 0): array
    {
        $output = [];

        $output['id'] = $source->getId();
        $output['user_id'] = $source->getUserId();
        $output['start'] = $source->getStart();
        $output['finish'] = $source->getFinish();
        $output['price'] = $source->getPrice();
        $output['space'] = $source->getSpace();
        $output['departure'] = $source->getDeparture();

        // Prevent from infinite looping
        if ($depth <= $this->maxDepth) {
            $output = array_merge($output, $this->mapCudLog($source, ++$depth));
        }

        return $output;
    }
}