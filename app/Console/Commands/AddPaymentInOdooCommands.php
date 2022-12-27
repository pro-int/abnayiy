<?php

namespace App\Console\Commands;

use App\Http\Traits\OdooIntegrationTrait;
use App\Models\PaymentAttempt;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddPaymentInOdooCommands extends Command
{
    use OdooIntegrationTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:AddPaymentInOdoo';

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
        $paymentAttempts = PaymentAttempt::where("created_at",">=",Carbon::parse("01-08-2022 00:00:00"))->where("odoo_sync_status", 0)->where("approved",1)->cursor();
        foreach ($paymentAttempts as $paymentAttempt){
            try{
                $this->createPaymentInOdoo($paymentAttempt->getOdooKeys(), $paymentAttempt->id);
            }catch (\Exception $exception){
                info($exception);
                info("payment id = " . $paymentAttempt->id);

            }
        }
        return Command::SUCCESS;
    }
}
