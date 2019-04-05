<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Students extends Model
{
   protected $fillable =
   [
       'classroom_id','name', 'age', 'photo'
   ];

   use SoftDeletes;

   public function classroom()
    {
      return $this->hasOne('App\Classroom','id','classroom_id');
   }
}