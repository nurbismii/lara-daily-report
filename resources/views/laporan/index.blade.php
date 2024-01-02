@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <h4 class="fw-bold py-2 mb-2">Laporan</h4>
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-xl-12">
      <div class="card mb-3">
        <div class="card-body">
          <form action="/kegiatan-mingguan/laporan-bulanan" method="get">
            <div class="row g-2 mb-2">
              <label for="html5-text-input" class="col-md-4 col-form-label">Periode kegiatan harian</label>
              <div class="col-md-4 mb-2">
                <input type="date" name="tgl_awal" value="{{ $tgl_awal ?? '' }}" class="form-control" required>
              </div>
              <div class="col-md-4 mb-2">
                <input type="date" name="tgl_akhir" value="{{ $tgl_akhir ?? '' }}" class="form-control" required>
              </div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary float-end  mx-2">Cari kegiatan</button>
            <a href="/kegiatan-mingguan/laporan-bulanan" class="btn btn-sm btn-danger float-end">Hapus filter</a>
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

        @if(count($datas) > 0)
        <div class="col-lg-12">
          <div class="card">
            <h5 class="card-header">Hasil pencarian
              <a class="btn btn-secondary float-end btn-sm" href="javascript:void(0);"><i class="bx bxs-report me-1"></i>PDF</a>
            </h5>
            <div class="table-responsive text-nowrap">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kegiatan</th>
                    <th>Jenis Kegiatan</th>
                    <th>Kategori</th>
                    <th>Persentase</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  @foreach($datas as $key => $data)
                  <tr>
                    <th>{{ ++$key }}</th>
                    <td>{{ substr($data->kegiatan,0,30) }} ...</td>
                    <td>{{ getJenisKegiatanById($data->jenis_kegiatan_id) }}</td>
                    <td>{{ getKategoriKegiatanById($data->kategori_kegiatan_id) }}</td>
                    <td>{{ $data->persen }}</td>
                    <td>
                      <a class="btn btn-primary btn-sm" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-laporan-detail{{$data->id}}"><i class="bx bx-show-alt me-1"></i>Lihat</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="d-flex justify-content-end mt-2 mx-3">
                {!! $datas->links() !!}
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Detail laporan -->
@foreach($datas as $data)
<div class="modal fade" id="modal-laporan-detail{{$data->id}}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Detail laporan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
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
            <input type="number" name="persen" class="form-control">
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
            <input type="date" value="{{ $data->deadline }}" class="form-control" readonly>
          </div>
          <div class="col-md-6 mb-2">
            <label for="lampiran">Lampiran</label>
            <input type="file" name="lampiran" class="form-control">
            @foreach($data->dataPendukung as $berkas)
            <small><a href="{{ route('get.unduhBerkas', ['id' => $berkas->id, 'nik' => $data->nik]) }}"> {{ $berkas->nama_file }}</a> <br></small>
            @endforeach
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Tutup
        </button>
      </div>
    </div>
  </div>
</div>
@endforeach
<!-- Detail laporan ends -->


@endsection