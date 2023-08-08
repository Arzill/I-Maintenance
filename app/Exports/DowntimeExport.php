<?php

namespace App\Exports;

use App\Models\PerhitunganOEE;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class DowntimeExport implements FromQuery, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
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
        return 'Riwayat Downtime';
    }
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Mesin',
            'Jenis Downtime',
            'Lama downtime',
            'Downtime Terencana'
        ];
    }

    public function map($oee): array
    {
        return [
            $this->number += 1,
            \App\Helpers\DateHelper::getIndonesiaDate($oee->created_at),
            $oee->maintenance->nama_mesin,
            $oee->downTime->jenis_downtime,
            $oee->downTime->jumlah_downtime . " menit",
            $oee->down_time_terencana . " menit",
        ];
    }
}
