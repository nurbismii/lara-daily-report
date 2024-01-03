<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
  protected $connection = 'virtuon';
  protected $table = 'employees';
  protected $guarded = [];

}
