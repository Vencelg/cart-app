<?php

namespace CartApp\Offer\Validator;

use CartApp\Core\Validator\AbstractValidator;

class CreateActionValidator extends AbstractValidator
{

    public function rules(): array
    {
        return [
            'start' => 'required|string',
            'finish' => 'required|string',
            'price' => 'required|integer',
            'space' => 'required|integer',
            'departure' => 'required|string'
        ];
    }
}