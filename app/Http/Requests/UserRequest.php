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
            'email' => 'bail|required|max:255|email|unique:users',
            'password' => 'required|password',
            'function' => 'max:255',
            'image' => 'valid_image'
        ];

        switch($this->method())
        {
            case 'PUT':
            case 'PATCH':
            {
                $rules['email'] = 'bail|required|max:255|email|unique:users,email,'.route_parameter('id', '');
                unset($rules['password']);
                return $rules;
            }
            default: return $rules;
        }
    }
}
