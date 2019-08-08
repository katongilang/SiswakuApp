<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telepon extends Model
{
    // Nama Tabel
    protected $table ='telepon';

    // tabel telepon memakai id_siswa sebagai primary key, k
    // jika tdk dibuat maka laravel menganggap id di table siswa sbg primarykey
    protected $primaryKey = 'id_siswa'; 

    // Mass Assignment
    protected $fillable = ['id_siswa','nomor_telepon'];


    // One to One
    // Relasi Telepon - Siswa
    public function siswa(){
    	//belongsTo = setiap telepon milik siswa
    	return $this->belongsTo('App\Siswa','id_siswa');
    }
}
