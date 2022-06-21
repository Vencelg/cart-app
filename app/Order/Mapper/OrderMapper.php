<?php

namespace CartApp\Order\Mapper;

use CartApp\Core\Mapper\AbstractMapper;
use CartApp\Order\Model\Order;

/**
 * OrderMapper class
 */
class OrderMapper extends AbstractMapper
{
    use \CartApp\Core\Mapper\CudLogMapperTrait;

    /**
     * @param Order $source
     * @param int $depth
     * @return array
     */
    public function map($source, int $depth = 0): array
    {
        $output = [];

        $output['id'] = $source->getId();
        $output['user_id'] = $source->getUserId();
        $output['offer_id'] = $source->getOfferId();
        $output['info'] = $source->getInfo();
        $output['status'] = $source->isStatus();

        // Prevent from infinite looping
        if ($depth <= $this->maxDepth) {
            $output = array_merge($output, $this->mapCudLog($source, ++$depth));
        }

        return $output;
    }
}