<?php

namespace CartApp\Offer\Validator;

use CartApp\Core\Validator\AbstractValidator;

class UpdateActionValidator extends AbstractValidator
{

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