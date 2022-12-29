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
        $contracts = Contract::where("academic_year_id", 3)->where("odoo_sync_study_status", 0)->cursor();
        foreach ($contracts as $contract){
            try {
                $this->setOdooKeys($contract);
                $this->createInvoiceInOdoo($this->odooIntegrationKeys, $contract->id, $this->odooIntegrationTransportationKey, $this->odooIntegrationJournalKey);
                $this->odooIntegrationTransportationKey = [];
                $this->odooIntegrationJournalKey = [];
            }catch (\Exception $exception){
                \Log::error($exception);
                \Log::error("contract id = " . $contract->id);

            }
        }
        return Command::SUCCESS;
    }
}
