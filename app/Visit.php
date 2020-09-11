<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = "visits";
    protected $fillable = ["nama","namakegiatan","tujuan","tanggal","tempat","hasil","nosurat","dipa","penutup","tanggalend","dasar"];
    function officers(){
        return $this->hasMany('App\Officer','visit_id','id');
    }
    function knows(){
        return $this->hasOne('App\Know','visit_id','id');
     
    }
    
    function reporters(){
        return $this->hasOne('App\Reporter','visit_id','id');
     
    }
    function photos(){
        return $this->hasMany('App\Photo','visit_id','id');
    }
}
