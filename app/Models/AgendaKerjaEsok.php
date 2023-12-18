<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaKerjaEsok extends Model
{
  protected $table = 'agenda_kerja_esok';
  protected $guarded = [];

  public function absensi()
  {
    return $this->belongsTo(Absensi::class);
  }
}
