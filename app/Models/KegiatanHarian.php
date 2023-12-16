<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanHarian extends Model
{
  protected $table = 'kegiatan_harian';
  protected $guarded = [];

  public function absensi()
  {
    return $this->belongsTo(Absensi::class);
  }
}
