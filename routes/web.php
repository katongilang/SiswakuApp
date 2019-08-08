<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@homepage'); //pindah ke home
Route::get('about','PagesController@about'); //pindah ke about
Route::get('siswa','SiswaController@index'); //pindah ke siswa

Route::get('siswa/create','SiswaController@create'); //pindah ke Tambah siswa, harus diatas Siswacontroller@show!
Route::post('siswa','SiswaController@store'); //menyimpan hasil tambah siswa
Route::get('siswa/{siswa}','SiswaController@show'); //pindah ke detail siswa
Route::get('siswa/{siswa}/edit','SiswaController@edit'); //menampilkan form edit
Route::patch('siswa/{siswa}','SiswaController@update'); //melakukan update pada form edit
Route::delete('siswa/{siswa}','SiswaController@destroy'); //hapus
Route::get('date-mutator','SiswaController@dateMutator');

//Coretan Collection
/*Route::get('tes-collection','SiswaController@tesCollection');*/