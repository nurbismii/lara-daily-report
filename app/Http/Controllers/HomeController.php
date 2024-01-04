<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\KategoriKegiatan;
use App\Models\KegiatanHarian;
use App\Models\Pelayanan;
use App\Models\Tim;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jumlah_kegiatan_harian = KegiatanHarian::count();
        $jumlah_tim = Tim::count();
        $jumlah_pengguna = User::count();

        $kegiatan_harian = KegiatanHarian::select('id', 'jenis_kegiatan_id', 'kategori_kegiatan_id')->get();

        $kategori_kegiatan_terpopuler = getJenisKegiatanTerpopuler($kegiatan_harian);

        $total_jenis_kegiatan = totalJenisKegiatan($kategori_kegiatan_terpopuler);
        $daftar_nama_jenis_kegiatan = daftarNamaJenisKegiatan($kategori_kegiatan_terpopuler);

        $kategori_kegiatan_terpopuler = getKegiatanTerpopuler($kegiatan_harian);

        $total_kegiatan_harian = totalKegiatanHarian($kategori_kegiatan_terpopuler);
        $daftar_kegiatan_harian = daftarNamaKategoriKegiatan($kategori_kegiatan_terpopuler);

        $pelayanan = Pelayanan::with('MasterPelayanan', 'MasterKategoriPelayanan', 'MasterSubKategoriPelayanan')->orderBy('tanggal', 'desc')->limit(7)->get();

        return view('home', compact('pelayanan', 'jumlah_kegiatan_harian', 'jumlah_tim', 'jumlah_pengguna', 'kegiatan_harian', 'total_kegiatan_harian', 'daftar_kegiatan_harian', 'total_jenis_kegiatan', 'daftar_nama_jenis_kegiatan'));
    }
}
