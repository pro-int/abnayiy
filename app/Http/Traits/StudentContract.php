<?php

namespace App\Http\Traits;

use App\Models\AcademicYear;
use App\Models\Application;
use App\Models\Contract;
use App\Models\Student;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ContractInstallments;
use App\Http\Traits\ContractTransportation;
use Illuminate\Support\Facades\Auth;

trait StudentContract
{
    use ContractInstallments, ContractTransportation;

    public $year;
    public $semesters;
    public $tuition_fees;

    /**
     * Handle the event.
     *
     * @param  \App\Models\application  $application
     * @return bool $updated
     */
    public function NewStudent(Application $application)
    {
        $this->year = AcademicYear::findOrFail($application->academic_year_id);

        $this->semesters = match_semesters($this->year, Carbon::now());

        $this->tuition_fees = semesters_tuition_fees($application->level_id, $this->semesters);
        $result =  DB::transaction(function () use ($application) {
            return $this->CreateNewStudent($application);
        });
        return $result;
    }

    public function CreateNewStudent(Application $application)
    {

        #add student to student List
        $student = Student::create([
            'student_name' => $application->student_name,
            'birth_date' => $application->birth_date,
            'national_id' => $application->national_id,
            'birth_place' => $application->birth_place,
            'student_care' => (bool) $application->student_care,
            'guardian_id' => $application->guardian_id,
            'nationality_id' => $application->nationality_id,
            'gender' => $application->gender,
            // 'level_id' => $application->level_id,
            // 'plan_id' => $application->plan_i,
            // 'class_id' => $class_id,
        ]);

        return $this->CreateNewContract($application, $student);
    }

    public function CreateNewContract(Application $application, Student $student)
    {
        $vat = CalculateVat($student->nationality_id, $this->tuition_fees);
        $contract = Contract::create([
            'student_id' => $student->id,
            'application_id' => $application->id,
            'academic_year_id' => $this->year->id,
            'plan_id' => $application->plan_id,
            'level_id' => $application->level_id,
            'applied_semesters' => $this->semesters->pluck('id'),
            'tuition_fees' => $this->tuition_fees,
            'vat_rate' => $vat['vat_rate'],
            'vat_amount' => $vat['vat_amount'],
            'total_fees' =>  $this->tuition_fees + $vat['vat_amount'],
            'terms_id' => current_contract_term()->id,
            'admin_id' => Auth::id()
        ]);
        $logMessage = 'تم اضافة التعاقد بنجاح بواسطة '.Auth::user()->getFullName().' وتم انشاء الطالب كود : '.$student->id.' كود التعاقد : '.$contract->id;
        $this->logHelper->logApplication($logMessage, $application->id, Auth::id());
        $logMessage = 'تم اضافة التعاقد بنجاح بواسطة '.Auth::user()->getFullName().' وتم انشاء الطالب كود : '.$student->id;
        $this->logHelper->logContract($logMessage, $contract->id, Auth::id());

        return  $this->CheckStudentTransportation($application, $student, $contract);
    }

    public function CheckStudentTransportation(Application $application, Student $student, Contract $contract)
    {
        if (null !== $application->transportation_id) {
            $this->CreateStudentTransportation($application->transportation_id, $application->transportation_payment, $student->id, $contract->id);
        }

        return $this->CreateInstallments($contract, $student);
    }
}
