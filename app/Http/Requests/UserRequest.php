<?php

namespace App\Http\Requests;


class UserRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'bail|required|max:255|email', // |unique:users
            'password' => 'required|password',
            'function' => 'max:255',
            'image' => 'valid_image'
        ];

        switch($this->method())
        {
            case 'PUT':
            case 'PATCH':
            {
                if (!empty($this->route('id'))) {
                    $idEntity = $this->route('id');
                    $rules['username'] = 'bail|required|max:255|email|unique:users,email,'.$idEntity;
                }
                unset($rules['password']);
                return $rules;
            }
            default: return $rules;
        }
    }
}
