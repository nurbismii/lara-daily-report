<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $jenis_kegiatan = Kegiatan::all();
        return view('pengaturan.kegiatan.index', compact('jenis_kegiatan'))->with('no');
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
        Kegiatan::create([
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'keterangan' => $request->keterangan
        ]);
        return back()->with('success', 'Jenis kegiatan berhasil ditambahkan');
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
        Kegiatan::where('id', $id)->update([
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'keterangan' => $request->keterangan
        ]);
        return back()->with('success', 'Jenis kegiatan berhasil diperbarui');
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
        Kegiatan::where('id', $id)->delete();
        return back()->with('success', 'Jenis kegiatan berhasil dihapus');
    }
}
