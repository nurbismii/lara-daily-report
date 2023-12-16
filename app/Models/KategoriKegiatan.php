<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKegiatan extends Model
{
  protected $table = 'kategori_kegiatan';
  protected $guarded = [];

  public function kegiatanHarian()
  {
    return $this->belongsTo(KegiatanHarian::class);
  }
}
