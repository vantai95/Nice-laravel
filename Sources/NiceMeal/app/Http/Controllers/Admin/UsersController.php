<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\UsersRestaurant;
use App\Services\CommonService;
use Illuminate\Http\Request;
use App\Services\Permissions;
use App\Services\Users;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.users.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/users'),
                    'text' => __('admin.users.breadcrumbs.user_index')
                ]
            ]
        ];

        $keyword = $request->get('q');
        $role = $request->get('role');
        $status = $request->get('status');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $roles = Permissions\CrudService::getAllRole()->get();
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');
        $users = Users\Admin\CrudService::getUserList();
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $users = $users->where(function ($query) use ($keyword) {
                $query->orWhere('full_name', 'LIKE', $keyword);
                $query->orWhere('email', 'LIKE', $keyword);
                $query->orWhere('phone', 'LIKE', $keyword);
            });
        }
        if($role!= null){
          $users = $users->where('user_roles.role_id','=',intval($role));
        }
        if ($status == User::STATUS_FILTER['active']) {
            $users = $users->where('is_locked', '=', false);
        } elseif ($status == User::STATUS_FILTER['locked']) {
            $users = $users->where('is_locked', '=', true);
        } else {
            $status = "";
        }
        $total = $users->get()->count();
        $users = $users->groupBy('users.id')->paginate($perPage,'users.*');
        session(['mainPage' => $request->fullUrl()]);
        return view('admin.users.index', compact('users', 'role', 'status', 'roles','total', 'breadcrumbs'));
    }

    public function myProfile()
    {
        $user = Auth::user();
        $isMyProfile = true;
        $breadcrumbs = [
            'title' => __('admin.users.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('/admin/my-profile'),
                    'text' => __('admin.users.breadcrumbs.my_profile')
                ]
            ]
        ];
        $oldRole = UsersRestaurant::where('user_id',$user->id)->get(['restaurant_id','role_id']);

        return view('admin.users.show', compact('user', 'isMyProfile', 'breadcrumbs','oldRole'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = Users\Admin\CrudService::getUser($id);
        $isMyProfile = false;
        $roles = Permissions\CrudService::getAllRole()->get();


        $restaurants = [];
        foreach (Restaurant::orderBy('name_en', 'asc')->get() as $restaurant) {
            $restaurants = $restaurants + [$restaurant->id => $restaurant->name_en];
        }
        // $restaurants = Restaurant::lists('name_en', 'id');
        $oldRole = UsersRestaurant::where('user_id',$id)->get(['restaurant_id','role_id']);
        $breadcrumbs = [
            'title' => __('admin.users.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/users'),
                    'text' => __('admin.users.breadcrumbs.user_index')
                ],
                [
                    'href' => url('/admin/users/' . $id . '/edit'),
                    'text' => $user->full_name
                ]
            ]
        ];
        return view('admin.users.show', compact('user', 'isMyProfile', 'roles', 'restaurants', 'breadcrumbs','oldRole'));
    }

    public function update($id, Request $request)
    {
      $isMyProfile = true;
        $minAge = 18;
        $validateList = [
            'full_name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'address' => 'max:300'
        ];
        if ($isMyProfile) {
            if (!empty($request->get('phone'))) {
                $validateList['phone'] = "min:10|regex:/^[0-9]+$/";
            }
        } else {
            $validateList['phone'] = "required|min:10|regex:/^[0-9]+$/";
            $validateList['birth_day'] = 'required';
            // $validateList['birth_day'] = 'required|before:-18 years';
        }
        $message = [];
        $this->validate($request, $validateList, $message);

        Users\Admin\CrudService::updateData($id,$request,true);
        
        Session::flash('flash_message', 'Profile has been updated!');
        return redirect('admin/users/'.$id);
    }

    public function foodie(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.users.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/foodie'),
                    'text' => __('admin.users.breadcrumbs.user_index')
                ]
            ]
        ];

        $keyword = $request->get('q');
        $role = 'customer';
        $status = $request->get('status');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $users = User::select('users.*', 'users_restaurants.role_id')
            ->leftJoin('users_restaurants', 'users.id', 'users_restaurants.user_id')
            ->Join('orders', 'users.id', 'orders.user_id')
            ->orderBy('users.full_name', 'asc')->distinct('role_id');

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $users = $users->where(function ($query) use ($keyword) {
                $query->orWhere('full_name', 'LIKE', $keyword);
                $query->orWhere('email', 'LIKE', $keyword);
                $query->orWhere('phone', 'LIKE', $keyword);
            });
        }
        $users = $users->whereNull('users_restaurants.role_id');

        if ($status == User::STATUS_FILTER['active']) {
            $users = $users->where('is_locked', '=', false);
        } elseif ($status == User::STATUS_FILTER['locked']) {
            $users = $users->where('is_locked', '=', true);
        } else {
            $status = "";
        }

        $total = $users->get()->count();
        $users = $users->groupBy('users.id')->paginate($perPage,'users.*');
        session(['mainPage' => $request->fullUrl()]);

        return view('admin.users.foodie', compact('users', 'role', 'status', 'total', 'breadcrumbs'));
    }
}
