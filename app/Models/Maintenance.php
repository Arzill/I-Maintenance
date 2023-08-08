<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory, Uuid;
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function perhitunganOee()
    {
        return $this->hasMany(PerhitunganOEE::class, 'id_mesin', 'id');
    }
    public function rbm()
    {
        return $this->hasMany(Rbm::class, 'id_mesin', 'id');
    }
    public function lcc()
    {
        return $this->hasMany(Lcc::class, 'id_mesin', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id');
    }
}
