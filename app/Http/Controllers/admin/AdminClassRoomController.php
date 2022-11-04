<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Http\Requests\ClassRoom\StoreClassRoomRequest;
use App\Http\Requests\ClassRoom\UpdateClassRoomRequest;
use App\Models\AcademicYear;
use App\Models\Application;
use App\Models\Contract;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Level;
use App\Models\Student;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminClassRoomController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:classes-list|classes-create|classes-edit|classes-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:classes-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:classes-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:classes-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AcademicYear $year)
    {
        $classrooms = ClassRoom::select('class_rooms.id', 'class_rooms.class_name', 'class_rooms.class_name_noor', 'class_rooms.level_id', 'levels.level_name', 'genders.gender_name', 'schools.school_name', 'grades.grade_name')
            ->leftjoin('levels', 'levels.id', 'class_rooms.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->where('academic_year_id', $year->id)
            ->orderBy('class_rooms.id');


        if ($request->has('school_id') && is_numeric($request->school_id)) {
            $classrooms = $classrooms->where('schools.id', $request->school_id);
        }

        if ($request->has('gender_id') && is_numeric($request->gender_id)) {
            $classrooms = $classrooms->where('genders.id', $request->gender_id);
        }

        if ($request->has('grade_id') && is_numeric($request->grade_id)) {
            $classrooms = $classrooms->where('grades.id', $request->grade_id);
        }

        if ($request->has('level_id') && is_numeric($request->level_id)) {
            $classrooms = $classrooms->where('levels.id', $request->level_id);
        }


        if ($request->has('level') && is_numeric($request->level)) {
            $classrooms = $classrooms->where('class_rooms.level_id', $request->level);
        }

        $classrooms = $classrooms->get();

        return view('admin.clases.index', compact('classrooms', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(AcademicYear $year)
    {
        return view('admin.clases.create', compact('year'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Store\ClassRoomClassRoomRequest  $request
     * @return \Illuminate\Htt\ClassRoomp\Response
     */
    public function store(StoreClassRoomRequest $request, AcademicYear $year)
    {
        $level = Level::findOrFail($request->level_id);
        $sc = Application::where('level_id', $level->id)->where('academic_year_id', $year->id)->where('status_id', env('PINDING_APPLCATION', 4))->count();

        if ($sc >= $level->min_students) {
            $class = ClassRoom::create($request->only(['class_name', 'class_name_noor', 'level_id']) + ['academic_year_id' => $year->id]);

            if ($class) {
                return redirect()->route('years.classrooms.index', $year)
                    ->with('alert-success', 'تم اضافة الفصل بنجاح');
            }
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة الفصل')->withInput();
        }

        return redirect()->back()
            ->with('alert-warning', "لاضافة فصل جديد يجب ان يكون عدد الطلاب في قائمة الانتظار هو  $level->min_students و العدد الحالي هو  $sc")->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function show($year, $classroom)
    {
        $classroom = ClassRoom::select('class_rooms.id', 'class_rooms.class_name', 'class_rooms.class_name_noor', 'class_rooms.level_id', 'schools.id as school_id', 'genders.id as gender_id', 'grades.id as grade_id', 'academic_years.year_name')
            ->leftjoin('levels', 'levels.id', 'class_rooms.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->leftjoin('academic_years', 'academic_years.id', 'class_rooms.academic_year_id')
            ->findOrFail($classroom);

        return view('admin.clases.view', compact('year', 'classroom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function edit($year, $classroom)
    {
        $classroom = ClassRoom::select('class_rooms.id', 'class_rooms.class_name', 'class_rooms.class_name_noor', 'class_rooms.level_id', 'schools.id as school_id', 'genders.id as gender_id', 'grades.id as grade_id', 'academic_years.year_name')
            ->leftjoin('levels', 'levels.id', 'class_rooms.level_id')
            ->leftjoin('grades', 'grades.id', 'levels.grade_id')
            ->leftjoin('genders', 'genders.id', 'grades.gender_id')
            ->leftjoin('schools', 'schools.id', 'genders.school_id')
            ->leftjoin('academic_years', 'academic_years.id', 'class_rooms.academic_year_id')
            ->findOrFail($classroom);

        return view('admin.clases.edit', compact('year', 'classroom'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClassRoomRequest  $request
     * @param  \App\Models\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClassRoomRequest $request, $year, ClassRoom $classroom)
    {
        if ($classroom->update($request->only(['class_name', 'class_name_noor', 'level_id']))) {
            return redirect()->route('years.classrooms.index', $year)
                ->with('alert-success', 'تم تعديل معلومات الصف بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تعديل معلومات الصف ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function destroy($year, ClassRoom $classroom)
    {
        if ($classroom->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم الفصل  ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناءخذف الصف ');
    }

    /**
     * manage clas rome students 
     *
     * @param  \App\Models\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function students(AcademicYear $year, ClassRoom $classroom)
    {
        $students = Student::select('contracts.id', 'contracts.student_id', 'contracts.level_id', 'contracts.student_id', 'contracts.class_id', 'students.student_name', 'students.student_care', 'students.national_id', 'nationalities.nationality_name', 'students.birth_date')
            ->join('contracts', 'contracts.student_id', 'students.id')
            ->leftjoin('nationalities', 'nationalities.id', 'students.nationality_id')
            ->where('contracts.academic_year_id', $classroom->academic_year_id)
            ->where('contracts.level_id', $classroom->level_id)
            ->whereNull('contracts.class_id')
            ->orWhere('contracts.class_id', $classroom->id)
            ->get();

        if (! count($students)) {
            return redirect()->back()
                ->with('alert-warning', 'لا توجد طلاب مسجلة في المرحلة الدراسية الخاصة بهذا الفصل');
        }

        return view('admin.clases.students', compact('students', 'year', 'classroom'));
    }

    public function StoreStudents(Request $request, $year, ClassRoom $classroom)
    {

        try {
            DB::beginTransaction();

            //  remove all students from class
            Contract::where('class_id', $classroom->id)->update(['class_id' => null]);

            // and new student list
            if ($request->filled('students')) {
                Contract::whereIn('student_id', $request->students)->update(['class_id' => $classroom->id]);
            }

            DB::commit();

            return redirect()->route('years.classrooms.students.view', ['year' => $year, 'classroom' => $classroom])->with('alert-success', 'تم تحديث الطلاب في الفصل بنجاح');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::debug($th);

            session()->flash('alert-danger', 'خطأ اثناء تحديث قائمة الطلاب');
            return back()->withInput();
        }
    }
}
