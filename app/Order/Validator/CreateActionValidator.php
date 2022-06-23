<?php

namespace CartApp\Order\Validator;

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
            'offer_id' => 'required|integer'
        ];
    }
}