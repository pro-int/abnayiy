<?php

namespace App\Console\Commands;

use App\Http\Traits\OdooIntegrationTrait;
use App\Models\guardian;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddParentInOdooCommands extends Command
{
    use OdooIntegrationTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:AddParentInOdoo';

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
        $guardians = guardian::where("odoo_sync_status", 0)->get();
        foreach ($guardians as $guardian){
            $guardian->setOdooKeys($guardian);
            $this->createParentInOdoo($guardian->getOdooKeys());
        }
        return Command::SUCCESS;
    }
}
