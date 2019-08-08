<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    //mass assignment
    protected $fillable = ['nama_kelas'];

    // One to Many
    // Relasi Kelas - Siswa
    public function siswa() {
    	//1 kelas punya banyak siswa
    	return $this->hasMany('App\Siswa', 'id_kelas');
    }
}
