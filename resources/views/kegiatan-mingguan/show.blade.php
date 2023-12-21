@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="fw-bold py-2 mb-2"><span class="text-muted fw-light">Kegiatan mingguan /</span> {{ $data->kegiatan }}</h4>
  <div class="row">
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-lg">
      <div class="card mb-4">
        <h5 class="card-header">Detail Kegiatan
          <a href="javascript:void(0)" onclick="history.back()" class="text-white btn btn-danger btn-sm float-end">
            <span class="tf-icons bx bx-back"></span>&nbsp; Tutup
          </a>
        </h5>
        <table class="table table-borderless">
          <tbody>
            <tr>
              <td class="align-center"><small class="text-light fw-semibold">Jenis Kegiatan</small></td>
              <td class="py-3">
                <p class="lead mb-0">
                  {{ ucfirst($data->jenis_kegiatan) }}
                </p>
              </td>
            </tr>
            <tr>
              <td class="align-middle"><small class="text-light fw-semibold">Kategori Kegiatan</small></td>
              <td class="py-3">
                <p class="lead mb-0">
                  {{ ucfirst($data->kategori_kegiatan) }}
                </p>
              </td>
            </tr>
            <tr>
              <td class="align-middle"><small class="text-light fw-semibold">Person in charge</small></td>
              <td class="py-3">
                <p class="lead mb-0">
                  {{ ucfirst(getPicById($data->pic_id)) }}
                </p>
              </td>
            </tr>
            <tr>
              <td class="align-middle"><small class="text-light fw-semibold">Kendala</small></td>
              <td class="py-4">
                <p class="lead mb-0">
                  {{ ucfirst($data->kendala) }}
                </p>
              </td>
            </tr>
            <tr>
              <td class="align-middle"><small class="text-light fw-semibold">Uraian Kegiatan</small></td>
              <td class="py-4">
                <p class="lead mb-0">
                  {{ ucfirst($data->uraian_kegiatan) }}
                </p>
              </td>
            </tr>
            <tr>
              <td class="align-middle"><small class="text-light fw-semibold">Kuantitas</small></td>
              <td class="py-4">
                <p class="lead mb-0">
                  {{ $data->kuantitas ?? '-' }}
                </p>
              </td>
            </tr>
            <tr>
              <td class="align-middle"><small class="text-light fw-semibold">Persen</small></td>
              <td class="py-4">
                <p class="lead mb-0">
                  {{ $data->persen != null ? $data->persen . '%' : '-'}}
                </p>
              </td>
            </tr>
            <tr>
              <td class="align-middle"><small class="text-light fw-semibold">Deadline</small></td>
              <td class="py-4">
                <p class="lead mb-0">
                  {{ getTanggalIndo($data->deadline) }}
                </p>
              </td>
            </tr>
            <tr>
              <td class="align-middle"><small class="text-light fw-semibold">Lampiran</small></td>
              <td class="py-4">
                <p class="lead mb-0">
                  @foreach($lampiran as $val)
                  <a href="{{ route('get.unduhBerkas', ['id' => $val->id, 'nik' => $data->nik]) }}"> {{ $val->nama_file }}</a> <br>
                  @endforeach
                </p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection