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

  public function dataPendukung()
  {
    return $this->hasMany(BerkasPendukung::class);
  }

  public function pelayanan()
  {
    return $this->hasMany(Pelayanan::class);
  }

  public function pelayananMingguan()
  {
    return $this->hasMany(Pelayanan::class, 'kegiatan_mingguan_id', 'id');
  }
}
