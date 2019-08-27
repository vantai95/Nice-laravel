<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqType;
use App\Models\Image;
use Session,Log;
use App\Services\CommonService;
use Illuminate\Support\Facades\File;

class FaqsTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.faq_type.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/faqstype'),
                    'text' => __('admin.faq_type.breadcrumbs.faq_index')
                ]
            ]
        ];
        $keyword = $request->get('q');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');
        $faqsType = FaqType::select('faqs_type.*' )->orderBy('faqs_type.id', 'desc');
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $faqsType = $faqsType->where(function ($query) use ($keyword) {
                $query->orWhere('name_en', 'LIKE', $keyword);
                $query->orWhere('name_vn', 'LIKE', $keyword);
            });
        }
        $faqsType = $faqsType->paginate($perPage);
        return view('admin.faq_type.index', compact('breadcrumbs','faqsType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.faq_type.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/faqs'),
                    'text' => __('admin.faq_type.breadcrumbs.faq_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.faq_type.breadcrumbs.add_faq')
                ]
            ]
        ];
        return view('admin.faq_type.create', compact( 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name_vn' => 'required',
        ]);
        $requestData = $request->all();
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vn'];
        FaqType::create($requestData);
        Session::flash('flash_message', trans('admin.faq_type.flash_messages.new'));
        return redirect('admin/faqs-type');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faqType = FaqType::findOrFail($id);
        ($faqType->faq_id == null) ? $faqType->faq_id = [] : $faqType->faq_id = json_decode($faqType->faq_id);
        $breadcrumbs = [
            'title' => __('admin.faq_type.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/faqs'),
                    'text' => __('admin.faq_type.breadcrumbs.faq_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.faq_type.breadcrumbs.edit_faq')
                ],
            ]
        ];
        $faqs = Faq::select('*')->where('faq_type_id',$faqType->id)->get();
        return view('admin.faq_type.edit', compact('faqType','faqs', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name_vn' => 'required',
        ]);
        $faqType = FaqType::findOrFail($id);
        $requestData = $request->all();
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vn'];
        $faqType->update($requestData);
        Session::flash('flash_message', trans('admin.faq_type.flash_messages.update'));
        return redirect('admin/faqs-type');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faqType = FaqType::findOrFail($id);        
        $faqType->delete();

        Session::flash('flash_message', __('admin.faq_type.flash_messages.destroy'));

        return redirect("admin/faqs-type");
    }

    public function upload()
    {
        return;
    }
}
