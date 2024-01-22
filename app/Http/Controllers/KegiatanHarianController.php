<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\AgendaKerjaEsok;
use App\Models\BerkasPendukung;
use App\Models\KategoriKegiatan;
use App\Models\Kegiatan;
use App\Models\KegiatanHarian;
use App\Models\MasterPelayanan;
use App\Models\Pelayanan;
use App\Models\PenilaianKerja;
use App\Models\PIC;
use App\Models\Tim;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class KegiatanHarianController extends Controller
{
    public function index(Request $request)
    {
        $data_spv = [];
        $data_tim = [];
        $data_absensi = [];

        $jabatan = Auth::user()->jabatan;

        if ($jabatan == 'ASMEN') {
            $data_tim = Tim::with('getKetua', 'getSpv', 'anggotaTim')->where('ketua_tim_id', Auth::user()->id)->first();
        }

        if ($jabatan == 'SPV') {
            $data_tim = Tim::with('getKetua', 'getSpv', 'anggotaTim')->where('supervisor_id', Auth::user()->id)->first();
        }

        /* Menyimpan data anggota tim kedalam array */
        foreach ($data_tim->anggotaTim as $row) {

            $tim_id[] = $row->user_id;
        }

        $datas = Absensi::all();

        if ($jabatan == 'ASMEN') {

            foreach ($datas as $val) {

                $data_spv[] = User::leftjoin('absensi', 'absensi.user_id', '=', 'users.id')
                    ->leftjoin('tim', 'tim.id', '=', 'users.tim_id')
                    ->leftjoin('anggota_tim', 'anggota_tim.user_id', '=', 'users.id')
                    ->where('absensi.id', $val->id)
                    ->select('users.name', 'tim.nama_tim', 'users.nik', 'absensi.*')->first();
            }
        }

        if ($jabatan == 'SPV') {

            foreach ($datas as $val) {

                $data_absensi[] = User::leftjoin('absensi', 'absensi.user_id', '=', 'users.id')
                    ->leftjoin('tim', 'tim.id', '=', 'users.tim_id')
                    ->leftjoin('anggota_tim', 'anggota_tim.user_id', '=', 'users.id')
                    ->where('absensi.id', $val->id)->whereIn('absensi.user_id', $tim_id)
                    ->select('users.name', 'tim.nama_tim', 'users.nik', 'absensi.*')->first();
            }
        }

        $merge = array_merge($data_spv, $data_absensi);

        $data = array_values(array_filter($merge));

        if ($request->ajax()) {

            $data = collect($data);

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $data = $data->whereBetween('tanggal', [$request->from_date, $request->to_date]);
            }

            if ($request->nama_tim != '') {
                $data = $data->where('nama_tim', $request->nama_tim);
            }

            if (!empty($request->get('search'))) {
                $data = $data->where('name', 'LIKE', "%search%");
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($data) {
                    return view('kegiatan-harian._aksi', [
                        'data' => $data,
                        'url_detil_kegiatan' => route('kegiatan-harian.show', $data->id),
                        'url_hapus' => route('delete.absensi-kegiatan-delete', $data->id)
                    ]);
                })->rawColumns(['aksi'])
                ->make(true);
        }
        $list_tim = Tim::all();

        return view('kegiatan-harian.index', compact('list_tim'));
    }

    public function create()
    {
        $jenis_kegiatan = Kegiatan::all();
        $kategori_kegiatan = KategoriKegiatan::all();
        $pic = PIC::all();
        $pelayanan = Pelayanan::all();
        $data_kegiatan = Absensi::with(['kegiatanHarian' => function ($q) {
            $q->with('pelayanan')->orderBy('mulai', 'asc');
        }], 'agendaEsok')
            ->join('users', 'users.id', '=', 'absensi.user_id')
            ->where('users.nik', Auth::user()->nik)->orderBy('tanggal', 'desc')
            ->select('absensi.*')
            ->paginate(10);

        return view('kegiatan-harian.create', compact('pelayanan', 'data_kegiatan', 'jenis_kegiatan', 'kategori_kegiatan', 'pic'))->with('no');
    }

    public function createKegiatan()
    {
        $jenis_kegiatan = Kegiatan::all();
        $kategori_kegiatan = KategoriKegiatan::all();
        $pic = PIC::all();
        $pelayanan = MasterPelayanan::all();
        return view('kegiatan-harian.staff', compact('jenis_kegiatan', 'kategori_kegiatan', 'pic', 'pelayanan'));
    }

    public function show($id)
    {
        $data = Absensi::with('getAnggota')->where('id', $id)->first();

        $data_penilaian = PenilaianKerja::where('absensi_id', $id)->get();

        $data_kegiatan = KegiatanHarian::with('dataPendukung', 'pelayanan')->where('absensi_id', $data->id)->get();

        return view('kegiatan-harian.show', compact('data', 'data_kegiatan', 'data_penilaian'))->with('no');
    }

    public function store(Request $request)
    {
        $cek_absen = Absensi::where('user_id', Auth::user()->id)->where('tanggal', $request->tanggal)->first();

        $status_spv = NULL;

        if ($cek_absen) {
            return redirect('/kegiatan-harian/create')->with('info', 'Kamu telah absen hari ini, silahkan lanjut aktifitas di tabel kegiatan >> kolom kegiatan');
        }

        if (Auth::user()->jabatan == 'SPV') {
            $status_spv = 'Diterima';
        }

        try {
            DB::beginTransaction();

            $data_absensi = Absensi::create([
                'user_id' => Auth::user()->id,
                'tanggal' => $request->tanggal,
                'jam_masuk' => $request->jam_masuk_kerja,
                'jam_istirahat' => $request->jam_istirahat,
                'jam_kembali_istirahat' => $request->jam_kembali_istirahat,
                'jam_pulang' => $request->jam_pulang_kerja,
                'status_spv' => $status_spv != '' ? $status_spv : NULL,
            ]);

            $kegiatan_harian = KegiatanHarian::create([
                'nik' => Auth::user()->nik,
                'absensi_id' => $data_absensi->id,
                'kegiatan' => $request->kegiatan,
                'jenis_kegiatan_id' => $request->jenis_kegiatan_id,
                'kategori_kegiatan_id' => $request->kategori_kegiatan_id,
                'pic_id' => $request->pic_id,
                'kendala' => $request->kendala,
                'mulai' => $request->mulai,
                'selesai' => $request->selesai,
                'status_kegiatan' => $request->status_kegiatan,
                'deadline' => $request->deadline,
                'status_akhir' => $request->status_akhir,
                'kuantitas' => $request->kuantitas,
            ]);

            if ($request->pelayanan == '1') {
                Pelayanan::create([
                    'kegiatan__harian_id' => $kegiatan_harian->id,
                    'nik_pic' => $request->nik_pic,
                    'nama_karyawan' => $request->nama_karyawan,
                    'nik_karyawan' => $request->nik_karyawan,
                    'departemen' => $request->departemen,
                    'divisi' => $request->divisi,
                    'posisi' => $request->posisi,
                    'pelayanan_id' => $request->pelayanan_id,
                    'kategori_pelayanan_id' => $request->kategori_pelayanan_id,
                    'sub_kategori_pelayanan_id' => $request->sub_kategori_pelayanan_id,
                    'keperluan' => $request->keperluan,
                    'tanggal' => date('Y-m-d', strtotime(Carbon::now())),
                ]);
            }

            DB::commit();
            return redirect('/kegiatan-harian/create')->with('success', 'Yuhuuu, Kegiatan harian berhasil ditambahkan');
        } catch (\Throwable $e) {
            return back()->with('error', 'Opps, terjadi kesalahan sistem');
        }
    }

    public function update(Request $request, $id)
    {
        Absensi::where('id', $id)->update([
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_istirahat' => $request->jam_istirahat,
            'jam_kembali_istirahat' => $request->jam_kembali_istirahat,
            'jam_pulang' => $request->jam_pulang,
        ]);
        return back()->with('success', 'Yuhuuu, waktu absensi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Absensi::where('id', $id)->first();
        $data_kegiatan = KegiatanHarian::where('absensi_id', $data->id)->get();

        foreach ($data_kegiatan as $val) {

            $berkas = BerkasPendukung::where('kegiatan_harian_id', $val->id)->first();
            if (isset($berkas->nama_file)) {
                File::delete($berkas->nama_file);
                $berkas->delete();
            }

            $pelayanan = Pelayanan::where('kegiatan_harian_id', $val->id)->get();
            foreach ($pelayanan as $pel) {
                Pelayanan::where('id', $pel->id)->delete();
            }

            $val->delete();
        }

        $data->delete();

        return back()->with('success', 'Oh yeah, Kehadiran & kegiatan harian berhasil dihapus');
    }

    public function storeTambahKegiatan(Request $request)
    {
        try {
            DB::beginTransaction();

            KegiatanHarian::where('kegiatan', $request->kegiatan)->where('nik', Auth::user()->nik)->update([
                'status_duplikat' => '1'
            ]);

            $kegiatan_harian = KegiatanHarian::create([
                'nik' => Auth::user()->nik,
                'absensi_id' => $request->absensi_id,
                'kegiatan' => $request->kegiatan,
                'jenis_kegiatan_id' => $request->jenis_kegiatan_id,
                'kategori_kegiatan_id' => $request->kategori_kegiatan_id,
                'pic_id' => $request->pic_id,
                'kendala' => $request->kendala,
                'mulai' => $request->mulai,
                'selesai' => $request->selesai,
                'status_kegiatan' => $request->status_kegiatan,
                'deadline' => $request->deadline,
                'status_akhir' => $request->status_akhir,
                'kuantitas' => $request->kuantitas,
            ]);

            if ($request->pelayanan == '1') {

                Pelayanan::create([
                    'kegiatan_harian_id' => $kegiatan_harian->id,
                    'nik_pic' => $request->nik_pic,
                    'nama_karyawan' => $request->nama_karyawan,
                    'nik_karyawan' => $request->nik_karyawan,
                    'departemen' => $request->departemen,
                    'divisi' => $request->divisi,
                    'posisi' => $request->posisi,
                    'pelayanan_id' => $request->pelayanan_id,
                    'kategori_pelayanan_id' => $request->kategori_pelayanan_id,
                    'sub_kategori_pelayanan_id' => $request->sub_kategori_pelayanan_id,
                    'keperluan' => $request->keperluan,
                    'tanggal' => date('Y-m-d', strtotime(Carbon::now())),
                ]);
            }

            DB::commit();
            return back()->with('success', 'Yuhuuu, Kegiatan harian baru berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Opps, Terjadi kesalahan');
        }
    }

    public function updateKegiatan(Request $request, $id)
    {
        KegiatanHarian::where('id', $id)->update([
            'kegiatan' => $request->kegiatan,
            'jenis_kegiatan_id' => $request->jenis_kegiatan_id,
            'kategori_kegiatan_id' => $request->kategori_kegiatan_id,
            'pic_id' => $request->pic_id,
            'kendala' => $request->kendala,
            'mulai' => $request->mulai,
            'selesai' => $request->selesai,
            'status_kegiatan' => $request->status_kegiatan,
            'deadline' => $request->deadline,
            'status_akhir' => $request->status_akhir,
            'kuantitas' => $request->kuantitas,
        ]);
        return back()->with('success', 'Yuhuuu, Kegiatan harian berhasil diperbarui');
    }

    public function destroyKegiatan($id)
    {
        $data = KegiatanHarian::where('id', $id)->first();
        
        $data->delete();

        $berkas_pendukung = BerkasPendukung::where('kegiatan_harian_id', $id)->get();
        foreach ($berkas_pendukung as $berkas) {
            if (isset($berkas->nama_file)) {
                File::delete($berkas->nama_file);
                $berkas->delete();
            }
        }

        $pelayanan = Pelayanan::where('kegiatan_harian_id', $id)->get();
        foreach ($pelayanan as $pel) {
            Pelayanan::where('id', $pel->id)->delete();
        }



        return back()->with('success', 'Oh yeah, Kegiatan harian berhasil dihapus');
    }

    public function updateStatusKegiatan($id)
    {
        $jabatan = Auth::user()->jabatan;

        if ($jabatan == 'STAFF') {
            return back()->with('warning', 'Opss, kamu tidak memiliki akses ini');
        }

        $data = Absensi::where('id', $id)->first();

        if ($jabatan == 'ASMEN') {
            if ($data->status_spv != '') {
                $data->update([
                    'status_asmen' => 'Diterima'
                ]);
                return back()->with('success', 'Laporan kegiatan harian diterima');
            }
            return back()->with('warning', 'Opss, SPV belum menerima kegiatan harian, status laporan  tidak dapat diperbarui');
        }

        $data->update([
            'status_spv' => 'Diterima'
        ]);

        return back()->with('success', 'Supervisor menyetujui laporan kegiatan harian');
    }

    public function penilaianKerjaHarian(Request $request)
    {
        $jabatan = Auth::user()->jabatan;

        $penilaian_kerja = PenilaianKerja::where('absensi_id', $request->absensi_id)->first();

        $jenis_penilaian = $request['jenis_penilaian'];
        $nilai_spv = $request['nilai_spv'];
        $catatan_spv = $request['catatan_spv'];

        if (isset($penilaian_kerja->nilai_spv) && $jabatan == 'SPV') {
            return back()->with('warning', 'Oppss, penilaian supervisor sudah dilakukan, terima kasih');
        }

        if ($jabatan == 'ASMEN') {
            return back()->with('warning', 'Oppss, Form permintaan ini digunakan untuk supervisor');
        }

        if ($jabatan == 'SPV') {
            $jumlah_penilaian = count($jenis_penilaian);

            for ($i = 0; $i < $jumlah_penilaian; $i++) {

                $input[] = [
                    'absensi_id' => $request->absensi_id,
                    'jenis_penilaian' => $jenis_penilaian[$i],
                    'nilai_spv' => $nilai_spv[$i],
                    'catatan_spv' => $catatan_spv[$i],
                ];
            }
            PenilaianKerja::insert($input);
            return back()->with('success', 'Berhasil melakukan penilaian kerja harian');
        }
        return back()->with('warning', 'Opps!, Supervisor belum melakukan penilaian');
    }

    public function updatePenilaianKerjaHarian(Request $request)
    {
        $jabatan = Auth::user()->jabatan;

        if ($jabatan == 'SPV') {
            return back()->with('warning', 'Oopss form penilaian ini hanya bisa digunakan oleh asmen');
        }

        $penilaian_id = $request['penilaian_id'];
        $nilai_asmen = $request['nilai_asmen'];
        $catatan_asmen = $request['catatan_asmen'];

        if (!filled($request->penilaian_id)) {
            return back()->with('error', 'Penilaian belum bisa dilanjutkan!!!');
        }

        $jumlah_penilaian = count($penilaian_id);

        for ($i = 0; $i < $jumlah_penilaian; $i++) {

            PenilaianKerja::where('id', $penilaian_id[$i])->update([
                'nilai_asmen' => $nilai_asmen[$i],
                'catatan_asmen' => $catatan_asmen[$i],
            ]);
        }
        return back()->with('success', 'Berhasil melakukan penilaian kerja harian');
    }

    public function unggahBerkas(Request $request)
    {
        $jenis_kegiatan = $request->jenis_kegiatan;

        $file = $request->data_pendukung;

        $nama_file = Auth::user()->name . ' (' . strtoupper($jenis_kegiatan) . ') ' . ' - ' . $file->getClientOriginalName();

        $path = public_path('/data-pendukung/' . Auth::user()->nik . '/' . $jenis_kegiatan . '/');

        if (file_exists($path . $nama_file)) {
            unlink($path . $nama_file);
        }

        $file->move($path, $nama_file);

        BerkasPendukung::create([
            'kegiatan_harian_id' => $request->id,
            'nama_file' => $nama_file,

        ]);

        return back()->with('success', 'Berkas pendukung berhasil di unggah');
    }

    public function storeAgendaKerja(Request $request)
    {
        $kegiatan = $request['kegiatan'];
        $uraian_kegiatan = $request['uraian_kegiatan'];
        $persentase_penyelesaian = $request['persentase_penyelesaian'];

        $jumlah_kegiatan = count($kegiatan);

        for ($i = 0; $i < $jumlah_kegiatan; $i++) {
            $input[] = [
                'absensi_id' => $request->id,
                'kegiatan' => $kegiatan[$i],
                'uraian_kegiatan' => $uraian_kegiatan[$i],
                'persentase' => $persentase_penyelesaian[$i]
            ];

            AgendaKerjaEsok::insert($input);
        }

        return back()->with('success', 'Agenda kerja esok hari berhasil ditambahkan');
    }

    public function unduhBerkas($id, $nik)
    {
        $request_file = BerkasPendukung::where('id', $id)->first();

        $kegiatan = KegiatanHarian::where('id', $request_file->kegiatan_harian_id)->first();

        $request_file = public_path('/data-pendukung/' . $nik . '/' . $kegiatan->kegiatan . '/' . $request_file->nama_file);

        return response()->download($request_file);
    }

    public function showPenilaianKerja($id)
    {
        $penilaian = PenilaianKerja::where('absensi_id', $id)->get();

        $data = Absensi::with('getAnggota')->where('id', $id)->first();

        $data_penilaian = PenilaianKerja::where('absensi_id', $id)->get();

        $cek_form = $data_penilaian->where('nilai_asmen', '!=', NULL);

        if ($cek_form->count() > 0 && Auth::user()->jabatan == 'SPV') {
            return back()->with('info', 'Form penilaian telah ditutup');
        }

        return view('kegiatan-harian.penilaian-kerja', compact('penilaian', 'data', 'data_penilaian'));
    }

    public function penilaianKerjaHarianAsmen(Request $request)
    {

        $jenis_penilaian = $request['jenis_penilaian'];
        $nilai_asmen = $request['nilai_asmen'];
        $catatan_asmen = $request['catatan_asmen'];
        $jumlah_penilaian = count($jenis_penilaian);

        for ($i = 0; $i < $jumlah_penilaian; $i++) {

            $input[] = [
                'absensi_id' => $request->absensi_id,
                'jenis_penilaian' => $jenis_penilaian[$i],
                'nilai_asmen' => $nilai_asmen[$i],
                'catatan_asmen' => $catatan_asmen[$i],
            ];
        }
        PenilaianKerja::insert($input);

        return back()->with('success', 'Berhasil melakukan penilaian kerja harian');
    }

    public function tambahKegiatan(Request $request, $id)
    {
        $jenis_kegiatan = Kegiatan::all();
        $kategori_kegiatan = KategoriKegiatan::all();
        $pic = PIC::all();
        $pelayanan = MasterPelayanan::all();

        $data_absensi = Absensi::where('id', $id)->first();

        return view('kegiatan-harian.tambah-kegiatan', compact('data_absensi', 'jenis_kegiatan', 'kategori_kegiatan', 'pic', 'pelayanan'));
    }
}
