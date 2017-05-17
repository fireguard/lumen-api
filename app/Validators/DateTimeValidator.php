<?php
namespace App\Validators;


class DateTimeValidator {

    /**
     * Determine if the attribute is validatable.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @param  mixed   $parameters
     * @return bool
     */
    public function hours($attribute, $value, $parameters)
    {
        return preg_match('/^[0-9]{1,3}:[0-5][0-9]$/', $value);
    }

	/**
	 * Determine if the attribute is validatable.
	 *
     * @param  string  $attribute
     * @param  string  $value
     * @param  mixed   $parameters
	 * @return bool
	 */
	public function times($attribute, $value, $parameters)
	{
		return preg_match('/^[0-9]{1,3}:[0-5][0-9]:[0-5][0-9]$/', $value);
	}



}


