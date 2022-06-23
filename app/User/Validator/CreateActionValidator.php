<?php

namespace CartApp\User\Validator;

use CartApp\Core\Validator\AbstractValidator;

class CreateActionValidator extends AbstractValidator
{

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string',
            'gender' => 'required|string',
            'age' => 'required|integer'
        ];
    }
}