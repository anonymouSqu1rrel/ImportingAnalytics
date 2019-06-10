<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetBestSellingFunnelForMerchant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:GetBestSellingFunnelForMerchant {--idMerchant=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $idMerchant = $this->option("idMerchant");
        if($idMerchant == null)
        {
            $this->error("You have to specify id Merchant!");
            return;
        }

        $this->info(\App::call('App\Http\Controllers\Api\AnalyticsController@GetBestSellingFunnelForMerchant', [$idMerchant]));
        return;
    }
}
