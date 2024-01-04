<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\MasterKategoriPelayanan;
use App\Models\MasterPelayanan;
use App\Models\MasterSubKategoriPelayanan;
use App\Models\Pelayanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelayananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pelayanan = MasterPelayanan::all();

        return view('pelayanan.index', compact('pelayanan'));
    }

    public function hr()
    {
        $datas = Pelayanan::with('MasterPelayanan', 'MasterKategoriPelayanan', 'MasterSubKategoriPelayanan')->orderBy('tanggal', 'desc')->paginate(10);

        return view('pelayanan.hr', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        Pelayanan::create([
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

        return back()->with('success', 'Pelayanan berhasil ditambahkan');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }

    public function cariKaryawan(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;
            $data = Karyawan::select('nik', 'nama_karyawan')->where('nik', 'like', '%' . $search . '%')->limit(100)->get();
            return response()->json($data);
        }
    }

    public function detailKaryawan($id)
    {
        $data = Karyawan::leftjoin('salaries', 'salaries.employee_id', '=', 'employees.nik')
            ->leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
            ->leftjoin('departemens', 'departemens.id', '=', 'divisis.departemen_id')
            ->leftjoin('master_provinsi', 'master_provinsi.id', '=', 'employees.provinsi_id')
            ->leftjoin('master_kabupaten', 'master_kabupaten.id', '=', 'employees.kabupaten_id')
            ->leftjoin('master_kecamatan', 'master_kecamatan.id', '=', 'employees.kecamatan_id')
            ->leftjoin('master_kelurahan', 'master_kelurahan.id', '=', 'employees.kelurahan_id')
            ->leftjoin('sp_report', 'sp_report.nik_karyawan', '=', 'employees.nik')
            ->select(DB::raw("*, TIMESTAMPDIFF(YEAR, entry_date, CURDATE()) as service_year, TIMESTAMPDIFF(MONTH, entry_date, CURDATE()) as service_month"))
            ->orderBy('salaries.akhir_periode', 'desc')
            ->where('employees.nik', $id)->first();

        return response()->json($data);
    }

    public function pelayanan()
    {
        $datas = MasterPelayanan::all();
        return view('pengaturan.pelayanan.index', compact('datas'));
    }

    public function pelayananStore(Request $request)
    {
        MasterPelayanan::create([
            'nama_layanan' => $request->nama_layanan
        ]);

        return back()->with('success', 'Yeaai, pelayanan baru berhasil ditambahkan');
    }

    public function pelayananUpdate(Request $request, $id)
    {
        MasterPelayanan::where('id', $id)->update([
            'nama_layanan' => $request->nama_layanan
        ]);

        return back()->with('success', 'Yeaai, pelayanan baru berhasil diperbarui');
    }

    public function pelayananDestroy($id)
    {
        $pelayanan = MasterPelayanan::where('id', $id)->first();

        $kategori_pelayanan = MasterKategoriPelayanan::where('master_pelayanan_id', $pelayanan->id)->get();

        foreach ($kategori_pelayanan as $row) {

            MasterSubKategoriPelayanan::where('master_kategori_pelayanan_id', $row->id)->delete();

            $row->delete();
        }

        $pelayanan->delete();

        return back()->with('success', 'Yeaai, pelayanan berhasil dihapus');
    }

    public function kategoriPelayanan()
    {
        $datas = MasterKategoriPelayanan::with('masterPelayanan', 'subKategoriPelayanan')->get();
        $pelayanan = MasterPelayanan::all();
        return view('pengaturan.pelayanan.kategori-pelayanan', compact('datas', 'pelayanan'));
    }

    public function kategoriPelayananStore(Request $request)
    {
        MasterKategoriPelayanan::create([
            'master_pelayanan_id' => $request->pelayanan_id,
            'kategori_pelayanan' => $request->kategori_pelayanan
        ]);

        return back()->with('success', 'Yeaai, kategori pelayanan baru berhasil ditambahkan');
    }

    public function kategoriPelayananUpdate(Request $request, $id)
    {
        MasterKategoriPelayanan::where('id', $id)->update([
            'kategori_pelayanan' => $request->kategori_pelayanan
        ]);

        return back()->with('success', 'Yeaai, kategori pelayanan baru berhasil diperbarui');
    }

    public function kategoriPelayananDestroy($id)
    {
        $kategori_pelayanan = MasterKategoriPelayanan::where('id', $id)->first();

        MasterSubKategoriPelayanan::where('master_kategori_pelayanan_id', $id)->delete();

        $kategori_pelayanan->delete();

        return back()->with('success', 'Yeaai, kategori pelayanan berhasil dihapus');
    }

    public function subKategoriPelayananStore(Request $request)
    {
        MasterSubKategoriPelayanan::create([
            'master_kategori_pelayanan_id' => $request->kategori_pelayanan_id,
            'sub_kategori_pelayanan' => $request->sub_kategori_pelayanan,
        ]);

        return back()->with('success', 'Yeaai, sub kategori pelayanan baru berhasil ditambahkan');
    }

    public function subKategoriPelayananUpdate(Request $request)
    {
        MasterSubKategoriPelayanan::where('id', $request->id)->update([
            'sub_kategori_pelayanan' => $request->sub_kategori_pelayanan,
        ]);

        return back()->with('success', 'Yeaai, sub kategori pelayanan baru berhasil diperbarui');
    }

    public function subKategoriPelayananDestroy($id)
    {
        MasterSubKategoriPelayanan::where('id', $id)->delete();

        return back()->with('success', 'Yeaai, sub kategori pelayanan berhasil dihapus');
    }

    public function getKategoriPelayanan(Request $request)
    {
        $data['kategori'] = MasterKategoriPelayanan::where('master_pelayanan_id', $request->pelayanan_id)->get();
        return response()->json($data);
    }

    public function getSubKategoriPelayanan(Request $request)
    {
        $data['sub_kategori'] = MasterSubKategoriPelayanan::where('master_kategori_pelayanan_id', $request->sub_kategori_id)->get();
        return response()->json($data);
    }
}
