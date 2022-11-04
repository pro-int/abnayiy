<?php

namespace App\Imports;

use App\Models\Contract;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Facades\Excel;

class StudentsDebtsImport implements ToCollection
{
    protected $year_id;
    public $skipped_students = [];
    public $updated_students = [];
    public $total_students = 0;

    function __construct(int $year_id)
    {
        $this->year_id = $year_id;
    }


    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        for ($i = 1; $i < count($rows); $i++) {

            $this->total_students++;
            if (isset($rows[$i][1]) && $rows[$i][7] !== 0) {
                $student_national_id = $rows[$i][1];
            

                $contract = Contract::select('contracts.id','contracts.student_id')
                ->where('students.national_id', $student_national_id)
                    ->join('students', 'students.id', 'contracts.student_id')
                    ->where('contracts.academic_year_id', $this->year_id)->first();

                    if ($contract) {
                    $transactions = array();
                    
                    $base = ['contract_id' => $contract->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'is_old_transaction' => 1, 'transaction_type' => 'debt'];

                    
                    $max = 7; //get column from 2 to 6
                    for ($column=2; $column < $max ; $column++) { 
                        // check if debt not equal to 0 or null
                        if (isset($rows[$i][$column]) && !empty($rows[$i][$column]) && $rows[$i][$column] !== 0) {
                            // check if debt less then 0 , if true - mark transaction as paid
                            $ipaid = $rows[$i][$column] <= 0 ? ['payment_status' => 1,'payment_date' => Carbon::now()] : ['payment_status' => 0,'payment_date' => null];
                          
                            // push transaction to transaction array , to be inserted
                            array_push($transactions,  $ipaid + $base + ['installment_name' => $rows[0][$column], 'amount_before_discount' => $rows[$i][$column], 'amount_after_discount' => $rows[$i][$column], 'residual_amount' => $rows[$i][$column]]);
                        }  
                    }

                    if (! empty($transactions)) {
                        Transaction::insert($transactions);
                        array_push($this->updated_students, $contract->student_id);
                        $contract->update_total_payments();
                    }
                } else {
                    array_push($this->skipped_students, $student_national_id);
                }
            }
        }
    }

    public function import($file)
    {
        Excel::import($this, $file);
    }
}
