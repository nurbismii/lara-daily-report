<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriWaktuKerja extends Model
{
  protected $table = 'kategori_waktu_kerja';
  protected $guarded = [];

  public function waktu_kerja()
  {
    return $this->belongsTo(WaktuKerja::class);
  }

  public function absensi()
  {
    return $this->belongsTo(Absensi::class);
  }
}
