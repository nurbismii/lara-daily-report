<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
  protected $table = 'tim';
  protected $guarded = [];

  public function anggotaTim()
  {
    return $this->hasMany(AnggotaTim::class);
  }

  public function getKetua()
  {
    return $this->hasOne(User::class, 'id', 'ketua_tim_id');
  }

  public function getSpv()
  {
    return $this->hasOne(User::class, 'id', 'supervisor_id');
  }
}
