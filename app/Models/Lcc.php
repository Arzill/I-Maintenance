<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lcc extends Model
{
    use HasFactory, Uuid;
    protected $guarded = ['id'];

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class, 'id_maintenance');
    }

    public function scopeFilter($query, $params)
    {
        if (isset($params['search'])) {
            $query->whereHas('maintenance', function ($subquery) use ($params) {
                $subquery->where('nama_mesin', 'like', "%{$params['search']}%");
            });
        }
    }
}
