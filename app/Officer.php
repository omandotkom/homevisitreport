<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    protected $table = "officers";
    protected $fillable = ["visit_id","nama","nip","jabatan"];
}
