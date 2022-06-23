<?php

namespace CartApp\User\Validator;

use CartApp\Core\Validator\AbstractValidator;

class UpdateActionValidator extends AbstractValidator
{

    public function rules(): array
    {
        return [
            'name' => 'string',
            'surname' => 'string',
            'gender' => 'string',
            'age' => 'integer',
            'profile_picture' => 'string'
        ];
    }
}