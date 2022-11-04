<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreAdminRequest;
use App\Http\Requests\admin\UpdateAdminRequest;
use App\Http\Requests\admin\AssignAdminRoleRequest;
use App\Models\admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin-list|admin-create|admin-edit|admin-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:admin-create', ['only' => ['create', 'store', 'assignAdminRole']]);
        $this->middleware('permission:admin-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $users = User::select('users.*', 'countries.country_name', 'countries.country_code')
        ->leftjoin('countries', 'countries.id', 'users.country_id')
        ->with(['admin', 'roles'])->whereHas('admin')
        ->orderBy('id');
        
        if ($request->filled('search')) {
            if ($request->search[0] == '=') {
                $users = $users->where('users.id', substr($request->search, 1));
            } else {
                if (is_numeric($request->search)) {
                    # search only numitic values
                    $users = $users->where(function ($query) use ($request) {
                        $query->Where('users.phone', 'LIKE', '%' . $request->search . '%');
                    });
                } else {

                    $users = $users->where(function ($query) use ($request) {
                        $query->Where(DB::raw("CONCAT(users.first_name,' ',users.last_name)"), 'LIKE', "%" . $request->search . "%")->OrWhere('users.email', 'LIKE', '%' . $request->search . '%');
                    });
                }
            }
        }

        $users = $users->paginate(Config('view.per_page', 30));

        return view('admin.users.admin.index', compact('users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(admin $admin)
    {
        if ($admin->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف حساب المدير بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف حساب المدير ');
    }

    /**
     * assign admin Role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignAdminRole(AssignAdminRoleRequest $request)
    {

        $user = DB::transaction(function () use ($request) {
            $user = User::findOrFail($request->user_id);

            admin::create(['admin_id' => $user->id, 'job_title' => $request->job_title]);

            $user->assignRole($request->input('roles'));
            return $user;
        });

        if ($user) {
            $user->assignRole($request->input('roles'));
            return back()
                ->with('alert-success', 'تم اضافة المدير بنجاح');
        } else {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة المدير');
        }
    }

    public function getAdminProfile()
    {
        $admin= Auth::user();
        return view('admin.adminProfile',compact('admin'));
    }
}
