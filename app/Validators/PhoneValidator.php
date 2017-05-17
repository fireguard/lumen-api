<?php
namespace App\Validators;

class PhoneValidator
{
    /**
     * @param  string  $attribute
     * @param  string  $value
     * @param  mixed   $parameters
     * @return bool
     */
    public function validPhone($attribute, $value, $parameters)
	{
	    if (!empty($parameters) && $parameters[0] == false) {
            return preg_match('/^\d{4,5}-\d{4}$/', $value) > 0;
        }

		return preg_match('/^\(\d{2}\)[ ]?\d{4,5}-\d{4}$/', $value) > 0;
	}
}


