<?php

namespace App;
use App\Url;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
  public function urls(){
    	return $this->belongsToMany(Url::class)->withTimestamps();
    }

      protected $fillable = [
        'email',
    ];
}
