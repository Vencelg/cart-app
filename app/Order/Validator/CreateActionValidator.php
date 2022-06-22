<?php

namespace CartApp\Order\Validator;

use CartApp\Core\Validator\AbstractValidator;

class CreateActionValidator extends AbstractValidator
{

    public function rules(): array
    {
        return [
            'offer_id' => 'required|integer'
        ];
    }
}