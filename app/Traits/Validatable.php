<?php

namespace App\Traits;

use Dotenv\Parser\Value;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait Validatable
{
    protected $validationErrorMessages = [];

    protected function getValidationRules()
    {
        return $this->rules ?? [];
    }

    protected function getValidator($data)
    {
        return Validator::make($data, $this->getValidationRules(), $this->validationErrorMessages);
    }

    public function validateAndFill($data)
    {
        $validator = $this->getValidator($data);
        
        if ($validator->fails()){
            logger()->debug("failed" . var_export($validator->fails(),true));
            throw new ValidationException($validator);
        }
        logger()->debug("OK");
        $this->fill($data);
        return $this;
    }
}
