<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class Printer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'printers';

    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
    ];

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
    protected $fillable = ['name', 'restaurant_id', 'active', 'printer_name', 'token', 'auto_print', 'ip', 'port', 'polling_url',
        'callback_url', 'page_header', 'page_footer', 'reject_reason', 'printer_status', 'check_interval', 'last_time_success'];

    public function status()
    {
        if ($this->printer_status) {
            return __('admin.printers.statuses.active');
        }
        return __('admin.printers.statuses.inactive');
    }

    public function status_class()
    {
        if ($this->printer_status) {
            return 'm-badge--success';
        }
        return 'm-badge--danger';
    }

    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant','restaurant_id');
    }
}
