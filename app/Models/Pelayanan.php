<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
  protected $table = 'pelayanan';
  protected $guarded = [];

  public function MasterPelayanan()
  {
    return $this->hasOne(MasterPelayanan::class, 'id', 'pelayanan_id');
  }

  public function MasterKategoriPelayanan()
  {
    return $this->hasOne(MasterKategoriPelayanan::class, 'id', 'kategori_pelayanan_id');
  }

  public function MasterSubKategoriPelayanan()
  {
    return $this->hasOne(MasterSubKategoriPelayanan::class, 'id', 'sub_kategori_pelayanan_id');
  }
}
