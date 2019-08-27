<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use Log, Auth, Session;
use App\Services\CommonService;

class TagController extends BelongToResController
{
    CONST default_index = 'tag';
    CONST required_method = ['edit','update','destroy','duplicateTag'];
    CONST model = Tag::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.tags.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/tags'),
                    'text' => __('admin.tags.breadcrumbs.tags_index')
                ]
            ]
        ];
        session(['mainPage' => $request->fullUrl()]);

        // get search params
        $keyword = $request->get('q');
        $type = $request->get('type');
        
        $status = $request->get('status');
        $lang = Session::get('locale');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');

        $tags = Tag::select('tags.*' )->orderBy('tags.id', 'desc');

        // filter with search params
        if ($status == Tag::STATUS_FILTER['inactive']) {
            $tags = $tags->where('tags.active', '=', false);
        } elseif ($status == Tag::STATUS_FILTER['active']) {
            $tags = $tags->where('tags.active', '=', true);
        } else {
            $status = "";
        }

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $tags = $tags->where(function ($query) use ($keyword) {
                $query->orWhere('tags.name_en', 'LIKE', $keyword);
                $query->orWhere('tags.name_ja', 'LIKE', $keyword);
            });
        }
        if($type!=''){
            $tags = $tags->where(function ($query) use ($type) {
                $query->orWhere('tags.type', '=', $type);
            });
        }
        $tags = $tags->paginate($perPage);
        return view ('admin.tags.index',compact('tags', 'status',  'breadcrumbs', 'lang', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.tags.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/tags'),
                    'text' => __('admin.tags.breadcrumbs.tags_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.tags.breadcrumbs.add_tags')
                ]
            ]
        ];

        return view('admin.tags.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name_en' => "required|unique:tags,name_en"
        ]);

        $requestData = $request->all();
        unset($requestData['_token']);

        Tag::insert($requestData);

        Session::flash('flash_message', trans('admin.tags.flash_messages.new'));
        return redirect('admin/tags');
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
        $breadcrumbs = [
            'title' => __('admin.tags.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/tags'),
                    'text' => __('admin.tags.breadcrumbs.tags_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.tags.breadcrumbs.edit_tags')
                ]
            ]
        ];

        $tag = Tag::findOrFail($id);

        return view('admin.tags.edit',compact('tag', 'breadcrumbs'));
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
        $this->validate($request,[
            'name_en' => "required|unique:tags,name_en,$id"
        ]);

        $tag = Tag::findOrFail($id);

        $requestData = $request->all();

        $tag->update($requestData);

        Session::flash('flash_message', trans('admin.tags.flash_messages.update'));
        return redirect('admin/tags');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);

        $tag->delete();

        Session::flash('flash_message', trans('admin.tags.flash_messages.destroy'));
        return redirect('admin/tags');
    }

    public function duplicateTag($id){
        $tag = Tag::findOrFail($id);

        $newTag = $tag->replicate();
        $newTag->name_en = $newTag->name_en . " Copy " . rand(1000, 9999);

        $newTag->save();

        Session::flash('flash_message', trans('admin.tags.flash_messages.duplicate'));
        return redirect('admin/tags');
    }

}
