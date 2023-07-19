<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailMaintenance extends Model
{
    use HasFactory, Uuid;

    protected $table = 'detail_maintenances';
    protected $guarded = ['id'];


    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class, 'id_maintenance');
    }

    public function scopeFilter($query, $params)
    {
        if (@$params['search']) {
            $query->where('nama_mesin', 'like', "%{$params['search']}%");
        }
    }
}
