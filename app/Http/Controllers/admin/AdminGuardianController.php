<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\guardian;
use App\Http\Requests\guardian\StoreGuardianRequest;
use App\Http\Requests\guardian\UpdateGuardianRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminGuardianController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:guardians-list|guardians-create|guardians-edit|guardians-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:guardians-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:guardians-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:guardians-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = guardian::select(
            'guardians.*',
            'users.email',
            'users.phone',
            DB::raw("CONCAT(users.first_name,' ',users.last_name) as guardian_name"),
            'countries.country_name',
            'categories.category_name',
            'categories.color'
        )
            ->join('users', 'users.id', 'guardians.guardian_id')
            ->leftjoin('countries', 'countries.id', 'users.country_id')
            ->leftjoin('categories', 'categories.id', 'guardians.category_id')
            ->with('wallet','students');


        if ($request->has('search') && !empty($request->search)) {
            if ($request->search[0] == '=') {
                $users = $users->where('guardians.guardian_id', substr($request->search, 1));
            } else {
                if (is_numeric($request->search)) {
                    # search only numitic values
                    $users = $users->where(function ($query) use ($request) {
                        $query->Where('guardians.national_id', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('users.phone', 'LIKE', '%' . $request->search . '%');
                    });
                } else {

                    $users = $users->where(function ($query) use ($request) {
                        $query->Where(DB::raw("CONCAT(users.first_name,' ',users.last_name)"), 'LIKE', "%" . $request->search . "%")->OrWhere('users.email', 'LIKE', '%' . $request->search . '%');
                    });
                }
            }
        }


        if ($request->has('category_id') && is_numeric($request->category_id)) {
            $users = $users->where('guardians.category_id', $request->category_id);
        }

        $users = $users->orderBy('guardians.guardian_id')->paginate(30);

        return view('admin.users.guardian.index', compact('users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(guardian $guardian)
    {
        if ($guardian->delete()) {
            return redirect()->route('guardians.index')
                ->with('alert-success', 'تم حذف حساب ولي الامر بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف حساب ولي الامر ');
    }
}
