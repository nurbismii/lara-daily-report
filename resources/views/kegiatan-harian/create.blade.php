@extends('layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<style>
    span.select2.select2-container.select2-container--classic {
        width: 100% !important;
    }
</style>

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
    <h4 class="fw-bold py-2 mb-2">Kegiatan harian</h4>
    <!-- Basic Bootstrap Table -->
    <div class="row mb-5">
        <div class="col-lg-12">
            @include('message')
        </div>
        <div class="col-md-6 col-lg-12">
            <div class="card mb-2">
                <div class="card-body">
                    <a href="/kegiatan-harian/staff-dan-spv" class="btn btn-primary float-end">Tambah kegiatan</a>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <h5 class="card-header">Tabel kegiatan</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Agenda esok</th>
                                <th>Nama</th>
                                <th>Kehadiran</th>
                                <th>Status SPV</th>
                                <th>Status Asmen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($data_kegiatan as $data)
                            <tr>
                                <th>{{ getTanggalIndo($data->tanggal) }}</th>
                                <th scope="row">
                                    <button type="button" class="btn btn-sm rounded-pill btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-daftar-kegiatan{{$data->id}}">
                                        <span class="tf-icons bx bx-list-ol"></span>&nbsp; Data
                                    </button>
                                </th>
                                <td>
                                    <button type="button" class="btn btn-sm rounded-pill btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-agenda{{$data->id}}">
                                        <span class="tf-icons bx bx-bell"></span>&nbsp; Agenda
                                    </button>
                                </td>
                                <td>
                                    {{ $data->getAnggota->name ?? '' }} <br>
                                    <small class="text-light fw-semibold">{{ $data->getAnggota->nik ?? '' }}</small> |
                                    <small class="text-light fw-semibold">{{ $data->getAnggota->jabatan ?? '' }}</small>
                                </td>
                                <td>
                                    <small class="text-light fw-semibold">{{ substr($data->jam_masuk,0,5) }} </small>
                                    <small class="text-light fw-semibold">{{ substr($data->jam_istirahat,0,5) }} </small><br>
                                    <small class="text-light fw-semibold">{{ substr($data->jam_kembali_istirahat,0,5) }} </small>
                                    <small class="text-light fw-semibold">{{ substr($data->jam_pulang,0,5) }}</small>
                                </td>
                                <td>
                                    @if($data->status_spv != '')
                                    <span class="badge bg-label-success">Diterima</span>
                                    @else
                                    <span class="badge bg-label-primary">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    @if($data->status_asmen != '')
                                    <span class="badge bg-label-success">Diterima</span>
                                    @else
                                    <span class="badge bg-label-primary">Menunggu</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-edit-absensi{{$data->id}}"><i class="bx bx-edit-alt me-1"></i> Edit kehadiran</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-hapus-semua{{$data->id}}"><i class="bx bx-trash me-1"></i> Hapus kehadiran & kegiatan</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-2 mx-3">
                        {!! $data_kegiatan->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal daftar kegiatan -->
@foreach($data_kegiatan as $data)
<div class="modal fade" id="modal-daftar-kegiatan{{$data->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 offset-md-1">
                        <h5>Timeline kegiatan</h5>
                        <ul class="timeline">
                            @foreach($data->kegiatanHarian as $key => $row)
                            <li>
                                <div class="d-flex justify-content-between">
                                    <a href="javascript:void(0)" class="lead mb-2">{{++$key}}. {{ getJenisKegiatanById($row->jenis_kegiatan_id) }}</a>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow text-end" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-unggah-berkas{{$row->id}}"><i class="bx bx-plus me-1"></i> Data pendukung </a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-edit-kegiatan{{$row->id}}"><i class="bx bx-edit-alt me-1"></i> Edit kegiatan</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-hapus-kegiatan{{$row->id}}"><i class="bx bx-trash me-1"></i> Hapus kegiatan</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    @isset($row->selesai)
                                    @php

                                    $diff = strtotime($row->selesai) - strtotime($row->mulai);
                                    $jam = floor($diff / (60 * 60));
                                    $menit = $diff - ( $jam * (60 * 60) );
                                    $menit = floor($menit/60);

                                    @endphp
                                    <p class="mb-2 text-muted"><small>{{ substr($row->mulai, 0, 5) }} - {{ substr($row->selesai, 0, 5) }}</small></p>
                                    @if($jam > 0)
                                    <p class="mb-2 text-muted"><small>{{ $jam ?? '0' }} jam {{ $menit ?? '0' }} menit</small></p>
                                    @else
                                    <p class="mb-2 text-muted"><small>{{ $menit ?? '0' }} menit</small></p>
                                    @endif
                                    @endisset
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="javascript:void(0)" class="text-muted mb-2">{{ getKategoriKegiatanById($row->kategori_kegiatan_id) }} </a>
                                    <a href="javascript:void(0)" class="text-muted mb-2">({{ getPicById($row->pic_id) }})</a>
                                </div>
                                <div>
                                    <p><strong>{{ $row->kegiatan }}</strong></p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Kendala</p>
                                    <a data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="right" data-bs-html="true" title="" data-bs-original-title="<i class='bx bx-bug-alt bx-xs' ></i> <span>{{ $row->kendala }}</span>">{{ substr($row->kendala, 0, 25)}}...</a>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Status kegiatan</p>
                                    <p>{{ ucfirst($row->status_kegiatan) }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Status akhir</p>
                                    <p>{{ ucfirst($row->status_akhir) }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Kuantitas</p>
                                    <p>{{ $row->kuantitas ?? '-' }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Pelayanan</p>
                                    @foreach($row->pelayanan as $key => $pel)
                                    {{ ++$key }}. {{ $pel->nama_karyawan }} ({{getNamaKategoriPelayanan($pel->kategori_pelayanan_id)}})<br>
                                    @endforeach
                                </div>

                                @foreach($row->dataPendukung as $berkas)
                                <small><a class="text-sm" href="{{ route('get.unduhBerkas', ['id' => $berkas->id, 'nik' => $data->getAnggota->nik]) }}"><u> {{ $berkas->nama_file }}</u></a> <br></small>
                                @endforeach
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <a href="{{ route('tambah-kegiatan.harian', $data->id) }}" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Kegiatan</a>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- Modal daftar kegiatan end -->

<!-- Tambah agenda esok -->
@foreach($data_kegiatan as $data)
<div class="modal fade" id="modal-agenda-esok{{$data->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Form agenda esok hari</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('store.agendaKerjaEsokHari') }}" method="post">
                @csrf
                <div class="modal-body control-group after-add-more-agenda">
                    <div class="row">
                        <div class="col mb-3">
                            <input type="hidden" class="form-control" name="id" value="{{$data->id}}" readonly></input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nik">Kegiatan</label>
                            <input class="form-control" name="kegiatan[]" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nik">Uraian Kegiatan</label>
                            <textarea class="form-control" name="uraian_kegiatan[]" cols="30" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nik">Persentase penyelesaian</label>
                            <input class="form-control" name="persentase_penyelesaian[]" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" href="#form-agenda" class="btn btn-success float-end mx-2 add-more-agenda">
                        <span class="tf-icons bx bx-plus"></span>
                        Form agenda
                    </a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>

        <div class="copy invisible">
            <div id="form-agenda" class="modal-body control-group count">
                <div class="row">
                    <div class="col mb-3">
                        <input type="hidden" class="form-control" name="id" value="{{$data->absensi_id}}" readonly></input>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nik">Kegiatan</label>
                        <input class="form-control" name="kegiatan[]" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nik">Uraian Kegiatan</label>
                        <textarea class="form-control" name="uraian_kegiatan[]" cols="30" rows="5" required></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nik">Persentase penyelesaian</label>
                        <input class="form-control" name="persentase_penyelesaian[]" required>
                    </div>
                </div>
                <button type="button" class="btn btn-danger remove btn-sm">
                    <span class="tf-icons bx bx-trash"></span>
                    Hapus form agenda
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- Tambah agenda esok end -->

<!-- Modal daftar agenda -->
@foreach($data_kegiatan as $data)
<div class="modal fade" id="modal-agenda{{$data->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Agenda esok hari</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach($data->agendaEsok as $key => $val)
                <div class="divider divider-dotted">
                    <div class="divider-text">{{ ++$key }} - Agenda esok hari</div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Agenda</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{$val->kegiatan}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Uraian kegiatan</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{$val->uraian_kegiatan}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Persentase</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{$val->persentase}}%
                    </div>
                </div>
                <hr>

                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-agenda-esok{{$data->id}}"><i class="bx bx-plus me-1"></i> Agenda esok</a>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- Modal daftar agenda end -->

<!-- Tambah kegiatan -->
@foreach($data_kegiatan as $data)
<div class="modal fade" id="modal-tambah-kegiatan{{$data->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Form perbarui kegiatan harian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('store.tambah.kegiatanharian', $data->id) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <input type="hidden" class="form-control" name="id" value="{{$data->absensi_id}}" readonly></input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="kegiatan">Kegiatan</label>
                            <textarea class="form-control" name="kegiatan" id="" cols="30" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="jenis-kegiatan">Jenis Kegiatan</label>
                            <select name="jenis_kegiatan_id" class="form-select" required>
                                <option value="" selected>-- Pilih jenis kegiatan --</option>
                                @foreach($jenis_kegiatan as $row)
                                <option value="{{$row->id}}">{{$row->jenis_kegiatan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="kata-sandi">Kategori kegiatan</label>
                            <select name="kategori_kegiatan_id" class="form-select" required>
                                <option value="" selected>-- Pilih kategori kegiatan --</option>
                                @foreach($kategori_kegiatan as $row)
                                <option value="{{$row->id}}">{{$row->kategori_kegiatan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="pic">PIC</label>
                            <select name="pic_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih PIC --</option>
                                @foreach($pic as $row)
                                <option value="{{$row->id}}">{{$row->pic}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="kendala">Kendala/Masalah</label>
                            <textarea name="kendala" class="form-control" id="" cols="30" rows="5 "></textarea>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="mulai-mengerjakan">Mulai mengerjakan</label>
                            <input type="text" id="mulaiMengerjakanKegiatan" maxlength="5" name="mulai" class="form-control" required>
                        </div>
                        <div class="col mb-2">
                            <label for="selesai-mengerjakan">Selesai mengerjakan</label>
                            <input type="text" id="selesaiMengerjakanKegiatan" maxlength="5" name="selesai" class="form-control" required>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="status-kegiatan">Status Kegiatan</label>
                            <select name="status_kegiatan" class="form-select" required>
                                <option value="" disabled selected>-- Pilih status kegiatan --</option>
                                <option value="selesai">Selesai</option>
                                <option value="tidak selesai">Tidak selesai</option>
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="deadline">Deadline penyelesaian</label>
                            <input type="date" name="deadline" class="form-control">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="status_akhir">Status akhir</label>
                            <select name="status_akhir" class="form-select" required>
                                <option value="" disabled selected>-- Pilih status akhir</option>
                                <option value="sesuai">Sesuai</option>
                                <option value="tidak sesuai">Tidak sesuai</option>
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="kuantitas">Kuantitas</label>
                            <input type="number" name="kuantitas" class="form-control">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-2 ">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check pelayanan" name="pelayanan" id="pelayanan_off" value="0" checked="" autocomplete="off">
                                <label class="btn btn-outline-primary" for="pelayanan_off">Tanpa pelayanan</label>
                                <input type="radio" class="btn-check pelayanan" name="pelayanan" id="pelayanan_on" value="1" autocomplete="off">
                                <label class="btn btn-outline-primary" for="pelayanan_on">Pelayanan</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-pelayanan">
                        <div class="row">
                            <div class="col mb-2">
                                <label for="search">Daftar karyawan</label>
                                <select name="search" class="form-select search" id="nik"></select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="nama">Nama</label>
                                <input type="text" id="nama_karyawan" name="nama_karyawan" class="form-control" required readonly>
                            </div>
                            <div class="col mb-2">
                                <label for="nik">NIK</label>
                                <input type="text" name="nik_karyawan" class="form-control nik_karyawan" required readonly>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="departemen">Departemen</label>
                                <input type="text" id="departemen" name="departemen" class="form-control" required readonly>
                            </div>
                            <div class="col mb-2">
                                <label for="divisi">Divisi</label>
                                <input type="text" id="divisi" name="divisi" class="form-control nik_karyawan" required readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="posisi">Posisi</label>
                                <input type="text" id="posisi" name="posisi" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="pelayanan">Pelayanan</label>
                                <select name="pelayanan_id" class="form-select" id="pelayanan-dropdown">
                                    <option value="" disabled selected>- Pilih pelayanan -</option>
                                    @foreach($pelayanan as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama_layanan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="kategori-pelayanan">Kategori pelayanan</label>
                                <select name="kategori_pelayanan_id" class="form-select" id="kategori-dropdown"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="pelayanan">Sub Kategori pelayanan</label>
                                <select name="sub_kategori_pelayanan_id" class="form-select" id="sub-kategori-dropdown"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="keperluan">Keperluan</label>
                                <textarea name="keperluan" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="pic">Person in Charge</label>
                                <input type="text" value="{{ Auth::user()->name }}" class="form-control" required readonly>
                                <input type="hidden" name="nik_pic" value="{{ Auth::user()->nik }}" class="form-control" required readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!-- Tambah kegiatan ends -->

<!-- Edit kegiatan -->
@foreach($data_kegiatan as $data)
@foreach($data->kegiatanHarian as $harian)
<div class="modal fade" id="modal-edit-kegiatan{{$harian->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Form perbarui kegiatan harian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('update.ubah.kegiatanharian', $harian->id) }}" method="post">
                @csrf
                {{method_field('patch')}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nik">Kegiatan</label>
                            <textarea class="form-control" name="kegiatan" cols="30" rows="5" required>{{$harian->kegiatan}}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="email">Jenis Kegiatan</label>
                            <select name="jenis_kegiatan_id" class="form-select" required>
                                <option value="{{$harian->jenis_kegiatan_id}}" selected>{{ getJenisKegiatanById($harian->jenis_kegiatan_id) }}</option>
                                @foreach($jenis_kegiatan as $row)
                                <option value="{{$row->id}}">{{$row->jenis_kegiatan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="kata-sandi">Kategori kegiatan</label>
                            <select name="kategori_kegiatan_id" class="form-select" required>
                                <option value="{{ $harian->kategori_kegiatan_id }}" selected>{{ getKategoriKegiatanById($harian->kategori_kegiatan_id) }}</option>
                                @foreach($kategori_kegiatan as $row)
                                <option value="{{$row->id}}">{{$row->kategori_kegiatan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="email">PIC</label>
                            <select name="pic_id" class="form-select" required>
                                <option value="{{ $harian->pic_id }}" selected>{{ getPicById($harian->pic_id) }}</option>
                                @foreach($pic as $row)
                                <option value="{{$row->id}}">{{$row->pic}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="kendala">Kendala/Masalah</label>
                            <textarea name="kendala" class="form-control" id="" cols="30" rows="5 ">{{$harian->kendala}}</textarea>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="nama">Mulai mengerjakan</label>
                            <input type="text" id="mulaiMengerjakanEditKegiatan" value="{{substr($harian->mulai,0,5)}}" maxlength="5" name="mulai" class="form-control" required>
                        </div>
                        <div class="col mb-2">
                            <label for="email">Selesai mengerjakan</label>
                            <input type="text" id="selesaiMengerjakanEditKegiatan" value="{{substr($harian->selesai,0,5)}}" maxlength="5" name="selesai" class="form-control" required>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="nama">Status Kegiatan</label>
                            <select name="status_kegiatan" class="form-select" required>
                                <option value="{{$harian->status_kegiatan}}" selected>{{ucfirst($harian->status_kegiatan)}}</option>
                                <option value="selesai">Selesai</option>
                                <option value="tidak selesai">Tidak selesai</option>
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="email">Deadline penyelesaian</label>
                            <input type="date" name="deadline" value="{{$harian->deadline}}" class="form-control">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="nama">Status akhir</label>
                            <select name="status_akhir" class="form-select" required>
                                <option value="{{$harian->status_akhir}}" selected>{{ucfirst($harian->status_akhir)}}</option>
                                <option value="sesuai">Sesuai</option>
                                <option value="tidak sesuai">Tidak sesuai</option>
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="kuantitas">Kuantitas</label>
                            <input type="number" name="kuantitas" value="{{$harian->kuantitas}}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endforeach
<!-- Edit kegiatan ends -->

<!-- Update Absensi -->
@foreach($data_kegiatan as $data)
<div class="modal fade" id="modal-edit-absensi{{$data->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Form perbarui absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('update.kegiatanharian', $data->id) }}" method="post">
                @csrf
                {{method_field('patch')}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nik">Nomor Induk Karyawan</label>
                            <input type="text" value="{{$data->getAnggota->nik}}" class="form-control" readonly />
                        </div>
                    </div>
                    <div class="row mb-3 g-2">
                        <div class="col mb-2">
                            <label for="nama">Nama</label>
                            <input type="text" value="{{$data->getAnggota->name}}" class="form-control" readonly>
                        </div>
                        <div class="col mb-2">
                            <label for="email">Jabatan</label>
                            <input type="email" value="{{$data->getAnggota->jabatan}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nik">Tanggal</label>
                            <input type="date" name="tanggal" value="{{$data->tanggal}}" class="form-control" required />
                        </div>
                    </div>
                    <div class="row mb-3 g-2">
                        <div class="col mb-2">
                            <label for="kata-sandi">Jam masuk</label>
                            <input type="text" id="jamMasuk" maxlength="5" name="jam_masuk" value="{{substr($data->jam_masuk, 0, 5)}}" class="form-control" required>
                        </div>
                        <div class="col mb-2">
                            <label for="email">Jam istirahat</label>
                            <input type="text" id="jamIstirahat" maxlength="5" name="jam_istirahat" value="{{substr($data->jam_istirahat, 0, 5)}}" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3 g-2">
                        <div class="col mb-2">
                            <label for="kata-sandi">Jam kembali istirahat</label>
                            <input type="text" id="jamKembaliIstirahat" maxlength="5" name="jam_kembali_istirahat" value="{{substr($data->jam_kembali_istirahat, 0 ,5)}}" class="form-control">
                        </div>
                        <div class="col mb-2">
                            <label for="email">Jam pulang</label>
                            <input type="text" id="jamPulang" name="jam_pulang" maxlength="5" value="{{substr($data->jam_pulang,0,5)}}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!-- Update Absensi ends -->

@foreach($data_kegiatan as $data)
<div class="modal modal-top fade" id="modal-hapus-semua{{$data->id}}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{route('delete.absensi-kegiatan', $data->id)}}" method="post" class="modal-content">
            @csrf
            {{method_field('delete')}}
            <div class="modal-header">
                <h5 class="modal-title" id="modalTopTitle">Konfirmasi permintaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Kamu yakin ingin menghapus kehadiran ini [ {{getTanggalIndo($data->tanggal)}} ], jika menghapus data ini, data kegiatan harian pada tanggal {{getTanggalIndo($data->tanggal)}} akan terhapus
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="submit" class="btn btn-primary">Hapus</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@foreach($data_kegiatan as $data)
@foreach($data->kegiatanHarian as $harian)
<div class="modal modal-top fade" id="modal-hapus-kegiatan{{$harian->id}}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{route('destroy.kegiatanharian', $harian->id)}}" method="post" class="modal-content">
            @csrf
            {{method_field('delete')}}
            <div class="modal-header">
                <h5 class="modal-title" id="modalTopTitle">Konfirmasi permintaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Kamu yakin ingin menghapus kegiatan ini [ {{$harian->kegiatan}} ]
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="submit" class="btn btn-primary">Hapus</button>
            </div>
        </form>
    </div>
</div>
@endforeach
@endforeach

@foreach($data_kegiatan as $data)
@foreach($data->kegiatanHarian as $harian)
<div class="modal modal-top fade" id="modal-unggah-berkas{{$harian->id}}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{route('store.unggahBerkas', $harian->id)}}" enctype="multipart/form-data" method="post" class="modal-content">
            @csrf
            <div class="modal-header">
                <input type="hidden" name="id" value="{{$harian->id}}" class="form-control" id="">
                <input type="hidden" name="jenis_kegiatan" value="{{$harian->kegiatan}}" class="form-control" id="">
                <h5 class="modal-title" id="modalTopTitle">Unggah berkas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        Yakin ingin mengunggah berkas pendukung untuk kegiatan ini [ {{$harian->kegiatan}} ] ?
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <input type="file" class="form-control" name="data_pendukung">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="submit" class="btn btn-primary">Unggah</button>
            </div>
        </form>
    </div>
</div>
@endforeach
@endforeach

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    $(document).ready(function() {

        /*------------------------------------------
        --------------------------------------------
        Country Dropdown Change Event
        --------------------------------------------
        --------------------------------------------*/
        $('#pelayanan-dropdown').on('change', function() {
            var idPelayanan = this.value;
            $("#kategori-dropdown").html('');
            $.ajax({
                url: "{{url('fetch/kategori-pelayanan')}}",
                type: "POST",
                data: {
                    pelayanan_id: idPelayanan,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#kategori-dropdown').html('<option value="">-- Pilih kategori --</option>');
                    $.each(result.kategori, function(key, value) {
                        $("#kategori-dropdown").append('<option value="' + value
                            .id + '">' + value.kategori_pelayanan + '</option>');
                    });
                    $('#sub-kategori-dropdown').html('<option value="">-- Pilih sub kategori --</option>');
                }
            });
        });

        /*------------------------------------------
        --------------------------------------------
        State Dropdown Change Event
        --------------------------------------------
        --------------------------------------------*/
        $('#kategori-dropdown').on('change', function() {
            var kategori_id = this.value;
            $("#sub-kategori-dropdown").html('');
            $.ajax({
                url: "{{url('fetch/sub-kategori-pelayanan')}}",
                type: "POST",
                data: {
                    sub_kategori_id: kategori_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(res) {
                    $('#sub-kategori-dropdown').html('<option value="">-- Pilih sub kategori --</option>');
                    $.each(res.sub_kategori, function(key, value) {
                        $("#sub-kategori-dropdown").append('<option value="' + value
                            .id + '">' + value.sub_kategori_pelayanan + '</option>');
                    });
                }
            });
        });

    });
</script>

<script type="text/javascript">
    $('.search').select2({
        width: 'resolve',
        theme: 'default',
        placeholder: 'Cari karyawan...',
        ajax: {
            url: '/pelayanan/cari-karyawan',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.nik + ' - ' + item.nama_karyawan,
                            id: item.nik
                        }
                    })
                };
            },
            cache: true
        }
    });

    $('#nik').on('change', function() {
        var id = $(this).val();
        if (id) {
            $.ajax({
                url: '/pelayanan/detail/' + id,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('.nik_karyawan').val(data.nik);
                        $('#nama_karyawan').val(data.nama_karyawan);
                        $('#departemen').val(data.departemen);
                        $('#divisi').val(data.nama_divisi);
                        $('#posisi').val(data.posisi);
                        $('#jabatan').val(data.jabatan);
                        $('#sisa_cuti').val(data.sisa_cuti);
                    }
                }
            });
        }
    });
</script>

<script>
    $(document).ready(function() {

        $(".form-pelayanan").css("display", "none");

        $('.pelayanan').change(function() {
            if ($(this).val() === "1") {
                $(".form-pelayanan").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
            } else {
                $(".form-pelayanan").slideUp("fast");
            }
        });

        $(".add-more-agenda").click(function() {
            var count = $(".count").length;
            var html = $(".copy").html();
            $(".after-add-more-agenda").after(html);
        });

        // saat tombol remove dklik control group akan dihapus 
        $("body").on("click", ".remove", function() {
            $(this).parents(".control-group").remove();
        });
    });

    const jamMasuk = document.getElementById("jamMasuk");
    jamMasuk.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const jamIstirahat = document.getElementById("jamIstirahat");
    jamIstirahat.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const jamKembaliIstirahat = document.getElementById("jamKembaliIstirahat");
    jamKembaliIstirahat.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const jamPulang = document.getElementById("jamPulang");
    jamPulang.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const mulaiMengerjakanKegiatan = document.getElementById("mulaiMengerjakanKegiatan");
    mulaiMengerjakanKegiatan.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const selesaiMengerjakanKegiatan = document.getElementById("selesaiMengerjakanKegiatan");
    selesaiMengerjakanKegiatan.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const mulaiMengerjakanEditKegiatan = document.getElementById("mulaiMengerjakanEditKegiatan");
    mulaiMengerjakanEditKegiatan.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const selesaiMengerjakanEditKegiatan = document.getElementById("selesaiMengerjakanEditKegiatan");
    selesaiMengerjakanEditKegiatan.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });
</script>



@endsection