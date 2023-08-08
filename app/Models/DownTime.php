<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownTime extends Model
{
    use HasFactory, Uuid;

    protected $table = 'down_times';
    protected $guarded = ['id'];

    public function perhitunganOee()
    {
        return $this->belongsTo(PerhitunganOEE::class, 'id_perhitungan', 'id');
    }
}