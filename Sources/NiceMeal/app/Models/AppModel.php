<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\File;
use Session, Log, DB;


abstract class AppModel extends Model
{
    use Sluggable;
    /**
     * The model variables
     */
    var $table = 'table_name';
    var $slug = 'slug_name';
    var $defaultImagePath = 'DEFAULT_IMAGE_PATH';

    /**
     * The model constants value
     */
    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
    ];

    /**
     * The model variables value
     */
    protected $lang = 'en';

    /**
     * The database primary key value.
     */
    protected $primaryKey = 'id';

    /**
     * Methods
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->lang = Session::get('locale');
    }

    public function sluggable()
    {
        return [
            'slug' => [ 'source' => $this->slug ]
        ];
    }

    public function status()
    {
        return __('admin.' . $this->table . '.statuses.' . ($this->active ? 'active' : 'inactive'));
    }

    public function status_class()
    {
        return $this->active ? 'm-badge--success' : 'm-badge--danger';
    }

    public function imageUrl()
    {
        if (!empty($this->file_name) && File::exists(public_path(config('constants.UPLOAD.IMAGES')) . '/' . $this->file_name)) {
            return url(config('constants.UPLOAD.IMAGES') . '/' . $this->file_name);
        }
        return url(config($this->defaultImagePath));
    }

}
