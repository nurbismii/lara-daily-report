<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\KategoriKegiatan;
use Illuminate\Http\Request;

class KategoriKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $kategori_kegiatan = KategoriKegiatan::all();
        return view('pengaturan.kategori-kegiatan.index', compact('kategori_kegiatan'))->with('no');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        KategoriKegiatan::create([
            'kategori_kegiatan' => $request->kategori_kegiatan,
            'keterangan' => $request->keterangan
        ]);
        return back()->with('success', 'Kategori kegiatan berhasil ditambahkan');
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
        KategoriKegiatan::where('id', $id)->update([
            'kategori_kegiatan' => $request->kategori_kegiatan,
            'keterangan' => $request->keterangan
        ]);
        return back()->with('success', 'Kategori kegiatan berhasil diperbarui');
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
        KategoriKegiatan::where('id', $id)->delete();
        return back()->with('success', 'Kategori kegiatan berhasil diperbarui');
    }
}
