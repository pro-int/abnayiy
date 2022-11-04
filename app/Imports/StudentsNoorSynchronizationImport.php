<?php

namespace App\Imports;

use App\Models\Contract;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;

class StudentsNoorSynchronizationImport implements ToCollection
{
    protected $updateStudentName;
    public $skipped_students = [];
    public $updated_students = [];
    public $total_students = 0;

    function __construct(bool $updateStudentName = false)
    {

        $this->updateStudentName = $updateStudentName;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $last_coulom = '';
        $step = 1;
        $first_studnent = false;
        // info($rows[9][3]);
        // info($rows[12][3]);
        // info($rows[16][2]);

        for ($i = 0; $i < count($rows); $i+=$step) {
            
            if ($last_coulom == 'Student\'s Name') {
                $first_studnent = true;
                $step +=1;
            }
            $last_coulom = $rows[$i][36];
            if ($first_studnent) {
                $this->total_students ++;
                $student = Student::where('national_id', $rows[$i][29])->first();
                if ($student) {
                    if ($this->updateStudentName) {
                        $student->student_name =  $rows[$i][36];
                        $student->student_name_en =  $rows[$i + 1][36];
                    }
                    $student->birth_date = Carbon::createFromFormat('d/m/Y', $rows[$i + 1][19]);
                    $student->last_noor_sync = Carbon::now();
                    $student->save();
                    array_push($this->updated_students,$rows[$i][29]);
                } else {
                    array_push($this->skipped_students,$rows[$i][29]);
                    // info([
                    //     'student_name_ar' => $rows[$i][36],
                    //     'student_name_en' => $rows[$i + 1][36],
                    //     'attend_data' => $rows[$i][5],
                    //     'neworold' => $rows[$i][6],
                    //     'stauus' => $rows[$i][18],
                    //     'birthdate' => $rows[$i + 1][19],
                    //     'birthdate_1' => $rows[$i + 1][19],
                    //     'national_id' => $rows[$i][29],
                    //     'id_type' => $rows[$i][31],
                    //     'country' => $rows[$i][34],
                    // ]);
                }
            }
        }
    }

    public function import($file)
    {
        Excel::import($this, $file);
    }
}
