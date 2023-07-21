<?php

namespace App\Exports;

use App\Models\DetailMaintenance;
use App\Models\Lcc;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class LccExport implements FromQuery, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected $number;

    public function __construct()
    {
        $this->number = 0;
    }
    public function query()
    {
        $userLogin = Auth::id();
        return Lcc::query()->whereHas('maintenance', function ($query) use ($userLogin) {
            $query->where('jenis_maintenance', 'lcc')->where('id_user', $userLogin);
        });
    }
    public function title(): string
    {
        return 'Riwayat LCC';
    }
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Mesin',
            'Biaya Inisiasi',
            'Biaya Operasional Tahunan',
            'Biaya Pemeliharaan Tahunan',
            'Biaya Pembongkaran',
            'Estimasi Tahunan',
            'LCC',
        ];
    }

    public function map($lcc): array
    {
        return [
            $this->number += 1,
            \App\Helpers\DateHelper::getIndonesiaDate($lcc->created_at),
            $lcc->nama_mesin,
            "Rp " . round($lcc->biaya_inisiasi),
            "Rp " . round($lcc->biaya_operasional_tahunan),
            "Rp " . round($lcc->biaya_pemeliharaan_tahunan),
            "Rp " . round($lcc->biaya_pembongkaran),
            round($lcc->estimasi_tahunan),
            $lcc->result_lcc,
        ];
    }
}
