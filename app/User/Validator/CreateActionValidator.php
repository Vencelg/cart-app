<?php

namespace CartApp\User\Validator;

use CartApp\Core\Validator\AbstractValidator;

/**
 * CreateActionValidator class
 */
class CreateActionValidator extends AbstractValidator
{

    /**
     * @return string[]
     */
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