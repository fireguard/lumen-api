<?php
namespace App\Validators;

class DocumentValidator
{

    public function validStateRegistrationDocument($attribute, $value, $parameters)
    {
        return true;
    }

    public function validMunicipalRegistrationDocument($attribute, $value, $parameters)
    {
        return true;
    }

    public function validRgDocument($attribute, $value, $parameters)
    {
        // Verifica quantidade de digitos
        if (strlen($value) < 4) return false;

        return true;
    }

    public function validCtpsDocument($attribute, $value, $parameters)
    {
        return true;
    }

    /**
     * @param  string  $attribute
     * @param  string  $value
     * @param  mixed   $parameters
     * @return bool
     */
    public function validCompanyDocument($attribute, $value, $parameters)
    {
        $cnpj = $value;

        // Remover caracteres especiais
        $cnpj = preg_replace( '/[^0-9]/', '', (string) $cnpj );

        // Verifica quantidade de digitos
        if (strlen($cnpj) != 14) return false;

        if ( (string)$cnpj === '00000000000000' ) return true;

        //Verifica 1º digito verificador
        $sum = 0;
        for($j=5, $i=0; $i<4; $i++, $j--){
            $sum += ($cnpj[$i] * $j);
        }

        for($j=9,$i=4; $i<12; $i++, $j--){
            $sum += ($cnpj[$i] * $j);
        }

        $digit1 = $sum % 11;
        $digit1 = $digit1 < 2 ? 0 : 11 - $digit1;

        //Verifica 2º digito verificador
        $sum = 0;

        for($j=6,$i=0; $i<5; $i++, $j--){
            $sum += ($cnpj[$i] * $j);
        }

        for($j=9,$i=5; $i<13; $i++, $j--){
            $sum += ($cnpj[$i] * $j);
        }

        $digit2 = $sum % 11;
        $digit2 = $digit2 < 2 ? 0 : 11 - $digit2;

        //Verifica os digitos sao iguais aos resultados da soma
        return ($cnpj[12] == $digit1 && $cnpj[13] == $digit2);
    }

    /**
     * @param  string  $attribute
     * @param  string  $value
     * @param  mixed   $parameters
     * @return bool
     */
    public function validEmployeeDocument($attribute, $value, $parameters)
    {
        $cpf = $value;

        // Remover caracteres especiais
        $cpf = preg_replace( '/[^0-9]/', '', (string) $cpf );

        // Verifica quantidade de digitos
        if (strlen($cpf) != 11) return false;

        if ( (string)$cpf === '00000000000' ) return true;

        //Verifica 1° dígito verificador
        $sum = 0;
        
        for ($j = 10, $i = 0; $i <= 8; $i++, $j-- ) {
            $sum += $cpf[$i] * $j;
        }

        $digit1 = $sum % 11;
        $digit1 = $digit1 < 2 ? 0 : 11 - $digit1;

        //Verifica segundo dígito  
        $soma = 0;
        for ($j = 11, $i = 0; $i <= 9; $i++, $j--) {
            $soma += $cpf[$i] * $j;
        }

        $digit2 = $soma % 11;
        $digit2 = $digit2 < 2 ? 0 : 11 - $digit2;

        //Verifica os digitos sao iguais aos resultados da soma
        return ($cpf[9] == $digit1 && $cpf[10] == $digit2);
    }
}


