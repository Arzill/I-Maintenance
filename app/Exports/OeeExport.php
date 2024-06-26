<?php

namespace App\Exports;

use App\Models\Oee;
use App\Models\PerhitunganOEE;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class OeeExport implements FromQuery, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected $number;
    protected $startDate;
    protected $endDate;
    protected $nama_mesin;
    public function __construct(
        $startDate,
        $endDate,
        $nama_mesin,
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->nama_mesin = $nama_mesin;
        $this->number = 0;
    }
    public function query()
    {
        $userLogin = Auth::id();
        if (Auth::user()->role === 'user') {
            $query =  PerhitunganOEE::query()->whereHas('maintenance', function ($query) use ($userLogin) {
                $query->where('id_pengguna', $userLogin);
            });
        } else {
            $query =  PerhitunganOEE::query()->whereHas('maintenance');
        }
        if (isset($this->nama_mesin)) {
            $query->whereHas('maintenance', function ($query) {
                $query->where('nama_mesin', $this->nama_mesin);
            });
        }

        if (isset($this->startDate) && isset($this->endDate)) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }
        return $query;
    }
    public function title(): string
    {
        return 'Riwayat OEE';
    }
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Mesin',
            'Waktu Mulai Produksi',
            'Waktu Selesai Produksi',
            'Jenis Downtime',
            'Jam Mulai Downtime',
            'Jam Selesai Downtime',
            'Jumlah Downtime',
            'Waktu Total Produksi',
            'Down Time Terencana',
            'Total Produksi',
            'Tingkat Produksi Ideal',
            'Produksi Cacat',
            'Produksi Baik',
            'Performance',
            'Quality',
            'Avaibility',
            'OEE',
            'Rekomendasi',
        ];
    }

    public function map($oee): array
    {
        return [
            $this->number += 1,
            \App\Helpers\DateHelper::getIndonesiaDate($oee->created_at),
            $oee->maintenance->nama_mesin,
            $oee->waktu_mulai_produksi,
            $oee->waktu_selesai_produksi,
            $oee->downTime->jenis_downtime,
            $oee->downTime->jam_mulai_downtime,
            $oee->downTime->jam_selesai_downtime,
            $oee->downTime->jumlah_downtime . " menit",
            $oee->waktu_total_produksi . " menit",
            $oee->down_time_terencana . " menit",
            $oee->total_produksi . " unit",
            $oee->tingkat_produksi_ideal . " unit/menit",
            $oee->produksi_cacat . " unit",
            $oee->produksi_baik . " unit",
            round($oee->oee->performance) . "%",
            round($oee->oee->quality) . "%",
            round($oee->oee->avaibility) . "%",
            round($oee->oee->result_oee) . "%",
            $oee->oee->status_oee,
        ];
    }
}
