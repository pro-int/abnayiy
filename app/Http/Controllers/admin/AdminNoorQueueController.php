<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Imports\StudentsNoorSynchronizationImport;
use App\Models\NoorQueue;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminNoorQueueController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:students-list|students-create|students-edit|students-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:students-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:students-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:students-delete', ['only' => ['destroy']]);
    }


    public function create()
    {
        return view('admin.student.noor.create');
    }

    public function store(Request $request)
    {
        try {
            $import = new StudentsNoorSynchronizationImport((bool) $request->updateStudentName);
            $import->import($request->file('sheet_path'));
            $skipped_students = $import->skipped_students;
            $total_students = $import->total_students;

            $class = 'warning';

            if (!$total_students) {
                $message = 'لم يتم العثور علي طلاب في الملف المرفق';
            } else {
                if (!empty($skipped_students)) {
                    $message = sprintf('لم يتم العثور علي %s طالب/ة من اصل %s طالب/ة', count($skipped_students), $total_students);
                } else {
                    $message = 'تم تحديث نتيجة الطلاب بنجاح ';
                    $class = 'success';
                }
            }

            session()->flash("alert-$class", $message);

            return view('admin.student.noor.create', compact('skipped_students'));
        } catch (\Throwable $th) {
            Log::debug($th);
            return back()->with('alert-danger', 'خطا اثناء قراءة ملف النتائج .. تأكد من عدم تغيير تنسيق الملف الصادر من نظام نور')->withInput();
        }
    }

    public function getNewJob(Request $request)
    {
        info($request);
        return NoorQueue::select('noor_queues.*', 'noor_accounts.school_name', 'noor_accounts.username', 'noor_accounts.password', 'grades.grade_name_noor', 'class_rooms.class_name_noor')
            ->where('job_status', 'new')
            ->leftjoin('noor_accounts', 'noor_accounts.id', 'noor_queues.noor_account_id')
            ->leftjoin('grades', 'grades.id', 'noor_queues.grade_id')
            ->leftjoin('class_rooms', 'class_rooms.id', 'noor_queues.class_id')
            ->first();
    }

    public function update_job(Request $request)
    {
        $job = NoorQueue::find($request->id);

        $job->job_result = $request->job_result;
        if ($request->has('attach')) {
            Storage::putFileAs(
                'noor-files',
                $request->attach,
                $job->id . '-result-file.xlsx'
            );
            $job->file_path = 'noor-files/' . $job->id . '-result-file.xlsx';
        }
        if (is_callable($job->func_name)) {
            call_user_func($job->func_name, $job);
        }
        return response('ok');
    }

    public function change_job_stu(Request $request)
    {
        $job = NoorQueue::find($request->id);
        if ($job) {
            $job->job_status = (int) $request->job_status;
            $job->save();
        }
        return response('ok');
    }

    protected function get_student_data(NoorQueue $job)
    {
        $import = new StudentsImport();
        $import->import($job);
    }
}
