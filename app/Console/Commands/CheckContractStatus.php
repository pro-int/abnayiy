<?php

namespace App\Console\Commands;

use App\Models\AcademicYear;
use App\Models\Contract;
use App\Models\Level;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckContractStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contracts:checkStatus';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command run on dialy base , check if contract shoud be closed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $years = AcademicYear::whereDate('fiscal_year_end', Carbon::today())->get();

        foreach ($years as $year) {
            info($year);
            # loop to close years
            $contracts = Contract::where('academic_year_id',$year->id)->where('status',1)->whereHas('student')->with('student')->get();

            if ($contracts) {
                # load graduated level
                $levels = Level::where('is_graduated',true)->whereNull('next_level_id')->pluck('id')->toArray();
                foreach ($contracts as $contract) {

                    $contract->status = 2;
                    $contract->save();

                    info($contract->exam_result);
                    if (in_array($contract->level_id, $levels) && $contract->exam_result == 'pass') {
                        # student is gaduated
                        $contract->student->graduated = 1;
                        $contract->student->save();
                    }
                }
            }
        }
    }
}
