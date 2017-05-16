<?php

namespace App\Models;

use Fireguard\Form\Contracts\FormModelInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class AbstractModel extends Model
{
    use SoftDeletes;
    
}
