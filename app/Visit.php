<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = "visits";
    protected $fillable = ["nama","namakegiatan","tujuan","tanggal","tempat","hasil","foto","nosurat","dipa"];
    function officers(){
        return $this->hasMany('App\Officer','visit_id','id');
    }
}
