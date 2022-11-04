<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceManager;
use App\Http\Requests\attendance\StoreAttendanceManageRequest;
use App\Http\Requests\attendance\UpdateAttendanceManageRequest;
use App\Models\admin;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAttendanceManageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:AttendanceManagers-list|AttendanceManagers-create|AttendanceManagers-edit|AttendanceManagers-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:AttendanceManagers-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:AttendanceManagers-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:AttendanceManagers-delete', ['only' => ['destroy']]);
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
            ->with(['attendance_manager'])->whereHas('attendance_manager')
            ->orderBy('admins.admin_id')->paginate(30);

        return view('admin.users.admin.attendance.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schools =  School::with(['genders', 'genders.grades', 'genders.grades.levels'])->get();

        $ids =  AttendanceManager::pluck('admin_id')->toArray();

        $users = User::select(DB::raw('CONCAT(first_name, " " ,last_name, " - ", phone) as name'), 'id')->whereHas('admin')->whereNotIn('users.id', $ids)->pluck('name', 'id')->toArray();

        return view('admin.users.admin.attendance.create', compact('users', 'schools'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreAttendanceManageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceManageRequest $request)
    {
        try {
            foreach ($request->level_id as  $level) {
                AttendanceManager::create(['admin_id' => $request->admin_id, 'level_id' => (int)$level]);
            }
            return redirect()->route('AttendanceManagers.index')->with('alert-success', 'تم اضافة المشرف بنجاح');
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
    public function show(admin $AttendanceManager)
    {
        try {

            $schools =  School::with(['genders', 'genders.grades', 'genders.grades.levels', 'genders.grades.levels.classrooms'])->get();

            $ids =  AttendanceManager::where('admin_id', $AttendanceManager->admin_id)->pluck('level_id')->toArray();

            $users = User::select(DB::raw('CONCAT(first_name, " " ,last_name, " - ", phone) as name'), 'id')->where('id', $AttendanceManager->admin_id)->whereNotIn('users.id', $ids)->pluck('name', 'id')->toArray();

            return view('admin.users.admin.attendance.show', compact('schools', 'ids', 'users', 'AttendanceManager'));
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
    public function edit(admin $AttendanceManager)
    {
        try {

            $schools =  School::with(['genders', 'genders.grades', 'genders.grades.levels', 'genders.grades.levels.classrooms'])->get();

            $ids =  AttendanceManager::where('admin_id', $AttendanceManager->admin_id)->pluck('level_id')->toArray();

            $users = User::select(DB::raw('CONCAT(first_name, " " ,last_name, " - ", phone) as name'), 'id')->where('id', $AttendanceManager->admin_id)->whereNotIn('users.id', $ids)->pluck('name', 'id')->toArray();

            return view('admin.users.admin.attendance.edit', compact('schools', 'ids', 'users', 'AttendanceManager'));
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
    public function update(UpdateAttendanceManageRequest $request, admin $AttendanceManager)
    {
        try {
            AttendanceManager::where('admin_id', $AttendanceManager->admin_id)->delete();
            foreach ($request->level_id as  $level) {
                AttendanceManager::create(['admin_id' => $request->admin_id, 'level_id' => (int)$level]);
            }
            return redirect()->route('AttendanceManagers.index')->with('alert-success', 'تم تعديل معلومات المشرف بنجاح');
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
    public function destroy(admin $AttendanceManager)
    {
        try {
            if (AttendanceManager::where('admin_id', $AttendanceManager->admin_id)->delete()) {
                return redirect()->route('AttendanceManagers.index')
                    ->with('alert-success', 'تم حذف  صلاحيات المشرف بنجاح');
            }
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناءحذف  صلاحيات المشرف ');
        }
    }
}
