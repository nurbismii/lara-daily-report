@extends('layouts.app')

@section('content')

<style>
    ul.timeline {
        list-style-type: none;
        position: relative;
    }

    ul.timeline:before {
        content: ' ';
        background: #d4d9df;
        display: inline-block;
        position: absolute;
        left: 29px;
        width: 2px;
        height: 100%;
        z-index: 400;
    }

    ul.timeline>li {
        margin: 20px 0;
        padding-left: 20px;
    }

    ul.timeline>li:before {
        content: ' ';
        background: white;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #696cff;
        left: 20px;
        width: 20px;
        height: 20px;
        z-index: 400;
    }
</style>

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
                            <img src="../assets/img/illustrations/girl-doing-yoga-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
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

        <div class="col-lg-12 order-0 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Pelayanan terbaru</h5>
                        <small class="text-muted">{{ $jumlah_pengguna }} Total pelayanan</small>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        @foreach($pelayanan as $key => $row)
                        <li>
                            <div class="d-flex justify-content-between">
                                <a href="javascript:void(0)" class="mb-0">{{ $row->MasterPelayanan->nama_layanan }}</a>
                            </div>
                            <div class="d-flex justify-content-between">
                                {{ getNamaPic($row->nik_pic) ?? '' }} telah melakukan pelayanan {{ $row->MasterKategoriPelayanan->kategori_pelayanan ?? '' }} {{ strtolower($row->MasterSubKategoriPelayanan->sub_kategori_pelayanan) ?? '' }}
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">{{ $row->created_at->diffForHumans() }}</small>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
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
                            <h2 class="mb-2">{{ count($total_jenis_kegiatan) }}</h2>
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
                            <h2 class="mb-2">{{ count($total_kegiatan_harian) }}</h2>
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
    var daftarNamaJenisKegiatan = JSON.parse('{!! json_encode($daftar_nama_jenis_kegiatan) !!}');
    var totalJenisKegiatan = JSON.parse('{!! json_encode($total_jenis_kegiatan) !!}');

    var daftarKegiatanHarian = JSON.parse('{!! json_encode($daftar_kegiatan_harian) !!}');
    var totalKegiatanHarian = JSON.parse('{!! json_encode($total_kegiatan_harian) !!}');
</script>
<!-- / Content -->
@endsection