<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reporter extends Model
{
    protected $table ="reporters";
    protected $fillable = ["visit_id","nama","jabatan"];
}
