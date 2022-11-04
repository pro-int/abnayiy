<?php
/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationManager;
use App\Http\Requests\application\StoreApplicationManagerRequest;
use App\Http\Requests\application\UpdateApplicationManagerRequest;
use App\Models\admin;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminApplicationManageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ApplicationManagers-list|ApplicationManagers-create|ApplicationManagers-edit|ApplicationManagers-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:ApplicationManagers-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:ApplicationManagers-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:ApplicationManagers-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = admin::select('admins.*', 'users.first_name', 'users.last_name')
            ->leftjoin('users', 'users.id', 'admins.admin_id')
            ->with(['application_manager'])->whereHas('application_manager')
            ->orderBy('admins.admin_id')->paginate(30);

        return view('admin.users.admin.application.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schools =  School::with(['genders', 'genders.grades', 'genders.grades.levels'])->get();

        $ids =  ApplicationManager::pluck('admin_id')->toArray();

        $users = User::select(DB::raw('CONCAT(first_name, " " ,last_name, " - ", phone) as name'), 'id as admin_id')->whereHas('admin')->whereNotIn('users.id', $ids)->pluck('name', 'admin_id')->toArray();

        return view('admin.users.admin.application.create', compact('users', 'schools'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreApplicationManagerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicationManagerRequest $request)
    {
        try {
            foreach ($request->grade_id as  $level) {
                ApplicationManager::create(['admin_id' => $request->admin_id, 'grade_id' => (int)$level]);
            }
            return redirect()->route('ApplicationManagers.index')->with('alert-success', 'تم اضافة المشرف بنجاح');
        } catch (\Throwable $th) {

            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة المشرف ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($ApplicationManager)
    {
        try {

            $schools =  School::with(['genders', 'genders.grades'])->get();

            $ids =  ApplicationManager::where('admin_id', $ApplicationManager)->pluck('grade_id')->toArray();

            $ApplicationManager = User::select(DB::raw('CONCAT(first_name, " " ,last_name, " - ", phone) as admin_name,id as admin_id'))->findOrFail($ApplicationManager);

            return view('admin.users.admin.application.show', compact('schools', 'ids', 'ApplicationManager'));
            
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء استعراض شاشة تعديل المشرف ');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ApplicationManager)
    {
        try {

            $schools =  School::with(['genders', 'genders.grades'])->get();

            $ids =  ApplicationManager::where('admin_id', $ApplicationManager)->pluck('grade_id')->toArray();

            $ApplicationManager = User::select(DB::raw('CONCAT(first_name, " " ,last_name, " - ", phone) as admin_name,id as admin_id'))->findOrFail($ApplicationManager);

            return view('admin.users.admin.application.edit', compact('schools', 'ids', 'ApplicationManager'));
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء استعراض شاشة تعديل المشرف ');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateApplicationManagerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApplicationManagerRequest $request, $ApplicationManager)
    {
        try {
            ApplicationManager::where('admin_id', $ApplicationManager)->delete();
            foreach ($request->grade_id as  $level) {
                ApplicationManager::create(['admin_id' => $ApplicationManager, 'grade_id' => (int)$level]);
            }
            return redirect()->route('ApplicationManagers.index')->with('alert-success', 'تم تعديل معلومات المشرف بنجاح');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل حساب المشرف ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ApplicationManager)
    {
        try {
            if (ApplicationManager::where('admin_id', $ApplicationManager)->delete()) {
                return redirect()->route('ApplicationManagers.index')
                    ->with('alert-success', 'تم حذف  صلاحيات المشرف بنجاح');
            }
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناءحذف  صلاحيات المشرف ');
        }
    }
}
