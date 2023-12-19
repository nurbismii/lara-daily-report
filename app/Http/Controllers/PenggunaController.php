<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pengguna = User::orderBy('nik', 'asc')->where('nik', '>', '15000000')->paginate(10);
        return view('pengguna.index', compact('pengguna'))->with('no');
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
        if ($request->kata_sandi == $request->konfirmasi_sandi) {
            User::create([
                'nik' => $request->nik,
                'name' => strtoupper($request->name),
                'email' => $request->email,
                'jabatan' => $request->jabatan,
                'posisi' => $request->posisi,
                'password' => bcrypt($request->kata_sandi),
            ]);
            return back()->with('success', 'Pengguna berhasil ditambahkan');
        }
        return back()->with('error', 'Konfirmasi kata sandi tidak sesuai dengan kata sandi');
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
        if ($request->kata_sandi == '') {
            User::where('id', $id)->update([
                'nik' => $request->nik,
                'name' => strtoupper($request->name),
                'email' => $request->email,
                'jabatan' => $request->jabatan,
                'posisi' => $request->posisi,
            ]);
            return back()->with('success', 'Pengguna berhasil diperbarui');
        }
        if ($request->kata_sandi != '') {
            if ($request->kata_sandi == $request->konfirmasi_sandi) {
                User::where('id', $id)->update([
                    'nik' => $request->nik,
                    'name' => strtoupper($request->name),
                    'email' => $request->email,
                    'jabatan' => $request->jabatan,
                    'posisi' => $request->posisi,
                    'password' => bcrypt($request->kata_sandi),
                ]);
                return back()->with('success', 'Pengguna berhasil diperbarui');
            }
            return back()->with('error', 'Konfirmasi kata sandi tidak sesuai dengan kata sandi');
        }
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
        User::where('id', $id)->delete();
        return back()->with('success', 'Pengguna berhasil dihapus');
    }

    public function profile()
    {
        $data = User::find(Auth::user()->id);
        return view('pengguna.profil', compact('data'));
    }

    public function fotoProfil(Request $request)
    {
        $data = User::where('id', Auth::user()->id)->first();

        $file = $request->file('foto');

        $nama_file = $file->getClientOriginalName();

        $path = public_path('/foto-profil/' . Auth::user()->nik . '/');

        if (file_exists($path . $data->foto)) {
            unlink($path . $data->foto);
        }

        $file->move($path, $nama_file);

        User::where('id', Auth::user()->id)->update([
            'foto' => $nama_file
        ]);

        return back()->with('success', 'Foto berhasil diperbarui');
    }
}
