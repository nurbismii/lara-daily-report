<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
  protected $table = 'kegiatan';
  protected $guarded = [];

  public function kegitanHarian()
  {
    return $this->belongsTo(KegiatanHarian::class);
  }
}
