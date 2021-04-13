<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

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
        $mahasiswas = Mahasiswa::with('kelas')->orderBy('nim', 'desc')->paginate(5);
        return view('mahasiswa.index', compact('mahasiswas'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswa.create', compact('kelas'));
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
            'nim' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'no_handphone' => 'required',
            'photo' => 'required',
        ]);

        // Fungsi untuk mengecek apakah ada file photo yang diupload
        if($request->file('photo')) {
            $photo_name = $request->file('photo')->store('photos', 'public');
        }

        //fungsi eloquent untuk mengambil data kelas dari relation
        $kelas = Kelas::find($request->get('kelas'));

        //fungsi eloquent untuk menyimpan data mahasiswa
        $mahasiswa = new Mahasiswa();
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->nama = $request->get('nama');
        $mahasiswa->jurusan = $request->get('jurusan');
        $mahasiswa->no_handphone = $request->get('no_handphone');
        $mahasiswa->photo = $photo_name;
        $mahasiswa->kelas()->associate($kelas); // FUngsi eloquent untuk menyimpan belongTo
        $mahasiswa->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::with('kelas')->find($nim);
        return view('mahasiswa.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::with('kelas')->find($nim);
        $kelas = Kelas::all();
        return view('mahasiswa.edit', compact('Mahasiswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        //melakukan validasi data
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'no_handphone' => 'required',
        ]);
        //fungsi eloquent untuk mengambil data kelas dari relation
        $kelas = Kelas::find($request->get('kelas'));

        //fungsi eloquent untuk menyimpan data mahasiswa
        $mahasiswa = Mahasiswa::find($nim);

        // Delete old photo
        if($mahasiswa->photo && file_exists( storage_path('app/public/' . $mahasiswa->photo))){
            Storage::delete('public/' . $mahasiswa->photo);
        }

        // Fungsi untuk mengecek apakah ada file photo yang diupload
        if($request->file('photo')) {
            $photo_name = $request->file('photo')->store('photos', 'public');
        }

        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->nama = $request->get('nama');
        $mahasiswa->jurusan = $request->get('jurusan');
        $mahasiswa->no_handphone = $request->get('no_handphone');
        $mahasiswa->photo = $photo_name;
        $mahasiswa->kelas()->associate($kelas); // FUngsi eloquent untuk menyimpan belongTo
        $mahasiswa->save();
        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        $mahasiswa = Mahasiswa::find($nim);

        if($mahasiswa->photo && file_exists( storage_path('app/public/' . $mahasiswa->photo))){
            Storage::delete('public/' . $mahasiswa->photo);
        }

        //fungsi eloquent untuk menghapus data pada relasi mahasiswa_matakuliah
        $mahasiswa->matakuliah()->detach();
        //fungsi eloquent untuk menghapus data
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function search(Request $request)
    {
        $mahasiswas = Mahasiswa::where('nama', 'like', "%" . $request->keywords . "%")->paginate(5);
        $mahasiswas->appends(['keywords' => $request->keywords]);
        return view('mahasiswa.search', compact('mahasiswas'));
    }

    public function nilai($nim)
    {
        //menampilkan detail data nilai mahasiswa dengan menemukan/berdasarkan Nim Mahasiswa
        $mahasiswa = Mahasiswa::with('kelas', 'matakuliah')->find($nim);
        return view('mahasiswa.nilai', compact('mahasiswa'));
    }

    public function cetak_khs($nim){
        $mahasiswa = Mahasiswa::findOrFail($nim);

        // Fungsi untuk mencetak ke pdf dengan mnggunakan DomPDF
        $pdf= PDF::loadview('mahasiswa.cetak_khs', ['mahasiswa' => $mahasiswa]);
        return $pdf->stream();
    }
}