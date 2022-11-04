<?php
/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\teacher\StoreTeacherRequest;
use App\Http\Requests\teacher\UpdateTeacherRequest;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminTeacherController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:teachers-list|teachers-create|teachers-edit|teachers-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:teachers-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:teachers-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:teachers-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        session()->flash('alert-danger','رجاء العلم انة لم يتم الانتهاء من هذا الجزء في النظام لعدم انتهاء الجزء الخاص بمواد التدريس','warning');

        $users = User::select('users.*', 'countries.country_name', 'countries.country_code')
            ->leftjoin('countries', 'countries.id', 'users.country_id')
            ->with(['teacher'])->whereHas('teacher')
            ->orderBy('id')->paginate(30);

        return view('admin.users.teacher.index', compact('users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        if ($teacher->delete()) {
            return redirect()->route('teachers.index')
                ->with('alert-success', 'تم حذف حساب المعلم بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف حساب المعلم ');
    }
}
