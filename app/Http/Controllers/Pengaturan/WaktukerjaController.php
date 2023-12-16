<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\KategoriWaktuKerja;
use App\Models\WaktuKerja;
use Illuminate\Http\Request;

class WaktukerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $kategori_waktu_kerja = KategoriWaktuKerja::all();
        $waktu_kerja = WaktuKerja::with('kategori_waktu_kerja')->get();
        return view('pengaturan.waktu-kerja.index', compact('kategori_waktu_kerja', 'waktu_kerja'))->with('no');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengaturan.waktu-kerja.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createKategoriWaktuKerja($id)
    {
        $data = WaktuKerja::where('id', $id)->first();
        return view('pengaturan.waktu-kerja.kategori.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        WaktuKerja::create([
            'waktu_kerja' => $request->waktu_kerja,
        ]);
        return back()->with('success', 'Data kategori waktu kerja berhasil ditambahkan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeKategoriWaktuKerja(Request $request)
    {
        //
        KategoriWaktuKerja::create([
            'waktu_kerja_id' => $request->waktu_kerja_id,
            'kategori_waktu_kerja' => $request->kategori_waktu_kerja
        ]);
        return back()->with('success', 'Data kategori waktu kerja berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = WaktuKerja::with('kategori_waktu_kerja')->where('id', $id)->first();
        return view('pengaturan.waktu-kerja.edit', compact('data'))->with('no');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        WaktuKerja::where('id', $id)->update([
            'waktu_kerja' => $request->waktu_kerja
        ]);
        return back()->with('success', 'Data kategori waktu kerja berhasil diperbarui');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateKategoriWaktuKerja(Request $request, $id)
    {
        //

        KategoriWaktuKerja::where('id', $id)->update([
            'kategori_waktu_kerja' => $request->kategori_waktu_kerja
        ]);

        return back()->with('success', 'Data kategori waktu kerja berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = WaktuKerja::where('id', $id)->first();
        $data->delete();
        return back()->with('success', 'Berhasil menghapus kategori waktu kerja');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyKategoriWaktuKerja($id)
    {
        //
        $data = KategoriWaktuKerja::where('id', $id)->first();
        $data->delete();
        return back()->with('success', 'Berhasil menghapus kategori waktu kerja');
    }
}
