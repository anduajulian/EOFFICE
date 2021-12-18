<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaDinas extends Model
{
    protected $fillable = [
        'nomor','kepada','dari','tembusan','tanggal','sifat','lampiran', 'hal', 'softfile', 'koreksi', 'id_penerima', 'id_pembuat', 'status', 'read'
    ];
}
