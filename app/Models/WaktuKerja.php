<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaktuKerja extends Model
{
  protected $table = 'waktu_kerja';
  protected $guarded = [];

  public function kategori_waktu_kerja()
  {
    return $this->hasMany(KategoriWaktuKerja::class);
  }
}
