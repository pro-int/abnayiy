<?php

namespace App\Imports;

use App\Models\Contract;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;

class StudentsResultsImport implements ToCollection
{
    protected $year_id;
    protected $result;
    protected $ignore_old_result;
    public $skipped_students = [];
    public $updated_students = [];
    public $total_students = 0;

    function __construct(int $year_id, int $result, bool $ignore_old_result = false)
    {
        $this->year_id = $year_id;
        $this->result = $result;
        $this->ignore_old_result = $ignore_old_result;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
       
        $first_studnent = false;

        for ($i = 0; $i < count($rows); $i++) {

            if ($first_studnent && isset($rows[$i][15]) && $student_national_id = $rows[$i][15]) {
                $this->total_students ++;
                $contract = Contract::select('contracts.id','contracts.student_id','contracts.exam_result','students.guardian_id','contracts.academic_year_id')
                ->where('students.national_id', $student_national_id)
                    ->leftJoin('students', 'students.id', 'contracts.student_id')
                    ->where('contracts.status', 1)
                    ->where('contracts.academic_year_id', $this->year_id);

                $contract = $contract->first();

                if ($contract) {
                    $this->updateContract($contract);
                } else {
                    array_push($this->skipped_students, $student_national_id);
                }
            } else if (isset($rows[$i][15]) && $rows[$i][15] == 'رقم الهوية') {
                $first_studnent = true;
            }
        }
    }

    protected function updateContract(Contract $contract)
    {
        if ($this->ignore_old_result || is_null($contract->getRawOriginal('exam_result'))) {            
            $contract->exam_result = $this->result;
            $contract->update();
            array_push($this->updated_students, $contract->student_id);
        }
    }

    public function import($file)
    {
        Excel::import($this, $file);
    }
}
