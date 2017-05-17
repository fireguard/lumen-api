<?php
namespace App\Validators;

class AddressValidator
{
    /**
     * @param  string  $attribute
     * @param  string  $value
     * @param  mixed   $parameters
     * @return bool
     */
    public function validZipCode($attribute, $value, $parameters)
    {
        $zip = $value;

        // Remover caracteres especiais
        $zip = preg_replace( '/[^0-9]/', '', (string) $zip );

        // Verifica quantidade de digitos
        if (strlen($zip) != 8) return false;

        if ( (string)$zip === '00000000' ) return true;

        return true;
    }
}


