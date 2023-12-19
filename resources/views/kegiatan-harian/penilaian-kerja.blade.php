@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <h4 class="fw-bold py-2 mb-2"><span class="text-muted fw-light">Kegiatan harian /</span> penilaian kerja harian</h4>
    <div class="col-xl-12">
      @include('message')
    </div>
    <div class="col-md-12">
      <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
          <a class="nav-link {{ Request::segment(2) == 'detail' && Request::segment(3) == $data->id ? 'active' : ''}}" href="{{ route('kegiatan-harian.show', $data->id) }}"><i class="bx bxs-report me-1"></i>Laporan kerja harian </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::segment(2) == 'detail' && Request::segment(3) == 'penilaian' ? 'active' : ''}}" href="{{ route('kegiatan-harian.show.penilaian', $data->id) }}"><i class="bx bx-stats me-1"></i> Penilaian kerja harian</a>
        </li>
      </ul>
    </div>
    <div class="col-md-3 col-lg-8">
      <div class="card mb-2">
        <h5 class="card-header">Penilaian Kerja Harian SPV</h5>
        <div class="card-body">
          @foreach($penilaian as $row)
          <div class="row g-2">
            <div class="col mb-2">
              <label for="nama">{{ $row->jenis_penilaian }}</label>
              <input type="text" name="nilai_spv[]" value="{{ $row->nilai_spv }}" class="form-control" required>
            </div>
            <div class="col mb-2">
              <label for="email">Catatan {{ $row->jenis_penilaian }}</label>
              <input type="text" name="catatan_spv[]" value="{{ $row->catatan_spv }}" class="form-control">
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="row">
        <div class="card mb-3">
          <h5 class="card-header">Penilaian kerja harian</h5>
          <div class="card-body">
            <div class="d-grid gap-2 col-lg-12 mx-auto">
              <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-penilaian-spv{{$data->id}}" class="btn btn-primary">Penilaian SPV</a>
              <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-penilaian-asmen{{$data->id}}" class="btn btn-primary">Penilaian Asmen</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-lg-8">
      <div class="card mb-2">
        <h5 class="card-header">Penilaian Kerja Harian Asmen</h5>
        <div class="card-body">
          @foreach($penilaian as $row)
          <div class="row g-2">
            <div class="col mb-2">
              <label for="nama">{{ $row->jenis_penilaian }}</label>
              <input type="text" name="nilai_asmen[]" value="{{ $row->nilai_asmen }}" class="form-control" required>
            </div>
            <div class="col mb-2">
              <label for="email">Catatan {{ $row->jenis_penilaian }}</label>
              <input type="text" name="catatan_asmen[]" value="{{ $row->catatan_asmen }}" class="form-control">
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-penilaian-spv{{$data->id}}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Penilaian kerja harian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('store.penilaian-kerja')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Kedisiplinan</label>
            <input type="hidden" name="absensi_id" class="form-control" value="{{$data->id}}">
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Kedisiplinan">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Kerapian</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Kerapian">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Tanggung jawab</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Tanggung jawab">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Ketekunan</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Ketekunan">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Detail, akurasi & ketelitian</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Detail, akurasi & ketelitian">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Kecakapan & keterampilan</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Kecakapan & keterampilan">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Kesungguhan</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Kesungguhan">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Koordinasi & kerja tim</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Koordinasi & kerja tim">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Inonvasi & kerja tim</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Inonvasi & kerja tim">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Inisiatif</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Inisiatif">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Motivasi dan antusiasme kerja</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Motivasi dan antusiasme kerja">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Produktifitas</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Produktifitas">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Efektifitas</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Efektifitas">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Perencanaan kerja</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Perencanaan kerja">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Ketepatan kerja</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Ketepatan kerja">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Hasil kerja</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Hasil kerja">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Pemanfaatan waktu luang</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Pemanfaatan waktu luang">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Performa kerja</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Performa kerja">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">Supervisi</label>
            <input type="hidden" name="jenis_penilaian[]" class="form-control" value="Supervisi">
            <div class="col-md-4 mb-2">
              <select name="nilai_spv[]" class="form-select" required>
                <option value="" selected>-- Nilai SVP --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <textarea name="catatan_spv[]" class="form-control" placeholder="Catatan SPV" id="" cols="30" rows="1"></textarea>
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

<div class="modal fade" id="modal-penilaian-asmen{{$data->id}}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Penilaian kerja harian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('update.penilaian-kerja')}}" method="post">
        @csrf
        <div class="modal-body">
          @forelse($data_penilaian as $val)
          <div class="row g-2 mb-2">
            <label for="html5-text-input" class="col-md-2 col-form-label">{{$val->jenis_penilaian}}</label>
            <input type="hidden" name="penilaian_id[]" class="form-control" value="{{$val->id}}">
            <div class="col-md-1 mb-2">
              <input type="text" class="form-control" value="{{$val->nilai_spv}}" readonly>
            </div>
            <div class="col-md-3 mb-2">
              <input type="text" class="form-control" value="{{$val->catatan_spv}}" readonly>
            </div>
            <div class="col-md-2 mb-2">
              <select name="nilai_asmen[]" class="form-select" required>
                <option value="" selected>-- Penilaian Asmen --</option>
                <option value="A+">Istimewa | A+</option>
                <option value="A">Sangat baik | A</option>
                <option value="A-">Baik | A-</option>
                <option value="B+">Cukup baik | B+</option>
                <option value="B">Cukup | B</option>
                <option value="B-">Hampir cukup | B-</option>
                <option value="C+">Kurang | C+</option>
                <option value="C">Sangat kurang | C</option>
                <option value="C-">Tidak memuaskan | C-</option>
              </select>
            </div>
            <div class="col-md-4 mb-2">
              <textarea name="catatan_asmen[]" class="form-control" placeholder="Catatan Asmen" id="" cols="30" rows="1"></textarea>
            </div>
          </div>
          <div class="divider text-end">
            <div class="divider-text">
              <i class="bx bx-cut bx-rotate-180"></i>
            </div>
          </div>
          @empty
          Penilaian supervisor belum tersedia, penilaian belum bisa dilanjutkan
          @endforelse
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

@endsection