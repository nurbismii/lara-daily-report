<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterPelayanan extends Model
{
  protected $table = 'master_pelayanan';
  protected $guarded = [];

  public function masterKategori()
  {
    return $this->hasMany(MasterKategoriPelayanan::class);
  }
}
