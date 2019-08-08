<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    // Harus pakai $tabel = 'siswa' karena kalo tidak akan kebaca siswas (plural pd tabel)  
    protected $table = 'siswa'; 
    
    // Mass Assignment
    protected $fillable = [
    	'nisn',
    	'nama_siswa',
    	'tanggal_lahir',
    	'jenis_kelamin',
        'id_kelas'
    ];

    // Menjadikan kolom tanggal_lahir menjadi instance dari Carbon
    protected $dates = ['tanggal_lahir']; 

    // accessor atau getter
    public function getNamaSiswaAttribute($nama_siswa){
    	return ucwords($nama_siswa);
    }

    // mutator atau setter
    public function setNamaSiswaAttribute($nama_siswa){
    	 $this->attributes['nama_siswa'] = strtolower($nama_siswa);
    }

    public function getHobiSiswaAttribute(){
        return $this->hobi->pluck('id')->toArray();
    }

    // One to One
    // Relasi Siswa - Telepon
    public function telepon(){
        //hasOne = satu siswa memiliki satu telepon
        return $this->hasOne('App\Telepon','id_siswa');
    }

    // Many to One
    // Relasi Siswa - Kelas
    public function kelas(){
        return $this->belongsTo('App\Kelas','id_kelas');
    }

    // Many to Many
    // Relasi Siswa - Hobi
    public function hobi(){
        // withTimeStamps() digunakan menghindari error ketika insert/update, karena di tabel hobi_siswa ada timpstamps nya juga
        return $this->belongsToMany('App\Hobi', 'hobi_siswa', 'id_siswa', 'id_hobi')->withTimeStamps();
    }
}

