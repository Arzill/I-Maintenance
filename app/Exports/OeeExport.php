<?php

namespace App\Exports;

use App\Models\DetailMaintenance;
use App\Models\Oee;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class OeeExport implements FromQuery, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected $number;

    public function __construct()
    {
        $this->number = 0;
    }
    public function query()
    {
        $userLogin = Auth::id();
        return DetailMaintenance::query()->whereHas('maintenance', function ($query) use ($userLogin) {
            $query->where('jenis_maintenance', 'oee')->where('id_user', $userLogin);
        });
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
            $oee->nama_mesin,
            round($oee->performance) . "%",
            round($oee->quality) . "%",
            round($oee->avaibility) . "%",
            round($oee->result_oee) . "%",
            $oee->status_oee,
        ];
    }
}