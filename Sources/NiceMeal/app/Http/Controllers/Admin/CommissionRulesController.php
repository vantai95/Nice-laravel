<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommissionRule;
use Log, Session;

class CommissionRulesController extends BelongToResController
{
    CONST default_index = 'commission_rule';
    CONST required_method = [
        'edit',
        'update',
        'destroy',
    ];
    CONST model = CommissionRule::class;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $lang = Session::get('locale');
        $restaurantId = Session::get('res')->id;

        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.commission_rules.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/'.Session::get('res')->res_Slug.'/commission-rules'),
                    'text' => __('admin.commission_rules.breadcrumbs.commission_index')
                ]
            ]
        ];
        $commissionRules = CommissionRule::where('restaurant_id', $restaurantId)->orderBy('created_at', 'des');

        if (!empty($commissionRules)) {
            $commissionRules = $commissionRules->paginate($perPage);
        }
        return view('admin.commission_rules.index', compact('commissionRules', 'breadcrumbs', 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.categories.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/commission-rules'),
                    'text' => __('admin.commission_rules.breadcrumbs.commission_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.commission_rules.breadcrumbs.add_commission')
                ]
            ]
        ];
        return view('admin.commission_rules.create', compact('breadcrumbs'));
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
        $resId = Session::get('res')->id;

        $requestData = $request->all();

        $this->validate($request, [
            'level' => 'required|string',
            'total_from' => 'required',
            'total_to' => 'required|gt:total_from',
            'rate' => 'required|min:0|max:100'
        ]);

        $requestData['restaurant_id'] = $resId;

        CommissionRule::create($requestData);

        Session::flash('flash_message', trans('admin.commission_rules.flash_messages.new'));
        return redirect('admin/commission-rules');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $breadcrumbs = [
            'title' => __('admin.commission_rules.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/commission-rules'),
                    'text' => __('admin.commission_rules.breadcrumbs.commission_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.commission_rules.breadcrumbs.edit_commission')
                ]
            ]
        ];

        $commissionRule = CommissionRule::findOrFail($id);

        return view('admin.commission_rules.edit', compact('commissionRule', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     * @param  int $id
     * @param Request|\Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $resId = Session::get('res')->id;

        $requestData = $request->all();

        $this->validate($request, [
            'level' => 'required|string',
            'total_from' => 'required',
            'total_to' => 'required|gt:total_from',
            'rate' => 'required|min:0|max:100'
        ]);

        $commissionRule = CommissionRule::findOrFail($id);

        $requestData['restaurant_id'] = $resId;

        $commissionRule->update($requestData);

        Session::flash('flash_message', trans('admin.commission_rules.flash_messages.update'));
        return redirect('admin/commission-rules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $commissionRule = CommissionRule::findOrFail($id);

        $commissionRule->delete();

        Session::flash('flash_message', trans('admin.commission_rules.flash_messages.destroy'));

        return redirect('admin/commission-rules');
    }

}
