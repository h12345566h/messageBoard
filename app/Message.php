<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $table = 'messages';
    protected $primaryKey = 'm_id';
    const UPDATED_AT = null;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'account', 'content',
    ];
    protected $hidden = [
        'updated_at','deleted_at'
    ];
}
