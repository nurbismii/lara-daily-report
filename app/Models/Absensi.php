<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
  protected $table = 'absensi';
  protected $guarded = [];

  public function kegiatanHarian()
  {
    return $this->hasMany(KegiatanHarian::class);
  }

  public function agendaEsok()
  {
    return $this->hasMany(AgendaKerjaEsok::class);
  }

  public function getAnggota()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }
}
