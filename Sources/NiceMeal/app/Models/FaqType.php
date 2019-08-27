<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqType extends Model
{
   /**
    * The database table used by the model.
    *
    * @var string
    */
   protected $table = 'faqs_type';

   /**
    * The database primary key value.
    *
    * @var string
    */
   protected $primaryKey = 'id';

   /**
    * Attributes that should be mass-assignable.
    *
    * @var array
    */
   protected $fillable = ['active', 'name_en', 'name_vn'];

   public function faqs()
   {
      return $this->hasMany('App\Models\Faq');
   }
}
