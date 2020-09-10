<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = "visits";
    protected $fillable = ["nama","namakegiatan","tujuan","tanggal","tempat","hasil","foto","nosurat","dipa","foto2","penutup","tanggalend"];
    function officers(){
        return $this->hasMany('App\Officer','visit_id','id');
    }
    function knows(){
        return $this->hasMany('App\Know','visit_id','id');
     
    }
    
    function reporters(){
        return $this->hasMany('App\Reporter','visit_id','id');
     
    }
}
