<?php

namespace CartApp\Offer\Validator;

use CartApp\Core\Validator\AbstractValidator;

/**
 * UpdateActionValidator class
 */
class UpdateActionValidator extends AbstractValidator
{

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'start' => 'string',
            'finish' => 'string',
            'price' => 'integer',
            'space' => 'integer',
            'departure' => 'string'
        ];
    }
}