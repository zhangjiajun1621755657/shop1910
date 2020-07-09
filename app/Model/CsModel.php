<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CsModel extends Model
{
    protected $table="users";
    protected  $primaryKey="user_id";
    public $timestamps = false;
    protected $guarded=[];
}
