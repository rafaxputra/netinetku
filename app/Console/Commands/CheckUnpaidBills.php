<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use Carbon\Carbon;

class CheckUnpaidBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-unpaid-bills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for unpaid bills and set customer status to nonaktif';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now();
        if ($today->day != 28) {
            $this->info('This command should only run on the 28th of the month.');
            return;
        }

        $unpaidBills = Tagihan::where('status', 'belum lunas')
            ->whereDate('tanggal_jatuh_tempo', '<=', $today)
            ->get();

        foreach ($unpaidBills as $tagihan) {
            $pelanggan = Pelanggan::find($tagihan->pelanggan_id);
            if ($pelanggan) {
                $pelanggan->status = 'nonaktif';
                $pelanggan->save();
                $this->info("Pelanggan with ID {$pelanggan->id} set to nonaktif due to unpaid bill.");
            }
        }
    }
}
