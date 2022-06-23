<?php

namespace CartApp\User\Validator;

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
            'name' => 'string',
            'surname' => 'string',
            'gender' => 'string',
            'age' => 'integer',
            'profile_picture' => 'string'
        ];
    }
}