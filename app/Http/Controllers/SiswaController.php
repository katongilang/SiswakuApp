<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa; // Memanggil model Siswa
use App\Telepon; // Memanggil model Telepon
use App\Kelas; // Memanggil model Kelas
use App\Hobi; // Memanggil model Hobi

class SiswaController extends Controller
{

    /*
    | -------------------------------------------------------------------------------------------------------
    | INDEX
    | -------------------------------------------------------------------------------------------------------
    */
    public function index(){
        
        // Tampilkan Semua -> Regular Pagination
        $siswa_list = Siswa::orderBy('id','asc')->paginate(5); 

		//$siswa_list=Siswa::all()->sortBy('nama_siswa'); //menampilkan semua -> sorting berdasarkan nama ASC
		//sortByDesc,sortBy,orderBy
		$siswa_total=Siswa::count();
		return view('siswa/index',compact('siswa_list','siswa_total'));
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | CREATE & STORE
    | -------------------------------------------------------------------------------------------------------
    */
    public function create(){
        //Pluck = untuk menadapatkan array yang berisi nama_kelas dan id
        $list_kelas = Kelas::pluck('nama_kelas','id');//nama_kelas dulu, baru id 
        $list_hobi = Hobi::pluck('nama_hobi','id');
    	return view('siswa/create', compact('list_kelas','list_hobi'));
    }

    //proses untuk menyimpan hasil create
    public function store(Request $request){
        //$siswa = $request -> all(); // create json
        $input = $request->all(); //menerima semua input dari form
        $this->validate($request, [
            'nisn' => 'required|string|size:4|unique:siswa,nisn',
            'nama_siswa' => 'required|string|max:30',
            'tanggal_lahir' => 'required|date',
            'nomor_telepon' => 'sometimes|nullable|numeric|digits_between:10,15|unique:telepon,nomor_telepon',
            'jenis_kelamin' => 'required|in:L,P',
            'id_kelas'  => 'required'
        ]);

        // Insert tabel siswa
        $siswa = Siswa::create($input); 

        // Insert tabel telepon
        $telepon = new Telepon;
        $telepon->nomor_telepon = $request->input('nomor_telepon');
        $siswa->telepon()-> save($telepon); //minyimpan pada tabel telepon

        // Insert tabel hobi_siswa
        $siswa->hobi()->attach($request->input('hobi_siswa'));

        return redirect('siswa');
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | SHOW DETAIL
    | -------------------------------------------------------------------------------------------------------
    */
    public function show($id){
    	$siswa=Siswa::findOrFail($id); //method Eloquent untuk mendapatkan data berupa id
    	return view('siswa/show', compact('siswa'));
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | EDIT & UPDATE
    | -------------------------------------------------------------------------------------------------------
    */
    public function edit($id){
    	$siswa = Siswa::findOrFail($id); 
        $list_kelas = Kelas::pluck('nama_kelas', 'id');
        $list_hobi = Hobi::pluck('nama_hobi', 'id');

        if (!empty($siswa->telepon->nomor_telepon)) {
            $siswa->nomor_telepon = $siswa->telepon->nomor_telepon;
        }

    	return view('siswa/edit', compact('siswa','list_kelas','list_hobi'));
    }

    public function update($id, Request $request){
    	$siswa = Siswa::findOrFail($id);
        $input = $request->all();

        $this->validate($request,[
            'nisn' => 'required|string|size:4|unique:siswa,nisn,'.$request->input('id'),
            'nama_siswa' => 'required|string|max:30',
            'tanggal_lahir' => 'required|date',
            'nomor_telepon' => 'sometimes|nullable|numeric|digits_between:10,15|unique:telepon,nomor_telepon,'
            .$request->input('id').',id_siswa',
            'jenis_kelamin' => 'required|in:L,P',
            'id_kelas' => 'required'
        ]);

    	$siswa -> update($request->all());

        //Update nomor telepon, jika sebelumnya sudah ada no. telp
        if ($siswa->telepon) {
            //jika telp diisi, lalu update
            if (request()->filled('nomor_telepon')) {
                $telepon = $siswa->telepon;
                $telepon->nomor_telepon = $request->input('nomor_telepon');
                $siswa->telepon()->save($telepon);
                # code...
            }
            //jika telepon tidak diisi, lalu dihapus
            else
                $siswa->telepon()->delete();
        }
        //buat entry baru, jika sebelumnya tidak ada no telp
        else{
            if ($request->filled('nomor_telepon')) {
                $telepon= new Telepon;
                $telepon->nomor_telepon = $request->input('nomor_telepon');
                $siswa->telepon()->save($telepon);
            }
        }

        $siswa->hobi()->sync($request->input('hobi_siswa'));

    	return redirect('siswa');
    }



    /*
    | -------------------------------------------------------------------------------------------------------
    | DESTROY
    | -------------------------------------------------------------------------------------------------------
    */
    
    public function destroy($id){
    	$siswa = Siswa::findOrFail($id);
    	$siswa -> delete();
    	return redirect('siswa');
    }

    /*public function dateMutator(){
        $siswa = Siswa::findOrFail(1);
        $nama = $siswa->nama_siswa;
        $tanggal_lahir = $siswa->tanggal_lahir->format('d-m-Y');
        $ulang_tahun = $siswa->tanggal_lahir->addYears(30)->format('d-m-Y'); 
        return "Siswa {$nama} lahir tanggal {$tanggal_lahir}.<br> Ulang tahun ke-30 akan jatuh pada {$ulang_tahun}.";
    }*/



    //===================== Latihan Collection =====================
    
    //Macam-macam perintah collection = all,map,ucwords,first,last,count,take(berapa),pluck('namatabel'),whereIn, select, toArray,toJson,dll

    /*public function tesCollection(){
        $collection = Siswa::all();
        $collection = $collection->whereIn('nisn',['1001','1003']);
        return $collection;
    }*/

    /*public function tesCollection(){
        $collection = Siswa::select('nisn','nama_siswa')->take(3)->get();
        $collection = $collection->toArray();
        foreach ($collection as $siswa) {
            echo $siswa['nisn'].'-'.$siswa['nama_siswa'].'<br>';
        }
        return $collection;
    }*/

    /*
    //array to Json
    public function tesCollection(){
        $data = [
            ['nisn'=>'1001', 'nama_siswa' => 'Agus Yulianto'],
            ['nisn'=>'1002', 'nama_siswa' => 'Agus Yulianto'],
            ['nisn'=>'1003', 'nama_siswa' => 'Agus Yulianto']
        ];
        $collection = collect($data);
        $collection->toJson();
        return $collection;
    }*/
}
