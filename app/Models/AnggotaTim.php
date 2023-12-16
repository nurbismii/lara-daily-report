<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaTim extends Model
{
  protected $table = 'anggota_tim';
  protected $guarded = [];

  public function tim()
  {
    return $this->belongsTo(Tim::class);
  }

  public function getAnggota()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }
}
