<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\CommonService;
use App\Services\Permissions;
use Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $breadcrumbs = [
          'title' => __('admin.roles.breadcrumbs.title'),
          'links' => [
              [
                  'href' => url('admin/roles'),
                  'text' => __('admin.roles.breadcrumbs.role_index')
              ]
          ]
      ];
      $keyword = $request->get('q');
      $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');
      $roles = Permissions\CrudService::getAllRole();
      if (!empty($keyword)) {
          $keyword = CommonService::correctSearchKeyword($keyword);
          $roles = $roles->where(function ($query) use ($keyword) {
              $query->orWhere('name', 'LIKE', $keyword);
          });
      }
      $roles = $roles->paginate($perPage);
      return view('admin.users.roles.index',compact('breadcrumbs','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $breadcrumbs = [
            'title' => __('admin.roles.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/roles'),
                    'text' => __('admin.roles.breadcrumbs.role_edit')
                ]
            ]
        ];
        $permissions = Permissions\CrudService::getAllPermission();
        return view('admin.users.roles.create',compact('permissions','breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $permissions = Permissions\ValidateInputService::validateInput($request);
        $data['name'] = $request->input('name');
        $data['permissions'] = implode(',',$permissions);
        Role::create($data);
        Session::flash('flash_message', "Role created successfully");
        return redirect('admin/roles');
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
        $breadcrumbs = [
            'title' => __('admin.roles.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/roles'),
                    'text' => __('admin.roles.breadcrumbs.role_create')
                ]
            ]
        ];
        $permissions = Permissions\CrudService::getAllPermission();
        $role = Permissions\CrudService::findRole($id);
        if($role == null){
          Session::flash('flash_error','Role not found');
          return redirect('/admin/roles');
        }
        return view('admin.users.roles.edit',compact('breadcrumbs','role','permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
        $permissions = Permissions\ValidateInputService::validateInput($request);
        $role = Permissions\CrudService::findRole($id);
        if($role == null){
          Session::flash('flash_error','Role not found');
          return redirect('/admin/roles');
        }
        $newRoleData = [
          'name' => $request->input('name'),
          'permissions' => implode(',',$permissions)
        ];
        Permissions\CrudService::updateRole($role,$newRoleData);

        Session::flash('flash_message', "Update role success");
        return redirect('admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
