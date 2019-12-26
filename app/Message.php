<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Message extends Model
{
    protected $softDelete = true;
    protected $table = 'messages';
    protected $primaryKey = 'm_id';
    const UPDATED_AT = null;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'account', 'content',
    ];
}
