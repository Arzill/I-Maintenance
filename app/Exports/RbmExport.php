<?php

namespace App\Exports;

use App\Models\Rbm;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class RbmExport implements FromQuery, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected $number;

    public function __construct()
    {
        $this->number = 0;
    }
    public function query()
    {
        $userLogin = Auth::id();
        return Rbm::query()->whereHas('maintenance', function ($query) use ($userLogin) {
            $query->where('jenis_maintenance', 'rbm')->where('id_user', $userLogin);
        });
    }
    public function title(): string
    {
        return 'Riwayat RBM';
    }
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Mesin',
            'Jangka Waktu',
            'Severity',
            'Occurrence',
            'RPN',
            'Risk',
            'Rekomendasi',
        ];
    }

    public function map($rbm): array
    {
        return [
            $this->number += 1,
            \App\Helpers\DateHelper::getIndonesiaDate($rbm->updated_at),
            $rbm->maintenance->nama_mesin,
            $rbm->jangka_waktu,
            $rbm->severity,
            $rbm->occurrence,
            round($rbm->result_rbm),
            $rbm->risk,
            $rbm->rekomendasi,
        ];
    }
}
