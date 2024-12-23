<?php

namespace App\Exports;

use App\Models\Pelanggan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PelangganExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $pelangganData = Pelanggan::with(['user', 'paket', 'pembayaran'])
            ->select('id', 'user_id', 'alamat', 'no_hp', 'tanggal_pendaftaran', 'paket_id', 'status')
            ->get()
            ->map(function ($pelanggan) {
                $paymentHistory = [];
                $totalRevenue = 0;

                foreach ($pelanggan->pembayaran as $payment) {
                    $year = Carbon::parse($payment->tanggal_pembayaran)->format('Y');
                    $month = Carbon::parse($payment->tanggal_pembayaran)->format('F');
                    $day = Carbon::parse($payment->tanggal_pembayaran)->format('d');
                    $amount = $payment->jumlah_pembayaran;

                    if (!isset($paymentHistory[$year])) {
                        $paymentHistory[$year] = [];
                    }
                    if (!isset($paymentHistory[$year][$month])) {
                        $paymentHistory[$year][$month] = [];
                    }
                    $paymentHistory[$year][$month][] = ['day' => $day, 'amount' => $amount];
                    $totalRevenue += $amount;
                }


                $formattedPaymentHistory = '';
                foreach ($paymentHistory as $year => $months) {
                    $formattedPaymentHistory .= "Tahun Struk: $year\n";
                    foreach ($months as $month => $payments) {
                        $formattedPaymentHistory .= "  Bulan Struk: $month\n";
                        foreach ($payments as $payment) {
                            $formattedPaymentHistory .= "    Tanggal: {$payment['day']}, Nominal: {$payment['amount']}\n";
                        }
                    }
                }


                return [
                    'ID' => $pelanggan->id,
                    'Nama' => $pelanggan->user->name,
                    'Email' => $pelanggan->user->email,
                    'Alamat' => $pelanggan->alamat,
                    'No HP' => $pelanggan->no_hp,
                    'Tanggal Pendaftaran' => $pelanggan->tanggal_pendaftaran,
                    'Paket' => $pelanggan->paket->nama_paket,
                    'Status' => $pelanggan->status,
                    'Riwayat Pembayaran' => $formattedPaymentHistory,
                ];
            });

        return $pelangganData;
    }


    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'Alamat',
            'No HP',
            'Tanggal Pendaftaran',
            'Paket',
            'Status',
            'Riwayat Pembayaran'
        ];
    }
}
