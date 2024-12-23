<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateMonthlyBill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:monthly-bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly bills for active customers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::unprepared('CALL generate_monthly_bill()');
        $this->info('Monthly bills generated successfully.');
    }
}
