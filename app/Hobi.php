<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hobi extends Model
{
	//nama tabel
    protected $table = 'hobi';

    //mass assignment
    protected $fillable = ['nama_hobi'];

    // Relasi Hobi - Siswa
    public function siswa(){
    	//Argumen 1 = lokasi Model Siswa
    	//Argumen 2 = nama tabel pivot
    	//Argumen 3 = nama kolom yg menjadi foreign key pada tabel hobi_siswa
    	//Argumen 4 = nama kolom yg menjadi foreign key pada tabel siswa
    	return $this->belongsToMany('App\Siswa','hobi_siswa','id_hobi', 'id_siswa');
    }
}
