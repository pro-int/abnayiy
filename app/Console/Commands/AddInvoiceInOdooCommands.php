<?php

namespace App\Console\Commands;

use App\Http\Traits\ContractInstallments;
use App\Http\Traits\OdooIntegrationTrait;
use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddInvoiceInOdooCommands extends Command
{
    use OdooIntegrationTrait, ContractInstallments;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:AddInvoiceInOdoo';

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
        $contracts = Contract::where("created_at",">=",Carbon::parse("01-08-2022 00:00:00"))->where("odoo_sync_status", 0)->cursor();
        foreach ($contracts as $contract){
            try {
                $this->setOdooKeys($contract);
                $this->createInvoiceInOdoo($this->odooIntegrationKeys, $contract->id);
            }catch (\Exception $exception){
                info($exception);
                info("contract id = " . $contract->id);

            }
        }
        return Command::SUCCESS;
    }
}
