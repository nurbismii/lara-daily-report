<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKategoriPelayanan extends Model
{
  protected $table = 'master_kategori_pelayanan';
  protected $guarded = [];

  public function masterPelayanan()
  {
    return $this->belongsTo(MasterPelayanan::class);
  }

  public function subKategoriPelayanan()
  {
    return $this->hasMany(MasterSubKategoriPelayanan::class);
  }
}
