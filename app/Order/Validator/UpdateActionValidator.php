<?php

namespace CartApp\Order\Validator;

use CartApp\Core\Validator\AbstractValidator;

class UpdateActionValidator extends AbstractValidator
{

    public function rules(): array
    {
        return [
            'status' => 'boolean',
            'info' => 'string',
        ];
    }
}