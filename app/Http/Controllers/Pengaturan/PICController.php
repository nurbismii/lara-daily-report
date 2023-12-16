<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\PIC;
use Illuminate\Http\Request;

class PICController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pic = PIC::all();
        return view('pengaturan.person-in-charge.index', compact('pic'))->with('no');
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
        PIC::create([
            'pic' => $request->pic,
            'keterangan' => $request->keterangan,
        ]);
        return back()->with('success', 'Person in charge berhasil ditambahkan');
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
        PIC::where('id', $id)->update([
            'pic' => $request->pic,
            'keterangan' => $request->keterangan,
        ]);
        return back()->with('success', 'Person in charge berhasil diperbarui');
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
        PIC::where('id', $id)->delete();
        return back()->with('success', 'Person in charge berhasil dihapus');
    }
}
