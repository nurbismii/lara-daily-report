@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-2 mb-2">Kegiatan harian</h4>
    <!-- Basic Bootstrap Table -->
    <div class="row mb-5">
        <div class="col-lg-12">
            @include('message')
        </div>
        <div class="col-md-6 col-lg-12">
            <div class="card text-center mb-2">
                <div class="card-body">
                    <h5 class="card-title">Kegiatan harian staff dan supervisor</h5>
                    <p class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    <a href="/kegiatan-harian/staff-dan-spv" class="btn btn-primary">Tambah kegiatan</a>
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
                                <th>#</th>
                                <th>Nama</th>
                                <th>Kehadiran</th>
                                <th>Status SPV</th>
                                <th>Status Asmen</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($data_kegiatan as $data)
                            <tr>
                                <th scope="row" data-bs-toggle="collapse" data-bs-target="#accordion-{{$data->id}}">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-secondary">
                                        <span class="tf-icons bx bx-show-alt"></span>
                                    </button>
                                </th>
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
                                    <span class="badge bg-label-success">Disetujui</span>
                                    @else
                                    <span class="badge bg-label-primary">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    @if($data->status_asmen != '')
                                    <span class="badge bg-label-success">Disetujui</span>
                                    @else
                                    <span class="badge bg-label-primary">Menunggu</span>
                                    @endif
                                </td>
                                <td>{{ getTanggalIndo($data->tanggal) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-tambah-kegiatan{{$data->id}}"><i class="bx bx-plus me-1"></i> Kegiatan</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-edit-absensi{{$data->id}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-hapus-semua{{$data->id}}"><i class="bx bx-trash me-1"></i> Hapus</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="collapse accordion-collapse" id="accordion-{{$data->id}}" data-bs-parent=".table">
                                <td colspan="12">
                                    <table class="table table-condensed table-striped" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kegiatan</th>
                                                <th>Jenis Kegiatan</th>
                                                <th>Kategori kegiatan</th>
                                                <th>PIC</th>
                                                <th>Jam </th>
                                                <th>Selesai</th>
                                                <th>Status kegiatan</th>
                                                <th>Status akhir</th>
                                                <th>Deadline</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data->kegiatanHarian as $key => $row)
                                            <tr>
                                                <td>{{ $key += 1; }}</td>
                                                <td>{{ $row->kegiatan ?? '' }}</td>
                                                <td>{{ getJenisKegiatanById($row->jenis_kegiatan_id) ?? '' }}</a></td>
                                                <td>{{ getKategoriKegiatanById($row->kategori_kegiatan_id) ?? '' }}</td>
                                                <td>{{ getPicById($row->pic_id) ?? '' }}</td>
                                                <td>{{ $row->mulai ?? '' }}</td>
                                                <td>{{ $row->selesai ?? '' }}</td>
                                                <td>{{ ucfirst($row->status_kegiatan) ?? '' }}</td>
                                                <td>{{ ucfirst($row->status_akhir) ?? '' }}</td>
                                                <td>{{ getTanggalIndo($row->deadline) ?? '' }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-edit-kegiatan{{$row->id}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-unggah-berkas{{$row->id}}"><i class="bx bx-plus me-1"></i> Data pendukung </a>
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-hapus-kegiatan{{$row->id}}"><i class="bx bx-trash me-1"></i> Hapus</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                            <label for="nik">Kegiatan</label>
                            <textarea class="form-control" name="kegiatan" id="" cols="30" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="email">Jenis Kegiatan</label>
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
                            <label for="email">PIC</label>
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
                            <label for="nama">Mulai mengerjakan</label>
                            <input type="text" maxlength="5" name="mulai" class="form-control" required>
                        </div>
                        <div class="col mb-2">
                            <label for="email">Selesai mengerjakan</label>
                            <input type="text" maxlength="5" name="selesai" class="form-control" required>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="nama">Status Kegiatan</label>
                            <select name="status_kegiatan" class="form-select" required>
                                <option value="" disabled selected>-- Pilih status kegiatan --</option>
                                <option value="selesai">Selesai</option>
                                <option value="tidak selesai">Tidak selesai</option>
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="email">Deadline penyelesaian</label>
                            <input type="date" name="deadline" class="form-control">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="nama">Status akhir</label>
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
        <form action="{{route('destroy.kegiatanharian', $data->id)}}" method="post" class="modal-content">
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

@endsection