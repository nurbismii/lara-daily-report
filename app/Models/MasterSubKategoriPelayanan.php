<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterSubKategoriPelayanan extends Model
{
  protected $table = 'master_sub_kategori_pelayanan';
  protected $guarded = [];

  public function masterPelayanan()
  {
    return $this->belongsTo(MasterPelayanan::class);
  }

  public function MasterKategoriPelayanan()
  {
    return $this->belongsTo(MasterKategoriPelayanan::class);
  }
}
