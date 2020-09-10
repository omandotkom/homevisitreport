<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Know extends Model
{
    protected $table = "knows";
    protected $fillable = ["id_visit","nama","jabatan"];
}
