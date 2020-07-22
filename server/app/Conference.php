<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $fillable = ['name'];
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
