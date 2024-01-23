@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <h4 class="fw-bold py-2 mb-2">Kegiatan mingguan</h4>
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-xl-12">
      <div class="card mb-3">
        <div class="card-body">
          <form action="/kegiatan-mingguan/create" method="get">
            <div class="row g-2 mb-2">
              <label for="html5-text-input" class="col-md-4 col-form-label">Periode kegiatan harian</label>
              <div class="col-md-4 mb-2">
                <input type="date" name="tgl_awal" value="{{ $tgl_awal ?? '' }}" class="form-control" required>
              </div>
              <div class="col-md-4 mb-2">
                <input type="date" name="tgl_akhir" value="{{ $tgl_akhir ?? '' }}" class="form-control" required>
              </div>
            </div>
            <div class="row g-2 mb-2">
              <label for="html5-text-input" class="col-md-4 col-form-label">Tipe laporan</label>
              <div class="col-md-8 mb-2">
                <select name="tipe" class="form-select" required>
                  @if($tipe == null)
                  <option value="1">Harian</option>
                  <option value="2">Mingguan</option>
                  @endif
                  @if($tipe == '1')
                  <option value="{{$tipe ?? ''}}" selected>Harian</option>
                  <option value="2">Mingguan</option>
                  @endif
                  @if($tipe == '2')
                  <option value="{{$tipe ?? ''}}" selected>Mingguan</option>
                  <option value="1">Harian</option>
                  @endif
                </select>
                <small><i><sup style="color: red;">* </sup>Tipe laporan : Harian = Membuat laporan mingguan</i></small> </br>
                <small><i><sup style="color: red;">* </sup>Tipe laporan : Mingguan = Memperbarui/update isi data laporan mingguan</i></small>
              </div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary float-end  mx-2">Cari kegiatan</button>
            @if($tipe != '' && $tipe == '2')
            <a target="_blank" href="{{ route('cetakPdf', ['tgl_awal' => $tgl_awal, 'tgl_akhir' => $tgl_akhir, 'tipe' => $tipe]) }}" class="btn btn-sm btn-primary float-end  mx-2">Cetak</a>
            @endif
            <a href="/kegiatan-mingguan/create" class="btn btn-sm btn-danger float-end">Hapus filter</a>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <!-- Segmented buttons -->
      <div class="row">

        @if($tgl_awal != '' && $datas->count() > 0)
        <div class="col-md-12 text-center">
          <div class="alert alert-primary" role="alert">
            Periode kegiatan harian <br>
            {{ getTanggalIndo($tgl_awal) }} - {{ getTanggalIndo($tgl_akhir) }}
          </div>
        </div>
        @else
        <div class="col-md-12 text-center">
          <div class="alert alert-danger" role="alert">
            Oppss!! permintaan kamu tidak ditemukan ...
          </div>
        </div>
        @endif

        @foreach($datas as $no => $data)
        <div class="accordion mt-2" id="accordionExample">
          <div class="card accordion-item">
            <h2 class="accordion-header" id="heading-{{$data->id}}">
              <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-{{$data->id}}" aria-expanded="false" aria-controls="accordion-{{$data->id}}">
                {{ ++$no }}. {{ $data->kegiatan }}
              </button>
            </h2>
            <div id="accordion-{{$data->id}}" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
              <div class="accordion-body">
                <form action="{{ route('update.kegiatanMingguan', $data->id) }}" enctype="multipart/form-data" method="post">
                  @csrf
                  <div class="row">
                    <div class="col-md-12 mb-2">
                      <label for="uraian_kegiatan">Kegiatan</label>
                      <textarea name="kegiatan" class="form-control" cols="30" rows="3">{{ $data->kegiatan }}</textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 mb-2">
                      <label for="uraian_kegiatan">Jenis kegiatan</label>
                      <input name="jenis_kegiatan_id" class="form-control" value="{{ getJenisKegiatanById($data->jenis_kegiatan_id) }}" readonly>
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col-md-6 mb-2">
                      <label for="kategori_kegiatan">Kategori Kegiatan</label>
                      <input type="text" value="{{ getKategoriKegiatanById($data->kategori_kegiatan_id) }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-2">
                      <label for="persentase">Persentase penyelesaian pekerjaan</label>
                      <input type="number" name="persen" max="100" maxlength="3" value="{{ $data->persen }}" class="form-control" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 mb-2">
                      <label for="uraian_kegiatan">Uraian kegiatan</label>
                      <textarea name="uraian_kegiatan" class="form-control" cols="30" rows="3">{{ $data->uraian_kegiatan }}</textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 mb-2">
                      <label for="kendala_kerja">Kendala kerja</label>
                      <textarea name="kendala" class="form-control" cols="30" rows="3">{{ $data->kendala }}</textarea>
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col-md-6 mb-2">
                      <label for="deadline">Deadline penyelesaian</label>
                      <input type="text" value="{{ getTanggalIndo($data->deadline) }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-2">
                      <label for="lampiran">Lampiran</label>
                      <input type="file" name="lampiran" class="form-control">
                      @foreach($data->dataPendukung as $berkas)
                      <small><a href="{{ route('get.unduhBerkas', ['id' => $berkas->id, 'nik' => $data->nik]) }}"> {{ $berkas->nama_file }}</a> <br></small>
                      @endforeach
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary float-end mt-1 mb-3">Kirim</button>
                  @if($tipe == '1')
                  <a href="{{ route('update.duplikat', $data->id) }}" class="btn btn-secondary float-end mt-1 mx-2 mb-3" onclick="confirm('Kamu yakin ingin menghapus kegiatan harian ini ?'); document.getElementById('update-form').submit();">Hapus</a>
                  @endif
                  @if($tipe == '2')
                  <a href="{{ route('update.hapus.duplikat', $data->id) }}" class="btn btn-danger float-end mt-1 mx-2 mb-3" onclick="confirm('Kamu yakin ingin mengembalikan kegiatan mingguan ini ?'); document.getElementById('kembali-harian').submit();">Kembali ke harian</a>
                  @endif
                </form>

                <form id="update-form" action="{{ route('update.duplikat', $data->id) }}" method="POST">
                  @csrf
                </form>

                <form id="kembali-harian" action="{{ route('update.hapus.duplikat', $data->id) }}" method="POST">
                  @csrf
                </form>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection