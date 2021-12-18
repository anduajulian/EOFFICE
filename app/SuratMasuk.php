<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $fillable = [
        'nomor', 'kepada', 'dari', 'tanggal', 'sifat', 'lampiran', 'hal', 'softfile', 'id_penerima', 'id_pembuat', 'status', 'read'
    ];
}
