<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Request; //panggil facade class Request

class SiswakuAppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    //fungsi baru ditambahkan untuk menu di navbar
    public function boot(){
        $halaman='';        
        if (Request::segment(1) == 'siswa') {
            $halaman='siswa';
        }
        if (Request::segment(1) == 'about') {
            $halaman='about';
        }
        view()->share('halaman',$halaman);
    }
}
