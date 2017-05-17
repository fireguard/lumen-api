<?php
namespace App\Validators;

class PasswordValidator
{
	private $rules = [
		'min_length' => 6,
		'max_length' => 50,
		'min_upper_case' => 1,
		'min_lower_case' => 1,
		'min_numbers' => 1,
		'min_special_chars' => 0
	];


	public function validPassword($attribute, $value, $parameters)
	{
		if( strlen($value) < $this->rules['min_length'] || strlen($value) > $this->rules['max_length']) return false;
		if( preg_match_all('/[!@#$%^&*()\-_=+{};:,<.>]/', $value, $o) < $this->rules['min_special_chars']) return false;
		if( preg_match_all('/[A-Z]/', $value, $o) < $this->rules['min_upper_case']) return false;
		if( preg_match_all('/[a-z]/', $value, $o) < $this->rules['min_lower_case']) return false;
		if( preg_match_all('/[0-9]/', $value, $o) < $this->rules['min_numbers']) return false;

		return true;

	}

	public function validOldPassword($attribute, $value, $parameters)
	{


		return \Hash::check($value,\Auth::user()->password);
	}

}


