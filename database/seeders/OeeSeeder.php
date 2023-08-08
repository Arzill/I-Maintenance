<?php

namespace Database\Seeders;

use App\Models\DownTime;
use App\Models\Maintenance;
use App\Models\Oee;
use App\Models\PerhitunganOEE;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        function getMinuteDifference($start, $end)
        {
            $startTime = Carbon::createFromTimeString($start);
            $endTime = Carbon::createFromTimeString($end);
            return $endTime->diffInMinutes($startTime);
        }
        $startDate = now(); // Current time
        $endDate = now()->addMonths(3); // 3 bulan ke depan

        $currentDate = $startDate;

        while ($currentDate->lte($endDate)) {
            for ($i = 0; $i < 1; $i++) {
                $randomHours = rand(0, 22);
                $randomMinutes = rand(0, 1) === 0 ? 0 : 30; // 0 atau 30 menit
                $waktuMulaiProduksi = Carbon::now()->setTime($randomHours, $randomMinutes, 0);
                $waktuSelesaiProduksi = $waktuMulaiProduksi->copy()->addHour();

                $total_produksi = rand(0, 5000);
                $produksiIdeal = rand(0, 1000);
                $produksiCacat = rand(0, 500);
                $produksiBaik = $total_produksi - $produksiCacat;

                $waktuTotalProduksi = getMinuteDifference($waktuMulaiProduksi->toTimeString(), $waktuSelesaiProduksi->toTimeString());

                $perhitunganOee =  PerhitunganOEE::create([
                    'id_mesin' => Maintenance::inRandomOrder()->first()->id,
                    'waktu_mulai_produksi' => $waktuMulaiProduksi,
                    'waktu_selesai_produksi' => $waktuSelesaiProduksi,
                    'waktu_total_produksi' => $waktuTotalProduksi,
                    'down_time_terencana' => 0,
                    'total_produksi' => $total_produksi,
                    'tingkat_produksi_ideal' => $produksiIdeal,
                    'produksi_cacat' =>  $produksiCacat,
                    'produksi_baik' => $produksiBaik,
                    'created_at' => $currentDate,
                ]);
                if ($waktuTotalProduksi !== 0) {
                    $totalWaktuPeformance = ($produksiBaik / $waktuTotalProduksi);
                } else {
                    // Jika $waktuTotalProduksi nol, tetapkan nilai $totalWaktuPeformance ke nol atau nilai alternatif sesuai kebutuhan Anda
                    $totalWaktuPeformance = 0; // Atau nilai alternatif lainnya
                }
                // $totalWaktuPeformance = ($produksiBaik / $waktuTotalProduksi);
                $performance = $totalWaktuPeformance / $produksiIdeal;
                $performance = round($performance * 100, 2);
                $performance = max(0, $performance);
                $performance = min(100, $performance);

                if ($waktuTotalProduksi !== 0) {
                    $quality = ($total_produksi - $produksiCacat) / $total_produksi;
                } else {
                    // Jika $waktuTotalProduksi nol, tetapkan nilai $totalWaktuPeformance ke nol atau nilai alternatif sesuai kebutuhan Anda
                    $quality = 0; // Atau nilai alternatif lainnya
                }
                $quality = round($quality * 100, 2);
                $quality = max(0, $quality);
                $quality = min(100, $quality);
                if ($waktuTotalProduksi !== 0) {
                    $avaibility = ($waktuTotalProduksi / $waktuTotalProduksi) * 100;
                } else {
                    // Jika $waktuTotalProduksi nol, tetapkan nilai $totalWaktuPeformance ke nol atau nilai alternatif sesuai kebutuhan Anda
                    $avaibility = 0; // Atau nilai alternatif lainnya
                }
                $avaibility = round($avaibility, 2);
                $avaibility = max(0, $avaibility);
                $avaibility = min(100, $avaibility);

                $oeeValue = ($avaibility / 100) * ($performance / 100) * ($quality / 100);
                $oeeValue = round($oeeValue * 100, 2);
                $oeeValue = max(0, $oeeValue);
                $oeeValue = min(100, $oeeValue);
                if ($oeeValue >= 85) {
                    $status_oee = 'sudah baik';
                } else {
                    $status_oee = 'perlu pengecekan';
                }
                Oee::create([
                    'id_perhitungan' => $perhitunganOee->id,
                    'performance' => $performance,
                    'quality' => $quality,
                    'avaibility' => $avaibility,
                    'status_oee' => $status_oee,
                    'result_oee' => $oeeValue,
                    'created_at' => $perhitunganOee->created_at
                ]);
                DownTime::create([
                    'id_perhitungan' => $perhitunganOee->id,
                    'jenis_downtime' => '',
                    'jam_mulai_downtime' => '00:00:00',
                    'jam_selesai_downtime' => '00:00:00',
                    'jumlah_downtime' => 0,
                    'created_at' => $perhitunganOee->created_at
                ]);
                $currentDate->addDay();
            }
        }
    }
}