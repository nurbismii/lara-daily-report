<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasPendukung extends Model
{
  protected $table = 'berkas_pendukung';
  protected $guarded = [];

  public function kegiatanHarian()
  {
    return $this->belongsTo(KegiatanHarian::class);
  }
}
