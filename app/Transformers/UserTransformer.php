<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    public function transform(User $user)
    {
        return [
            'id'        => (int) $user->id,
            'name'      => $user->name,
            'email'     => $user->email,
            'function'  => $user->function,
            'image'     => get_uri($user->image),
        ];
    }
}
