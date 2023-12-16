@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat datang {{ Auth::user()->name }}! 🎉</h5>
                            <p class="mb-4">
                                Apa agenda kamu hari ini ? Yuk catatan kegiatan harian kamu
                            </p>

                            <a href="/kegiatan-harian/staff-dan-spv" class="btn btn-sm btn-outline-primary">Buat kegiatan</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                                </div>
                            </div>
                            <span>Pengguna</span>
                            <h3 class="card-title mb-1">{{ $jumlah_pengguna }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="../assets/img/icons/unicons/wallet-info.png" alt="Credit Card" class="rounded" />
                                </div>
                            </div>
                            <span>Tim</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $jumlah_tim }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Order Statistics -->
        <div class="col-lg-6 order-0 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Jenis Kegiatan Populer</h5>
                        <small class="text-muted">{{ $jumlah_pengguna }} Total pengguna</small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2">{{ $kegiatan_harian->count() }}</h2>
                            <span>Jenis kategori kegiatan digunakan</span>
                        </div>
                        <div id="jenisKegiatanChart"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Order Statistics -->

        <!-- Order Statistics -->
        <div class="col-lg-6 order-0 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Kategori Kegiatan Populer</h5>
                        <small class="text-muted">{{ $jumlah_pengguna }} Total pengguna</small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2">{{ $kegiatan_harian->count() }}</h2>
                            <span>Kategori kegiatan digunakan</span>
                        </div>
                        <div id="kegiatanChart"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Order Statistics -->
    </div>
</div>

<script>
    var totalJenisKegiatan = JSON.parse('{!! json_encode($total_jenis_kegiatan) !!}');
    var daftarNamaJenisKegiatan = JSON.parse('{!! json_encode($daftar_nama_jenis_kegiatan) !!}');

    var totalKegiatanHarian = JSON.parse('{!! json_encode($total_kegiatan_harian) !!}');
    var daftarKegiatanHarian = JSON.parse('{!! json_encode($daftar_kegiatan_harian) !!}');
</script>
<!-- / Content -->
@endsection