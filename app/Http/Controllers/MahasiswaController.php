<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use App\Models\MahasiswaMatakuliah;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                //fungsi eloquent menampilkan data menggunakan pagination
        // $mahasiswas = Mahasiswa::all(); // Mengambil semua isi tabel
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('Nim', 'asc')->paginate(5);
        // $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(6);
        // dd($mahasiswas);
        return view('mahasiswas.index', [
            'mahasiswa' => $mahasiswa,
            'paginate' => $paginate
        ]);
        // with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswas.create',[
            'kelas' => $kelas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            //melakukan validasi data
            $request->validate([
                'Nim' => 'required',
                'Nama' => 'required',
                'Kelas' => 'required',
                'Jurusan' => 'required',
                'No_Handphone' => 'required',
            ]);

            $mahasiswa = new Mahasiswa;
            $mahasiswa->nim = $request->get('Nim');
            $mahasiswa->nama = $request->get('Nama');
            if($request->file('image')){
                $image_name = $request->file('foto')->store('images', 'public');
            }
            $mahasiswa->foto = $image_name;
            $mahasiswa->jurusan = $request->get('Jurusan');
            $mahasiswa->no_handphone = $request->get('No_Handphone');
            $mahasiswa->save();

            $kelas = new Kelas;
            $kelas->id = $request->get('Kelas');

            // fungsi eloquent untuk menambah data dengan relasi belongsTo
            $mahasiswa->kelas()->associate($kelas);
            $mahasiswa->save();

            //fungsi eloquent untuk menambah data
            // Mahasiswa::create($request->all());

            //jika data berhasil ditambahkan, akan kembali ke halaman utama
            return redirect()->route('mahasiswas.index')
                ->with('success', 'Mahasiswa Berhasil Ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        return view('mahasiswas.detail', compact('Mahasiswa'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('Mahasiswa', 'kelas'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
        ]);
        $mahasiswa = Mahasiswa::with('kelas')->where('nim',$Nim)->first();
        // dd($mahasiswa);
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        if($mahasiswa->foto && file_exists(storage_path('app/public/'. $mahasiswa->foto))){
            Storage::delete(['public/'. $mahasiswa->foto]);
        }

        $image_name = $request->file('foto')->store('images', 'public');
        $mahasiswa->foto = $image_name;
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->no_handphone = $request->get('No_Handphone');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        // fungsi eloquent untuk menambah data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        // dd($mahasiswa);
        $mahasiswa->save();

        // dd($mahasiswa);

        //fungsi eloquent untuk mengupdate data inputan kita
        // Mahasiswa::find($Nim)->update($request->all());

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
         //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswas.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');

    }

    public function search(Request $request){
        $keyword = $request->search;
        $paginate = Mahasiswa::where('nama','like', "%" . $keyword . "%")->paginate(5);
        // $mahasiswas = DB::table('mahasiswa')->paginate(5);

        return view('mahasiswas.index', compact('paginate'));
        // return view('mahasiswas.index',['mahasiswas' => $user]);
    }

    public function nilai($Nim)
    {
        // $Mahasiswa = Mahasiswa::find($Nim);
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim',$Nim)->first();
        $MahasiswaMatakuliah = MahasiswaMatakuliah::all()->where('mahasiswa_id', $Nim)->first();
        // dd($MahasiswaMatakuliah);
        // $MahasiswaMatakuliah = MahasiswaMatakuliah::with('matakuliah')->where('mahasiswa_id', $Nim)->first();
        // $matakuliah = Matakuliah::all();
        // dd($MahasiswaMatakuliah);
        // dd($Mahasiswa);
        // $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        return view('mahasiswas.khs',[
            'Mahasiswa'=>$Mahasiswa,
            'MahasiswaMatakuliah' => $MahasiswaMatakuliah
        ]);
    }

    public function cetak_pdf($Nim){

        $Mahasiswa = Mahasiswa::with('kelas')->where('nim',$Nim)->first();
        // $pdf = PDF::loadview('articles.articles_pdf', ['articles' => $article]);
        $pdf = PDF::loadview('mahasiswas.khs_pdf', array('Mahasiswa' => $Mahasiswa));
        return $pdf->stream();
    }
}
