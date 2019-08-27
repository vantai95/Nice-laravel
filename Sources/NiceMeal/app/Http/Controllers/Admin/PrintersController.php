<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Log;
use App\Models\User;
use App\Models\Role;
use App\Models\Upload;
use App\Models\Printer;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;


class PrintersController extends BelongToResController
{
    CONST default_index = 'printer';
    CONST required_method = [
        'edit',
        'update',
        'destroy',
        'export',
        'duplicatePrinters'
    ];
    CONST model = Printer::class;
    const PRINTER_PARAMS = [
        'restaurant_id' => 'RES ID',
        'auto_print' => 'Auto Print',
        'name' => 'Login Web UserName',
        'token' => 'Login Web Password',
        'page_header' => 'Page header',
        'page_footer' => 'Page footer',
        'reject_reason' => 'Reject Reason',
        'check_interval' => 'GPRS auto check interval',
        'ip' => 'IP',
        'port' => 'Port',
        'check_order_ip' => 'Check Order IP',
        'check_order_port' => 'Check Order Port',
        'polling_url' => 'File Path',
        'callback_url' => 'Callback URL'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     *
     * @internal param Request $request
     */
    public function index(Request $request, $slug=NULL)
    {
        $lang = Session::get('locale');
        if (isset($slug)) $this->restaurant = Session::get('res');

        $breadcrumbs = [
            'title' => __('admin.printers.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/'.(isset($slug) ? $this->restaurant->res_Slug.'/' : '').'printers'),
                    'text' => __('admin.printers.breadcrumbs.printer_index')
                ]
            ]
        ];

        // get search params
        $keyword = $request->get('q');
        $status = $request->get('status');
        $resId = $request->get('res_id');
        $lang = Session::get('locale');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }

        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');
        isset($slug) ? $printers = Printer::where('restaurant_id', $this->restaurant->id)->orderBy('id', 'desc')
            : $printers = Printer::orderBy('id', 'desc');

        // filter with search params
        foreach($printers->get() as $item) {
            if(!$item->last_time_success) $item->printer_status = 0;
            else {
                $lastTimeSuccess = \Carbon\Carbon::parse($item->last_time_success);
                $item->printer_status = ($lastTimeSuccess->diffInSeconds(\Carbon\Carbon::now()) <= 3*$item->check_interval) ? 1 : 0;
            }
            $item->update(['printer_status'=>$item->printer_status]);
        }
        if (!empty($status)) {
            if ($status == Printer::STATUS_FILTER['inactive']) {
                $printers = $printers->where('printer_status', '=', false);
            } elseif ($status == Printer::STATUS_FILTER['active']) {
                $printers = $printers->where('printer_status', '=', true);
            }
        }
        if (!empty($resId)) {
            $printers->where('restaurant_id', $resId);
        }
        if(!empty($keyword)){
            $keyword = CommonService::correctSearchKeyword($keyword);
            $printers = $printers->where(function($query) use ($keyword){
                $query->orWhere("printers.name",'like',$keyword);
            });
        }

        $printers = $printers->paginate($perPage);
        return view('admin.printers.index', compact('printers', 'status', 'breadcrumbs' , 'lang', 'slug', 'resId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create($slug=NULL)
    {
        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.printers.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/printers'),
                    'text' => __('admin.printers.breadcrumbs.printer_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.printers.breadcrumbs.add_printer')
                ]
            ]
        ];

        $statuses = Printer::STATUS_FILTER;
        return view('admin.printers.create',compact('breadcrumbs', 'statuses', 'lang', 'slug'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $isAdminView = count(func_get_args())==1;
        if (!$isAdminView) {
            $slug = func_get_args()[1];
        }

        $this->restaurant = Session::get('res');
        $requestData = $request->all();
        $requestData['printer_status'] = 0;
        $requestData['auto_print'] = 1;
        $requestData['restaurant_id'] = isset($requestData['restaurant_id']) ? $requestData['restaurant_id'] : $this->restaurant->id;
        $resId = $isAdminView ? $requestData['restaurant_id'] :  $this->restaurant->id;

        $this->validate($request,[
            'name' => "required|unique:printers,name,null,null,restaurant_id,$resId",
            'ip' => 'required',
            'port' => 'required|integer',
            'polling_url' => 'required|url|max:200',
            'callback_url' => 'required|url|max:200',
            'check_interval' => 'required|integer',
            'token' => 'required|max:30',
            'page_header' => 'required',
            'page_footer' => 'required',
        ]);

        Printer::create($requestData);
        Session::flash('flash_message', trans('admin.printers.flash_messages.new'));

        return redirect((isset($slug) ? '/admin/' . $this->restaurant->res_Slug : '/admin') . '/printers');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $isAdminView = count(func_get_args())==1;
        if ($isAdminView) {
            $id = func_get_args()[0];
        }
        else {
            $slug = func_get_args()[0];
            $id = func_get_args()[1];
        }

        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.printers.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/printers'),
                    'text' => __('admin.printers.breadcrumbs.printer_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.printers.breadcrumbs.edit_printer')
                ]
            ]
        ];
        $this->restaurant = Session::get('res');
        $statuses = Printer::STATUS_FILTER;
        !$isAdminView ? $printer = Printer::where('restaurant_id', $this->restaurant->id)->findOrFail($id)
            : $printer = Printer::findOrFail($id);

        return view('admin.printers.edit',compact('breadcrumbs', 'printer', 'statuses', 'lang', 'slug'));
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $isAdminView = count(func_get_args())==2;
        if ($isAdminView) {
            $id = func_get_args()[1];
        }
        else {
            $slug = func_get_args()[1];
            $id = func_get_args()[2];
        }

        $this->restaurant = Session::get('res');
        $requestData = $request->all();
        $requestData['auto_print'] = 1;
        $requestData['restaurant_id'] = isset($requestData['restaurant_id']) ? $requestData['restaurant_id'] : $this->restaurant->id;
        $resId = $isAdminView ? $requestData['restaurant_id'] :  $this->restaurant->id;
        
        $this->validate($request,[
            'name' => "required|unique:printers,name,$id,id,restaurant_id,$resId",
            'ip' => 'required',
            'port' => 'required|integer',
            'polling_url' => 'required|url|max:200',
            'callback_url' => 'required|url|max:200',
            'check_interval' => 'required|integer',
            'token' => 'required|max:30',
            'page_header' => 'required',
            'page_footer' => 'required',
        ]);

        $printer = Printer::findOrFail($id);
        $printer->update($requestData);
        Session::flash('flash_message', trans('admin.printers.flash_messages.update'));

        return redirect((isset($slug) ? '/admin/' . $this->restaurant->res_Slug : '/admin') . '/printers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy()
    {
        if (!Auth::user()->isAdmin()) return;

        $isAdminView = count(func_get_args())==1;
        if ($isAdminView) {
            $id = func_get_args()[0];
        }
        else {
            $slug = func_get_args()[0];
            $id = func_get_args()[1];
        }

        $this->restaurant = Session::get('res');
        $printer = Printer::findOrFail($id);
        $printer->delete();
        Session::flash('flash_message', trans('admin.printers.flash_messages.destroy'));
        return redirect((isset($slug) ? '/admin/' . $this->restaurant->res_Slug : '/admin') . '/printers');
    }

    public function upload()
    {
        return;
    }

    public function export() {

        if (!Auth::user()->isAdmin()) return;

        $isAdminView = count(func_get_args())==1;
        if ($isAdminView) {
            $id = func_get_args()[0];
        }
        else {
            $slug = func_get_args()[0];
            $id = func_get_args()[1];
        }

        $params = parse_ini_file(storage_path('goodcom_6000sw.ini'), true, INI_SCANNER_RAW );

        $printer = Printer::where('id', $id)->first();
        $printer->check_order_ip = $printer->ip;
        $printer->check_order_port = $printer->port;

        foreach($this::PRINTER_PARAMS as $key=>$value) {
            foreach ($params as &$param) {
                if($param['NameEn'] == $value) {
                    $param['Command'] = $printer[$key];
                }
            }
        }

        CommonService::write_ini_file($params, storage_path('goodcom_6000sw_update.ini'), true);

        return response()->download(storage_path('goodcom_6000sw_update.ini'), 'goodcom_6000sw.ini')->deleteFileAfterSend();
    }

    public function duplicatePrinters()
    {
        $isAdminView = count(func_get_args())==1;
        if ($isAdminView) {
            $id = func_get_args()[0];
        }
        else {
            $slug = func_get_args()[0];
            $id = func_get_args()[1];
        }

        $this->restaurant = Session::get('res');

        CommonService::duplicateRow('printers', $id, ['name']);

        Session::flash('flash_message', trans('admin.printers.flash_messages.duplicate'));
        return redirect((isset($slug) ? '/admin/' . $this->restaurant->res_Slug : '/admin') . '/printers');
    }
}
