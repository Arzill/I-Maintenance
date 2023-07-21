<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['id'];

    public function oee()
    {
        return $this->hasMany(Oee::class, 'id_maintenance');
    }
    public function rbm()
    {
        return $this->hasMany(Rbm::class, 'id_maintenance');
    }
    public function lcc()
    {
        return $this->hasMany(Lcc::class, 'id_maintenance');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}