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
                                    <a href="javascript:void(0)" class="lead mb-2">{{ getJenisKegiatanById($row->jenis_kegiatan_id) }}</a>
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
                                    <p class="mb-2">{{ getJenisKegiatanById($row->jenis_kegiatan_id) }}</p>
                                    <p class="mb-2">{{ substr($row->mulai, 0, 5) }} - {{ substr($row->selesai, 0, 5) }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="javascript:void(0)" class="text-muted mb-2">{{ getKategoriKegiatanById($row->kategori_kegiatan_id) }} </a>
                                    <a href="javascript:void(0)" class="text-muted mb-2"> - ({{ getPicById($row->pic_id) }})</a>
                                </div>
                                <div>
                                    <p>{{ $row->kegiatan }}</p>
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

                                @foreach($row->dataPendukung as $berkas)
                                <a href="{{ route('get.unduhBerkas', ['id' => $berkas->id, 'nik' => $data->getAnggota->nik]) }}"> {{ $berkas->nama_file }}</a> <br>
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
                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-kegiatan{{$data->id}}"><i class="bx bx-plus me-1"></i> Kegiatan</a>
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
                <div class="table-responsive">
                    <table class="table table-striped table-borderless border-bottom">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Kegiatan</th>
                                <th class="text-nowrap text-center">Uraian Kegiatan</th>
                                <th class="text-nowrap text-center">% Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data->agendaEsok as $val)
                            <tr>
                                <td class="text-nowrap">{{ $val->kegiatan }}</td>
                                <td class="text-nowrap">{{ $val->uraian_kegiatan }}</td>
                                <td class="text-nowrap">{{ $val->persentase }}%</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                            <input type="text" value="{{substr($harian->mulai,0,5)}}" maxlength="5" name="mulai" class="form-control" required>
                        </div>
                        <div class="col mb-2">
                            <label for="email">Selesai mengerjakan</label>
                            <input type="text" value="{{substr($harian->selesai,0,5)}}" maxlength="5" name="selesai" class="form-control" required>
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
                            <input type="text" name="jam_masuk" value="{{substr($data->jam_masuk, 0, 5)}}" class="form-control" required>
                        </div>
                        <div class="col mb-2">
                            <label for="email">Jam istirahat</label>
                            <input type="text" name="jam_istirahat" value="{{substr($data->jam_istirahat, 0, 5)}}" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3 g-2">
                        <div class="col mb-2">
                            <label for="kata-sandi">Jam kembali istirahat</label>
                            <input type="text" maxlength="5" name="jam_kembali_istirahat" value="{{substr($data->jam_kembali_istirahat, 0 ,5)}}" class="form-control">
                        </div>
                        <div class="col mb-2">
                            <label for="email">Jam pulang</label>
                            <input type="text" name="jam_pulang" maxlength="5" value="{{substr($data->jam_pulang,0,5)}}" class="form-control">
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

<script>
    $(document).ready(function() {
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
</script>



@endsection