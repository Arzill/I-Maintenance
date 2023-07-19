<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['id'];

    public function detailMaintenance()
    {
        return $this->hasOne(DetailMaintenance::class, 'id_maintenance');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
