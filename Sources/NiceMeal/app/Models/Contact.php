<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    public $timestamps = false;


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
    protected $fillable = ['name', 'email', 'phone', 'contact_category_id', 'title', 'message', 'is_read','file_attach'];

    public function contact_category() {
        return $this->belongsTo('App\Models\ContactCategory','contact_category_id');
    }
}
