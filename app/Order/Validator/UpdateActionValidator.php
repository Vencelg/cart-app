<?php

namespace CartApp\Order\Validator;

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
            'status' => 'boolean',
            'info' => 'string',
        ];
    }
}