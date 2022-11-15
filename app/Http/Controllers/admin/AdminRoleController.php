<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\role\StoreAdminRoleRequest;
use App\Http\Requests\role\UpdateAdminRoleRequest;
use App\Models\PermissionsCategory;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::where("is_fixed",0)->orderBy('id')->with('users')->get();
        $PermissionsCategory = PermissionsCategory::with('permissions')->get();

        $users = User::select('users.*', 'countries.country_name', 'countries.country_code')
        ->leftjoin('countries', 'countries.id', 'users.country_id')
        ->with(['admin', 'roles'])->whereHas('admin')
        ->orderBy('id')->paginate(30);

        return view('admin.rolesPermission.index', compact('roles', 'PermissionsCategory','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $PermissionsCategory = PermissionsCategory::with('permissions')->get();
        return view('admin.rolesPermission.create', compact('PermissionsCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminRoleRequest $request)
    {
        $role = Role::create(['name' => $request->input('name'), 'display_name' => $request->input('display_name'), 'color' => $request->input('color')]);
        $role->syncPermissions($request->input('permission'));

        if ($role) {
            session()->flash('alert-success', 'تم الحفظ الدور  بنجاح');
        } else {
            session()->flash('alert-danger', 'فشل حفظ الدور الجديد ');
        }
        return redirect()->route('roles.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->get();

        return view('admin.rolesPermission.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        $PermissionsCategory = PermissionsCategory::with('permissions')->get();

        return view('admin.rolesPermission.edit', compact('role', 'rolePermissions', 'PermissionsCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminRoleRequest $request, Role $role)
    {
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->color = $request->input('color');

       if ($role->save() && $role->syncPermissions($request->input('permission'))) {
           return redirect()->route('roles.index')
           ->with('alert-success','تم تعديل الدور بنجاح');
        }

        return redirect()->route('roles.index')
        ->with('alert-danger', 'حدث خطأ اثناء تعديل الدور الأداري !!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role->delete()) {
            return redirect()->route('roles.index')
                ->with('alert-success', 'تم حذف الدور بنجاح !!');
        }

        return redirect()->route('roles.index')
        ->with('alert-danger', 'حدث خطأ اثناء حذف الدور الأداري !!');
    }
}
