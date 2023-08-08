<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerhitunganOEE extends Model
{
    use HasFactory, Uuid;

    protected $table = 'perhitungan_oee';
    protected $guarded = ['id'];

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class, 'id_mesin', 'id');
    }

    public function oee()
    {
        return $this->hasOne(Oee::class, 'id_perhitungan', 'id');
    }
    public function downtime()
    {
        return $this->hasOne(DownTime::class, 'id_perhitungan', 'id');
    }
    public function scopeFilter($query, $params)
    {
        if (isset($params['search'])) {
            $query->whereHas('maintenance', function ($subquery) use ($params) {
                $subquery->where('nama_mesin', 'like', "%{$params['search']}%");
            });
        }
        if (isset($params['nama_mesin'])) {
            $query->whereHas('maintenance', function ($subquery) use ($params) {
                $subquery->where('nama_mesin', 'like', "%{$params['nama_mesin']}%");
            });
        }
        if (isset($params['tanggal'])) {
            $dateRange = explode(' - ', $params['tanggal']);

            if (count($dateRange) === 2) {
                $startDate = $dateRange[0];
                $endDate = $dateRange[1];

                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }
    }
}
