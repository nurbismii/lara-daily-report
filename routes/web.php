<?php

use App\Http\Controllers\KegiatanHarianController;
use App\Http\Controllers\KegiatanMingguanController;
use App\Http\Controllers\OrganisirTimController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\Pengaturan\KategoriKegiatanController;
use App\Http\Controllers\Pengaturan\KegiatanController;
use App\Http\Controllers\Pengaturan\PICController;
use App\Http\Controllers\Pengaturan\WaktukerjaController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'profile'], function () {
        route::get('/', [PenggunaController::class, 'profile']);
    });

    Route::group(['prefix' => 'pelayanan'], function () {
        route::get('/', [PelayananController::class, 'index']);
        route::post('/store', [PelayananController::class, 'store'])->name('pelayanan.store');
        route::get('/hr', [PelayananController::class, 'hr']);

        route::get('/cari-karyawan', [PelayananController::class, 'cariKaryawan']);
        route::get('/detail/{id}', [PelayananController::class, 'detailKaryawan']);
    });

    Route::group(['prefix' => 'pengguna'], function () {

        route::get('/', [PenggunaController::class, 'index']);
        route::post('/store', [PenggunaController::class, 'store'])->middleware('check.access')->name('store.pengguna');
        route::patch('/update/{id}', [PenggunaController::class, 'update'])->middleware('check.access')->name('update.pengguna');
        route::delete('/delete/{id}', [PenggunaController::class, 'destroy'])->middleware('check.access')->name('delete.pengguna');
        route::post('/update/foto/', [PenggunaController::class, 'fotoProfil'])->name('update.fotoProfil');
    });

    Route::group(['prefix' => 'kegiatan-harian'], function () {

        route::get('/', [KegiatanHarianController::class, 'index'])->middleware('check.access')->name('kegiatanharian');
        route::get('/create', [KegiatanHarianController::class, 'create']);
        route::get('/staff-dan-spv', [KegiatanHarianController::class, 'createKegiatan']);
        route::post('/store', [KegiatanHarianController::class, 'store'])->name('staff.store');
        route::get('/detail/{id}', [KegiatanHarianController::class, 'show'])->name('kegiatan-harian.show');
        route::get('/detail/penilaian/{id}', [KegiatanHarianController::class, 'showPenilaianKerja'])->name('kegiatan-harian.show.penilaian');
        route::patch('/update/{id}', [KegiatanHarianController::class, 'update'])->name('update.kegiatanharian');
        route::delete('/destroy/{id}', [KegiatanHarianController::class, 'destroy'])->name('delete.absensi-kegiatan');

        route::get('/destroy-by-get/{id}', [KegiatanHarianController::class, 'destroy'])->name('delete.absensi-kegiatan-delete');
        route::post('/store/{id}', [KegiatanHarianController::class, 'storeTambahKegiatan'])->name('store.tambah.kegiatanharian');
        route::patch('/update/kegiatan/{id}', [KegiatanHarianController::class, 'updateKegiatan'])->name('update.ubah.kegiatanharian');
        route::delete('/destroy/kegiatan/{id}', [KegiatanHarianController::class, 'destroyKegiatan'])->name('destroy.kegiatanharian');

        route::post('/unggah/berkas/{id}', [KegiatanHarianController::class, 'unggahBerkas'])->name('store.unggahBerkas');
        route::get('/unduh/berkas/{id}/{nik}', [KegiatanHarianController::class, 'unduhBerkas'])->name('get.unduhBerkas');
    });

    Route::group(['prefix' => 'kegiatan-mingguan'], function () {
        route::get('/', [KegiatanMingguanController::class, 'index']);
        route::get('/create', [KegiatanMingguanController::class, 'create']);
        route::get('/show/{id}', [KegiatanMingguanController::class, 'show'])->name('show.kegiatanMingguan');
        route::post('/update/{id}', [KegiatanMingguanController::class, 'update'])->name('update.kegiatanMingguan');

        route::get('/laporan-bulanan', [KegiatanMingguanController::class, 'laporan']);
        route::get('/cetak-laporan/{tgl_awal}/{tgl_akhir}/{tipe}', [KegiatanMingguanController::class, 'cetakPdf'])->name('cetakPdf');
    });

    Route::patch('/update/status-kegiatan/{id}', [KegiatanHarianController::class, 'updateStatusKegiatan'])->name('update.statusKegiatan');
    Route::post('/store/penilaian-kerja', [KegiatanHarianController::class, 'penilaianKerjaHarian'])->name('store.penilaian-kerja');
    Route::post('/store/penilaian-kerja-asmen', [KegiatanHarianController::class, 'penilaianKerjaHarianAsmen'])->name('store.penilaian-kerja-asmen');
    Route::post('/update/penilaian-kerja', [KegiatanHarianController::class, 'updatePenilaianKerjaHarian'])->name('update.penilaian-kerja');

    route::post('/store/agenda-kerja-esok/', [KegiatanHarianController::class, 'storeAgendaKerja'])->name('store.agendaKerjaEsokHari');

    Route::group(['middleware' => 'check.access'], function () {

        Route::group(['prefix' => 'organisir-tim'], function () {

            route::get('/', [OrganisirTimController::class, 'index']);
            route::post('/store', [OrganisirTimController::class, 'store'])->name('store.organisir');
            route::post('/update/{id}', [OrganisirTimController::class, 'update'])->name('update.organisir');
            route::delete('/delete/{id}', [OrganisirTimController::class, 'destroy'])->name('delete.organisir');

            Route::group(['prefix' => 'anggota-tim'], function () {

                route::post('/store', [OrganisirTimController::class, 'tambahAnggotaTim'])->name('store.anggotatim');
                route::patch('/update/{id}', [OrganisirTimController::class, 'updateAnggotaTim'])->name('update.anggotatim');
                route::get('/delete/{id}', [OrganisirTimController::class, 'destroyAnggotaTim'])->name('delete.anggotatim');
            });
        });
    });

    Route::post('fetch/kategori-pelayanan', [PelayananController::class, 'getKategoriPelayanan']);
    Route::post('fetch/sub-kategori-pelayanan', [PelayananController::class, 'getSubKategoriPelayanan']);


    Route::group(['middleware' => 'check.access', 'prefix' => 'pengaturan'], function () {

        Route::group(['prefix' => 'pelayanan'], function () {
            route::get('/', [PelayananController::class, 'pelayanan']);
            route::post('/store/pelayanan', [PelayananController::class, 'pelayananStore'])->name('set.pelayanan.store');
            route::patch('/update/{id}', [PelayananController::class, 'pelayananUpdate'])->name('set.pelayanan.update');
            route::delete('/delete/{id}', [PelayananController::class, 'pelayananDestroy'])->name('set.pelayanan.destroy');

            route::get('/kategori', [PelayananController::class, 'kategoriPelayanan']);
            route::post('/store/kategori', [PelayananController::class, 'kategoriPelayananStore'])->name('set.kategori.pelayanan.store');
            route::patch('/update/kategori/{id}', [PelayananController::class, 'kategoriPelayananUpdate'])->name('set.kategori.pelayanan.update');
            route::delete('/delete/kategori/{id}', [PelayananController::class, 'kategoriPelayananDestroy'])->name('set.kategori.pelayanan.destroy');

            route::post('/store/sub/kategori', [PelayananController::class, 'subKategoriPelayananStore'])->name('set.sub.kategori.pelayanan.store');
            route::post('/update/sub/kategori', [PelayananController::class, 'subKategoriPelayananUpdate'])->name('set.sub.kategori.pelayanan.update');
            route::get('/delete/sub/kategori/{id}', [PelayananController::class, 'subKategoriPelayananDestroy'])->name('set.sub.kategori.pelayanan.destroy');
        });

        Route::group(['prefix' => 'waktu-kerja'], function () {

            route::get('/', [WaktukerjaController::class, 'index']);
            route::get('/create', [WaktukerjaController::class, 'create']);
            route::post('/store', [WaktukerjaController::class, 'store'])->name('store.waktukerja');
            route::get('/edit/{id}', [WaktukerjaController::class, 'edit'])->name('edit.waktukerja');
            route::patch('/update/{id}', [WaktukerjaController::class, 'update'])->name('update.waktukerja');
            route::delete('/delete/{id}', [WaktukerjaController::class, 'destroy'])->name('delete.waktukerja');

            route::group(['prefix' => 'kategori'], function () {
                route::get('/create/{id}', [WaktukerjaController::class, 'createKategoriWaktuKerja'])->name('create.kategoriwaktukerja');
                route::post('/store', [WaktukerjaController::class, 'storeKategoriWaktuKerja'])->name('store.kategoriwaktukerja');
                route::patch('/update/{id}', [WaktukerjaController::class, 'updateKategoriWaktuKerja'])->name('update.kategoriwaktukerja');
                route::delete('/delete/{id}', [WaktukerjaController::class, 'destroyKategoriWaktuKerja'])->name('delete.kategoriwaktukerja');
            });
        });

        Route::group(['middleware' => 'check.access', 'prefix' => 'kegiatan'], function () {

            route::get('/', [KegiatanController::class, 'index']);
            route::post('/store', [KegiatanController::class, 'store'])->name('store.jeniskegiatan');
            route::patch('/update/{id}', [KegiatanController::class, 'update'])->name('update.jeniskegiatan');
            route::delete('/delete/{id}', [KegiatanController::class, 'destroy'])->name('delete.jeniskegiatan');
        });

        Route::group(['middleware' => 'check.access', 'prefix' => 'kategori-kegiatan'], function () {

            route::get('/', [KategoriKegiatanController::class, 'index']);
            route::post('/store', [KategoriKegiatanController::class, 'store'])->name('store.kategorikegiatan');
            route::patch('/update/{id}', [KategoriKegiatanController::class, 'update'])->name('update.kategorikegiatan');
            route::delete('/delete/{id}', [KategoriKegiatanController::class, 'destroy'])->name('delete.kategorikegiatan');
        });

        Route::group(['middleware' => 'check.access', 'prefix' => 'person-in-charge'], function () {

            route::get('/', [PICController::class, 'index']);
            route::post('/store', [PICController::class, 'store'])->name('store.pic');
            route::patch('/update/{id}', [PICController::class, 'update'])->name('update.pic');
            route::delete('/delete/{id}', [PICController::class, 'destroy'])->name('delete.pic');
        });
    });
});
