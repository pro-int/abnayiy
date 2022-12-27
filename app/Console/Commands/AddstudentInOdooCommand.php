<?php

namespace App\Console\Commands;

use App\Http\Traits\OdooIntegrationTrait;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddstudentInOdooCommand extends Command
{
    use OdooIntegrationTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:AddstudentInOdoo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $students = Student::where("odoo_sync_status", 0)->get();

        foreach ($students as $student){
            try {
                $this->createStudentInOdoo($student->getOdooKeys());
            }catch (\Exception $exception){
                info($exception);
                info("student id = " . $student->id);
            }
        }
        return Command::SUCCESS;
    }
}
