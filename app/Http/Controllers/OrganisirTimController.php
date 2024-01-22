<?php

namespace App\Http\Controllers;

use App\Models\AnggotaTim;
use App\Models\Tim;
use App\Models\User;
use Illuminate\Http\Request;

class OrganisirTimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $organisir_tim = Tim::with('anggotaTim', 'getKetua', 'getSpv')->get();
        $asmen = User::where('jabatan', 'ASMEN')->first();
        $spv = User::where('jabatan', 'SPV')->get();
        $staff = User::where('jabatan', 'STAFF')->get();
        return view('organisir-tim.index', compact('organisir_tim', 'asmen', 'spv', 'staff'));
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
        $data = Tim::create([
            'nama_tim' => $request->nama_tim,
            'ketua_tim_id' => $request->ketua_tim_id,
            'supervisor_id' => $request->supervisor_id
        ]);

        User::where('id', $data->supervisor_id)->update([
            'tim_id' => $data->id
        ]);

        return back()->with('success', 'Tim baru telah berhasil dibentuk, silahkan kelola lebih lanjut di menu aksi');
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
        if ($request->tipe == 'asisten') {
            Tim::where('id', $id)->update([
                'ketua_tim_id' => $request->ketua_tim_id
            ]);
            return back()->with('success', 'Asisten manager berhasil diperbarui');
        }
        Tim::where('id', $id)->update([
            'supervisor_id' => $request->supervisor_id
        ]);
        return back()->with('success', 'Supervisor berhasil diperbarui');
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
        Tim::where('id', $id)->delete();
        AnggotaTim::where('tim_id', $id)->delete();
        return back()->with('success', 'Tim berhasil dihapus');
    }

    public function tambahAnggotaTim(Request $request)
    {
        $cek_anggota = AnggotaTim::where('tim_id', $request->tim_id)->where('user_id', $request->user_id)->first();

        if ($cek_anggota) {
            return back()->with('warning', 'Opss, anggota sudah terdaftar di tim ini, silahkan pilih yang lain');
        }

        $data = AnggotaTim::create([
            'tim_id' => $request->tim_id,
            'user_id' => $request->user_id,
        ]);

        User::where('id', $data->user_id)->update([
            'tim_id' => $data->tim_id
        ]);

        return back()->with('success', 'Yeai, anggota tim berhasil ditambahkan');
    }

    public function updateAnggotaTim(Request $request, $id)
    {
        $anggota = AnggotaTim::where('id', $id)->first();

        $tim = Tim::where('id', $anggota->tim_id)->first();

        if ($tim) {
            if ($tim->ketua_tim_id == $request->user_id || $tim->supervisor_id == $request->user_id) {
                return back()->with('warning', 'Opss, pengguna telah terdaftar sebagai Asmen atau SPV');
            }
        }

        if ($anggota) {
            return back()->with('warning', 'Ops! anggota ini sudah terdaftar, silahkan pilih anggota lain');
        }

        $anggota->update([
            'user_id' => $request->user_id,
        ]);

        User::where('id', $request->user_id)->update([
            'tim_id' => $anggota->tim_id
        ]);

        return back()->with('success', 'Yeai, anggota tim berhasil ditambahkan');
    }

    public function destroyAnggotaTim($id)
    {
        AnggotaTim::where('id', $id)->delete();
        return back()->with('success', 'Yeai, anggota tim berhasil dihapus');
    }
}
