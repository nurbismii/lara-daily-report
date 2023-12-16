<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\BerkasPendukung;
use App\Models\KategoriKegiatan;
use App\Models\Kegiatan;
use App\Models\KegiatanHarian;
use App\Models\PenilaianKerja;
use App\Models\PIC;
use App\Models\Tim;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KegiatanHarianController extends Controller
{
    public function index(Request $request)
    {
        $data_spv = [];
        $data_tim = [];
        $data_absensi = [];

        $jabatan = Auth::user()->jabatan;

        if ($jabatan == 'ASMEN') {
            $data_tim = Tim::with('getKetua', 'getSpv', 'anggotaTim')->where('ketua_tim_id', Auth::user()->id)->get();
        }

        if ($jabatan == 'SPV') {
            $data_tim = Tim::with('getKetua', 'getSpv', 'anggotaTim')->where('supervisor_id', Auth::user()->id)->get();
        }

        foreach ($data_tim as $tim) {

            $datas = Absensi::all();

            if ($jabatan == 'ASMEN') {

                foreach ($datas as $row) {

                    $data_spv[] = User::join('absensi', 'absensi.user_id', '=', 'users.id')
                        ->where('absensi.id', $row->id)->where('absensi.user_id', $tim->supervisor_id)
                        ->select('users.name', 'users.nik', 'absensi.*')->first();
                }
            }

            foreach ($tim->anggotaTim as $row) {

                foreach ($datas as $val) {

                    $data_absensi[] = User::join('absensi', 'absensi.user_id', '=', 'users.id')
                        ->where('absensi.id', $val->id)->where('absensi.user_id', $row->user_id)
                        ->select('users.name', 'users.nik', 'absensi.*')->first();
                }

                $merge = array_merge($data_spv, $data_absensi);

                $data = array_values(array_filter($merge));

                if ($request->ajax()) {

                    $data = collect($data);

                    if ($request->filled('from_date') && $request->filled('to_date')) {
                        $data = $data->whereBetween('tanggal', [$request->from_date, $request->to_date]);
                    }

                    return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('aksi', function ($data) {
                            return view('kegiatan-harian._aksi', [
                                'data' => $data,
                                'url_detil_kegiatan' => route('kegiatan-harian.show', $data->id),
                                'url_hapus' => route('delete.absensi-kegiatan-delete', $data->id)
                            ]);
                        })->filter(function ($instance) use ($request) {
                            if (!empty($request->get('search'))) {
                                $instance->where(function ($w) use ($request) {
                                    $search = $request->get('search');
                                    $w->where('name', 'LIKE', "%$search%");
                                });
                            }
                        })
                        ->rawColumns(['aksi'])
                        ->make(true);
                }
            }
        }
        return view('kegiatan-harian.index');
    }

    public function create()
    {
        $jenis_kegiatan = Kegiatan::all();
        $kategori_kegiatan = KategoriKegiatan::all();
        $pic = PIC::all();
        $data_kegiatan = Absensi::with('kegiatanHarian')
            ->join('users', 'users.id', '=', 'absensi.user_id')
            ->where('users.nik', Auth::user()->nik)->orderBy('tanggal', 'desc')
            ->select('absensi.*')
            ->paginate(10);

        return view('kegiatan-harian.create', compact('data_kegiatan', 'jenis_kegiatan', 'kategori_kegiatan', 'pic'))->with('no');
    }

    public function createKegiatan()
    {
        $jenis_kegiatan = Kegiatan::all();
        $kategori_kegiatan = KategoriKegiatan::all();
        $pic = PIC::all();
        return view('kegiatan-harian.staff', compact('jenis_kegiatan', 'kategori_kegiatan', 'pic'));
    }

    public function show($id)
    {
        $data = Absensi::with('getAnggota')->where('id', $id)->first();

        $data_penilaian = PenilaianKerja::where('absensi_id', $id)->get();

        $data_kegiatan = KegiatanHarian::where('absensi_id', $data->id)->paginate(10);

        return view('kegiatan-harian.show', compact('data', 'data_kegiatan', 'data_penilaian'))->with('no');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if (Auth::user()->jabatan == 'SPV') {
                $status_spv = 'Diterima';
            }

            $data_absensi = Absensi::create([
                'user_id' => Auth::user()->id,
                'tanggal' => $request->tanggal,
                'jam_masuk' => $request->jam_masuk_kerja,
                'jam_istirahat' => $request->jam_istirahat,
                'jam_kembali_istirahat' => $request->jam_kembali_istirahat,
                'jam_pulang' => $request->jam_pulang_kerja,
                'status_spv' => $status_spv ?? '',
            ]);

            $kegiatan = $request['kegiatan'];
            $jenis_kegiatan_id = $request['jenis_kegiatan_id'];
            $kategori_kegiatan_id = $request['kategori_kegiatan_id'];
            $pic_id = $request['pic_id'];
            $kendala = $request['kendala'];
            $mulai = $request['mulai'];
            $selesai = $request['selesai'];
            $status_kegiatan = $request['status_kegiatan'];
            $deadline = $request['deadline'];
            $status_akhir = $request['status_akhir'];
            $kuantitas = $request['kuantitas'];

            $jumlah_kegiatan = count($kegiatan);

            for ($i = 0; $i < $jumlah_kegiatan; $i++) {

                $data_kegiatan_harian[] = [
                    'absensi_id' => $data_absensi->id,
                    'kegiatan' => $kegiatan[$i],
                    'jenis_kegiatan_id' => $jenis_kegiatan_id[$i],
                    'kategori_kegiatan_id' => $kategori_kegiatan_id[$i],
                    'pic_id' => $pic_id[$i],
                    'kendala' => $kendala[$i],
                    'mulai' => $mulai[$i],
                    'selesai' => $selesai[$i],
                    'status_kegiatan' => $status_kegiatan[$i],
                    'deadline' => $deadline[$i],
                    'status_akhir' => $status_akhir[$i],
                    'kuantitas' => $kuantitas[$i],
                ];
            }
            KegiatanHarian::insert($data_kegiatan_harian);
            DB::commit();

            return back()->with('success', 'Yuhuuu, Kegiatan harian berhasil ditambahkan');
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
        KegiatanHarian::where('absensi_id', $data->id)->delete();
        $data->delete();
        return back()->with('success', 'Oh yeah, Kehadiran & kegiatan harian berhasil dihapus');
    }

    public function storeTambahKegiatan(Request $request, $id)
    {
        KegiatanHarian::create([
            'absensi_id' => $id,
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
        return back()->with('success', 'Yuhuuu, Kegiatan harian baru berhasil ditambahkan');
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

        $path = public_path('/data-pendukung/' . Auth::user()->nik . $jenis_kegiatan . '/');

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
}
