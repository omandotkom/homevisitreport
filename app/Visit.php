<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = "visits";
    protected $fillable = ["nama","namakegiatan","tujuan","tanggal","tempat","hasil","foto"];
}
