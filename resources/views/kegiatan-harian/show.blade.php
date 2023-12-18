@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <h4 class="fw-bold py-2 mb-2">Kegiatan harian</h4>
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-md-12">
      <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
          <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>Laporan kerja harian </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="bx bx-bell me-1"></i> Penilaian kerja harian</a>
        </li>
      </ul>
    </div>
    <div class="col-md-8">

      <div class="card mb-3">
        <h5 class="card-header">Tabel kehadiran</h5>
        <div class="card-body">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="firstName" class="form-label">Nama</label>
              <input class="form-control" type="text" name="name" value="{{ $data->getAnggota->name }}" readonly>
            </div>
            <div class="mb-3 col-md-6">
              <label for="lastName" class="form-label">NIK</label>
              <input class="form-control" type="text" name="nik" value="{{ $data->getAnggota->nik}}" readonly>
            </div>
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">Masuk</label>
              <input class="form-control" type="text" value="{{ $data->jam_masuk }}" readonly>
            </div>
            <div class="mb-3 col-md-6">
              <label for="organization" class="form-label">Istirahat</label>
              <input type="text" class="form-control" name="organization" value="{{ $data->jam_istirahat }}" readonly>
            </div>
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">Kembali istirahat</label>
              <input class="form-control" type="text" value="{{ $data->jam_kembali_istirahat }}" readonly>
            </div>
            <div class="mb-3 col-md-6">
              <label for="organization" class="form-label">Pulang</label>
              <input type="text" class="form-control" name="organization" value="{{ $data->jam_pulang }}" readonly>
            </div>
            <div class="mb-3 col-md-12">
              <label for="organization" class="form-label">Tanggal</label>
              <input type="text" class="form-control" name="organization" value="{{ getTanggalIndo($data->tanggal) }}" readonly>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="row">
        <div class="card mb-3">
          <h5 class="card-header">Persetujuan SPV dan Asmen</h5>
          <form action="{{route('update.statusKegiatan', $data->id)}}" method="post">
            @csrf
            {{method_field('patch')}}
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <label for="firstName" class="form-label">Status laporan kegiatan</label>
                  <select name="" class="form-select" id="" required>
                    <option value="" selected disabled>- Pilih status laporan -</option>
                    <option value="">Disetujui</option>
                    <option value="">Tidak disetujui</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
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
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-header">Tabel kegiatan</h5>
        <div class="table-responsive text-nowrap">
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
              </tr>
            </thead>
            <tbody>
              @foreach($data_kegiatan as $row)
              <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $row->kegiatan ?? '' }}</td>
                <td>{{ getJenisKegiatanById($row->jenis_kegiatan_id) ?? '' }}</a></td>
                <td>{{ getKategoriKegiatanById($row->kategori_kegiatan_id) ?? '' }}</td>
                <td>{{ getPicById($row->pic_id) ?? '' }}</td>
                <td>{{ $row->mulai ?? '' }}</td>
                <td>{{ $row->selesai ?? '' }}</td>
                <td>
                  @if(strtolower($row->status_kegiatan) == 'selesai')
                  <span class="badge bg-label-success">Selesai</span>
                  @else
                  <span class="badge bg-label-warning">Tidak selesai</span>
                  @endif
                </td>
                <td>
                  @if(strtolower($row->status_akhir) == 'sesuai')
                  <span class="badge bg-label-success">Sesuai</span>
                  @else
                  <span class="badge bg-label-warning">Tidak sesuai</span>
                  @endif
                </td>
                <td>{{ getTanggalIndo($row->deadline) ?? '' }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
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

@endsection