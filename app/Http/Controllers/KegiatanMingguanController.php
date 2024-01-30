<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\BerkasPendukung;
use App\Models\KegiatanHarian;
use App\Models\Pelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class KegiatanMingguanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {

            $kategori_mingguan = '2';

            $data_absen = Absensi::join('kegiatan_harian', 'kegiatan_harian.absensi_id', '=', 'absensi.id')
                ->join('users', 'users.id', '=', 'absensi.user_id')
                ->join('kegiatan', 'kegiatan.id', '=', 'kegiatan_harian.jenis_kegiatan_id')
                ->join('kategori_kegiatan', 'kategori_kegiatan.id', '=', 'kegiatan_harian.kategori_kegiatan_id')
                ->where('users.nik', Auth::user()->nik)
                ->where('kegiatan_harian.tipe', $kategori_mingguan)
                ->orderBy('tanggal', 'desc')
                ->select('kegiatan_harian.*', 'absensi.tanggal', 'users.name', 'kegiatan.jenis_kegiatan', 'kategori_kegiatan.kategori_kegiatan');

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $data_absen = $data_absen->whereBetween('tanggal', [$request->from_date, $request->to_date]);
            }

            return DataTables::of($data_absen)
                ->addIndexColumn()
                ->addColumn('aksi', function ($data) {
                    return view('kegiatan-mingguan._aksi', [
                        'data' => $data,
                        'url_detail_kegiatan' => route('show.kegiatanMingguan', $data->id),
                    ]);
                })
                ->filter(function ($instance) use ($request) {
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
        return view('kegiatan-mingguan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        //
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $datas = array();
        $tipe = '';

        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {

            $tipe = $request->tipe == '1' ? NULL : $request->tipe;

            $datas = KegiatanHarian::with('dataPendukung')->join('absensi', 'absensi.id', '=', 'kegiatan_harian.absensi_id')
                ->where('tipe', $tipe)
                ->where('status_duplikat', null)
                ->where('absensi.user_id', Auth::user()->id)
                ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                ->select('kegiatan_harian.*', 'absensi.tanggal')
                ->get();

            return view('kegiatan-mingguan.create', compact('datas', 'tgl_awal', 'tgl_akhir', 'tipe'));
        }

        return view('kegiatan-mingguan.create', compact('datas', 'tgl_awal', 'tgl_akhir', 'tipe'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $kategori_mingguan = '2';

        $data = Absensi::join('kegiatan_harian', 'kegiatan_harian.absensi_id', '=', 'absensi.id')
            ->join('users', 'users.id', '=', 'absensi.user_id')
            ->join('kegiatan', 'kegiatan.id', '=', 'kegiatan_harian.jenis_kegiatan_id')
            ->join('kategori_kegiatan', 'kategori_kegiatan.id', '=', 'kegiatan_harian.kategori_kegiatan_id')
            ->where('users.nik', Auth::user()->nik)
            ->where('kegiatan_harian.tipe', $kategori_mingguan)
            ->where('kegiatan_harian.id', $id)
            ->orderBy('tanggal', 'asc')
            ->select('kegiatan_harian.*', 'absensi.tanggal', 'users.name', 'users.nik', 'kegiatan.jenis_kegiatan', 'kategori_kegiatan.kategori_kegiatan')->first();

        $lampiran = BerkasPendukung::where('kegiatan_harian_id', $data->id)->get();

        return view('kegiatan-mingguan.show', compact('data', 'lampiran'));
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
        try {
            DB::beginTransaction();

            $kegiatan = $request->kegiatan;

            $file = $request->file('lampiran');

            if ($file) {
                $nama_file = Auth::user()->name . ' (' . strtoupper($kegiatan) . ') ' . ' - ' . $file->getClientOriginalName();

                $path = public_path('/data-pendukung/' . Auth::user()->nik . '/' . strtoupper($kegiatan) . '/');

                if (file_exists($path . $nama_file)) {
                    unlink($path . $nama_file);
                }

                $file->move($path, $nama_file);

                BerkasPendukung::create([
                    'kegiatan_harian_id' => $id,
                    'nama_file' => $nama_file,
                ]);
            }

            $total_kuantitas = KegiatanHarian::where('kegiatan', $request->kegiatan)->where('nik', Auth::user()->nik)->where('status_duplikat', NULL)->sum('kuantitas');

            $data_kegiatan =  KegiatanHarian::where('kegiatan', $request->kegiatan)->where('nik', Auth::user()->nik)->get();

            KegiatanHarian::where('kegiatan', $request->kegiatan)->where('nik', Auth::user()->nik)->where('id', '!=', $id)->update([
                'status_duplikat' => '1'
            ]);

            foreach ($data_kegiatan as $row) {
                Pelayanan::where('kegiatan_harian_id', $row->id)->update([
                    'kegiatan_mingguan_id' => $id,
                ]);
            }

            $data = [
                'kegiatan' => strtoupper($request->kegiatan),
                'uraian_kegiatan' => $request->uraian_kegiatan,
                'kendala' => $request->kendala,
                'persen' => $request->persen,
                'tipe' => '2',
                'kuantitas' => $total_kuantitas == '0' ? $request->kuantitas : '0',
            ];

            KegiatanHarian::where('id', $id)->update($data);

            DB::commit();
            return back()->with('success', 'Kegiatan harian telah diperbarui menjadi mingguan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat pengolahan data');
        }
    }

    public function cetakPdf($tgl_awal, $tgl_akhir, $tipe)
    {
        $datas_final = array();
        $data_kegiatan_wo_pel = array();
        $data_pelayanan = array();

        $datas = KegiatanHarian::with('dataPendukung')
            ->join('absensi', 'absensi.id', '=', 'kegiatan_harian.absensi_id')
            ->where('tipe', $tipe)
            ->where('status_duplikat', null)
            ->where('absensi.user_id', Auth::user()->id)
            ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
            ->select('kegiatan_harian.*', 'absensi.tanggal')
            ->orderBy('kegiatan_harian.id', 'asc')
            ->get()
            ->groupBy(function ($data) {
                return $data->jenis_kegiatan_id;
            });

        foreach ($datas as $data) {

            foreach ($data as $val) {

                $pelayanan = Pelayanan::select('kategori_pelayanan_id', DB::raw('count(*) as total'))
                    ->where('kegiatan_mingguan_id', $val->id)
                    ->groupBy('kategori_pelayanan_id')
                    ->pluck('total', 'kategori_pelayanan_id')
                    ->toArray();

                foreach ($pelayanan as $key => $pel) {

                    $data_pelayanan[] = [
                        'id_pelayanan' => $val->id,
                        'kategori_pelayanan' => getNamaKategoriPelayanan($key),
                        'total_pelayanan' => $pel
                    ];
                }

                if (count($pelayanan) == 0) {
                    $data_kegiatan_wo_pel[] = [
                        'id' => $val->id,
                        'nik' => $val->nik,
                        'jenis_kegiatan_id' => $val->jenis_kegiatan_id,
                        'kegiatan' => $val->kegiatan,
                        'uraian_kegiatan' => $val->uraian_kegiatan,
                        'kendala' => $val->kendala,
                        'persen' => $val->persen,
                        'kuantitas' => $val->kuantitas,
                        'data_pelayanan' => [],
                        'data_pendukung' => $val->dataPendukung,
                    ];
                    $id = $val->id;
                }
            }
        }

        $id = null;

        foreach ($data_pelayanan as $row) {

            foreach ($datas as $data) {

                foreach ($data as $val) {

                    if ($val->id == $row['id_pelayanan']) {

                        if ($id != $val->id) {

                            $datas_final[] = [
                                'id' => $val->id,
                                'nik' => $val->nik,
                                'jenis_kegiatan_id' => $val->jenis_kegiatan_id,
                                'kegiatan' => $val->kegiatan,
                                'uraian_kegiatan' => $val->uraian_kegiatan,
                                'kendala' => $val->kendala,
                                'persen' => $val->persen,
                                'kuantitas' => $val->kuantitas,
                                'data_pelayanan' => $val->id == $row['id_pelayanan'] ? $data_pelayanan : [],
                                'data_pendukung' => $val->dataPendukung,
                            ];
                            $id = $val->id;
                        }
                    }
                }
            }
        }

        $datas_final = array_merge($datas_final, $data_kegiatan_wo_pel);
        $res = array();

        foreach ($datas_final as $element) {
            $res[$element['jenis_kegiatan_id']][] = $element;
        }

        $pdf = PDF::loadview('laporan-bulanan', ['datas' => $res]);
        return $pdf->stream();
    }

    public function laporan(Request $request)
    {
        //
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $datas = array();
        $LAPORAN_MINGGUAN = '2';

        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {

            $datas = KegiatanHarian::with('dataPendukung')->join('absensi', 'absensi.id', '=', 'kegiatan_harian.absensi_id')
                ->where('tipe', $LAPORAN_MINGGUAN)
                ->where('status_duplikat', null)
                ->where('absensi.user_id', Auth::user()->id)
                ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                ->select('kegiatan_harian.*', 'absensi.tanggal')
                ->paginate(10);

            return view('laporan.index', compact('datas', 'tgl_awal', 'tgl_akhir', 'LAPORAN_MINGGUAN'));
        }

        return view('laporan.index', compact('datas', 'tgl_awal', 'tgl_akhir', 'LAPORAN_MINGGUAN'));
    }

    public function updateDuplikat($id)
    {
        KegiatanHarian::where('id', $id)->update([
            'status_duplikat' => '1',
        ]);

        return back()->with('success', 'Kegiatan harian berhasil dihapus dari kegiatan mingguan');
    }

    public function updateHapusDuplikat($id)
    {
        KegiatanHarian::where('id', $id)->update([
            'tipe' => NULL,
            'status_duplikat' => NULL,
        ]);

        return back()->with('success', 'Kegiatan harian berhasil dihapus dari kegiatan mingguan');
    }
}
