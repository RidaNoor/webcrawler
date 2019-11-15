<?php

namespace App;
use App\Email;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    public function emails(){
    	return $this->belongsToMany(Email::class)->withTimestamps();
    }

    protected $fillable = [
        'url','domain'
    ];
}
