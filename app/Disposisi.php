<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    protected $fillable = [
        'nomor_agenda', 'tgl_selesai', 'isi', 'catatan', 'disposisi', 'diteruskan', 'paraf', 'softfile', 'id_penerima', 'id_pembuat', 'id_surmas', 'status', 'read', 'hardcopy'
    ];
}
