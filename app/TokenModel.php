<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokenModel extends Model
{
    public $table= 'token';
    public $primaryKey = 'token_id';
}
