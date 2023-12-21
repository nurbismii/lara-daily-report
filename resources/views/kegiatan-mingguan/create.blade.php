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
                <input type="date" name="tgl_awal" class="form-control" required>
              </div>
              <div class="col-md-4 mb-2">
                <input type="date" name="tgl_akhir" class="form-control" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary float-end  mx-2">Cari kegiatan</button>
            <a href="/kegiatan-mingguan/create" class="btn btn-danger float-end">Hapus filter</a>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <!-- Segmented buttons -->
      <div class="row">
        
        @if($tgl_awal)
        <div class="col-md-12 text-center">
          <div class="alert alert-primary" role="alert">
            Periode kegiatan harian <br>
            {{ getTanggalIndo($tgl_awal) }} - {{ getTanggalIndo($tgl_akhir) }}
          </div>
        </div>
        @endif

        @foreach($datas as $data)
        @foreach($data->kegiatanHarian as $row)
        @if($row->uraian_kegiatan == 'NULL')
        <div class="col-md-3 col-lg-12">
          <div class="card mb-3">
            <div class="card-body">
              <form action="{{ route('update.kegiatanMingguan', $row->id) }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row g-2">
                  <div class="col-md-6 mb-2">
                    <label for="nama">Kegiatan</label>
                    <input type="text" name="kegiatan" value="{{ $row->kegiatan }}" class="form-control" readonly>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="jenis_kegiatan">Jenis Kegiatan</label>
                    <input type="text" value="{{ getJenisKegiatanById($row->jenis_kegiatan_id) }}" class="form-control" readonly>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-2">
                    <label for="kategori_kegiatan">Kategori Kegiatan</label>
                    <input type="text" value="{{ getKategoriKegiatanById($row->kategori_kegiatan_id) }}" class="form-control" readonly>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="persentase">Persentase penyelesaian pekerjaan</label>
                    <input type="number" name="persen" value="{{ getKategoriKegiatanById($row->kategori_kegiatan_id) }}" class="form-control">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 mb-2">
                    <label for="uraian_kegiatan">Uraian kegiatan</label>
                    <textarea name="uraian_kegiatan" class="form-control" cols="30" rows="3">{{ $row->uraian_kegiatan }}</textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 mb-2">
                    <label for="kendala_kerja">Kendala kerja</label>
                    <textarea name="kendala" class="form-control" cols="30" rows="3">{{ $row->kendala }}</textarea>
                  </div>
                </div>
                <div class="row g-2">
                  <div class="col-md-6 mb-2">
                    <label for="deadline">Deadline penyelesaian</label>
                    <input type="date" value="{{ $row->deadline }}" class="form-control" readonly>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="lampiran">Lampiran</label>
                    <input type="file" name="lampiran" class="form-control">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary float-end mt-1">Kirim</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endif
      @endforeach
      @endforeach
    </div>
  </div>

  @endsection