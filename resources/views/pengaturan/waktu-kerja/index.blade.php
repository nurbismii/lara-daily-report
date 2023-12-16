@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <h4 class="fw-bold py-2 mb-2"><span class="text-muted fw-light">Pengaturan /</span> Waktu kerja</h4>
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-header">Tabel waktu kerja
          <a href="/pengaturan/waktu-kerja/create" class="text-white btn btn-primary btn-sm float-end">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Waktu kerja
          </a>
        </h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Waktu kerja</th>
                <th>Kategori</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach($waktu_kerja as $data)
              <tr>
                <td>{{++$no}}</td>
                <td>{{$data->waktu_kerja}}</td>

                <td>
                  @foreach($data->kategori_waktu_kerja as $kategori)
                  {{$kategori->kategori_waktu_kerja}}, <br>
                  @endforeach
                </td>

                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-horizontal-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{route('create.kategoriwaktukerja', $data->id)}}"><i class="bx bx-plus me-1"></i> Kategori</a>
                      <a class="dropdown-item" href="{{route('edit.waktukerja', $data->id)}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                      <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalDeleteWaktukerja{{$data->id}}"><i class="bx bx-trash me-1"></i> Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@foreach($waktu_kerja as $data)
<div class="modal modal-top fade" id="modalDeleteWaktukerja{{$data->id}}" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{route('delete.waktukerja', $data->id)}}" method="post" class="modal-content">
      @csrf
      {{method_field('delete')}}
      <div class="modal-header">
        <h5 class="modal-title" id="modalTopTitle">Konfirmasi permintaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Kamu yakin ingin menghapus waktu kerja [ {{ $data->waktu_kerja }} ] ?
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