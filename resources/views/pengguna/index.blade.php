@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-2 mb-2">Pengguna</h4>
  <div class="row">
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-header">Tabel pengguna
          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-tambah-pengguna" class="text-white btn btn-primary btn-sm float-end">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Pengguna
          </a>
        </h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>Pengguna</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach($pengguna as $data)
              <tr>
                <td>
                  <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                      @if($data->foto != '1.png')
                      <img src="{{  asset('foto-profil/' . $data->nik . '/' . $data->foto ) }}" alt class="w-px-40 h-auto rounded-circle" />
                      @else
                      <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                      @endif
                    </div>
                  </div>
                </td>
                <td>
                  {{ $data->name }} <br>
                  <small class="text-muted"> {{ $data->nik }} </small>
                </td>
                <td>{{ $data->email }}</td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-horizontal-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalEditPengguna{{$data->id}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                      <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalHapusPengguna{{$data->id}}"><i class="bx bx-trash me-1"></i> Hapus</a>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-end mt-2 mx-3">
            {!! $pengguna->links() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-tambah-pengguna" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Form pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('store.pengguna')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nik">Nomor Induk Karyawan</label>
              <input type="text" name="nik" class="form-control" required />
            </div>
          </div>
          <div class="row mb-3 g-2">
            <div class="col mb-2">
              <label for="nama">Nama</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col mb-2">
              <label for="email">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
          </div>
          <div class="row mb-3 g-2">
            <div class="col mb-2">
              <label for="jabatan">Jabatan</label>
              <input type="text" name="jabatan" class="form-control" required>
            </div>
            <div class="col mb-2">
              <label for="posisi">Posisi</label>
              <input type="email" name="posisi" class="form-control" required>
            </div>
          </div>
          <div class="row mb-3 g-2">
            <div class="col mb-2">
              <label for="kata-sandi">Kata sandi</label>
              <input type="password" name="kata_sandi" class="form-control" required>
            </div>
            <div class="col mb-2">
              <label for="konfirmasi-sandi">Ulangi kata sandi</label>
              <input type="password" name="konfirmasi_sandi" class="form-control" required>
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

@foreach($pengguna as $data)
<div class="modal fade" id="modalEditPengguna{{$data->id}}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Form edit pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('update.pengguna', $data->id)}}" method="post">
        @csrf
        {{method_field('patch')}}
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nik">Nomor Induk Karyawan</label>
              <input type="text" name="nik" value="{{$data->nik}}" class="form-control" />
            </div>
          </div>
          <div class="row mb-3 g-2">
            <div class="col mb-2">
              <label for="nama">Nama</label>
              <input type="text" name="name" value="{{$data->name}}" class="form-control">
            </div>
            <div class="col mb-2">
              <label for="email">Email</label>
              <input type="email" name="email" value="{{$data->email}}" class="form-control">
            </div>
          </div>
          <div class="row mb-3 g-2">
            <div class="col mb-2">
              <label for="nama">Jabatan</label>
              <input type="text" name="jabatan" value="{{$data->jabatan}}" class="form-control">
            </div>
            <div class="col mb-2">
              <label for="email">Posisi</label>
              <input type="text" name="posisi" value="{{$data->posisi}}" class="form-control">
            </div>
          </div>
          <div class="row mb-3 g-2">
            <div class="col mb-2">
              <label for="kata-sandi">Kata sandi</label>
              <input type="password" name="kata_sandi" class="form-control">
            </div>
            <div class="col mb-2">
              <label for="email">Ulangi kata sandi</label>
              <input type="password" name="konfirmasi_sandi" class="form-control">
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

@foreach($pengguna as $data)
<div class="modal modal-top fade" id="modalHapusPengguna{{$data->id}}" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{route('delete.pengguna', $data->id)}}" method="post" class="modal-content">
      @csrf
      {{method_field('delete')}}
      <div class="modal-header">
        <h5 class="modal-title" id="modalTopTitle">Konfirmasi permintaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Kamu yakin ingin menghapus pengguna ini [ {{$data->name}} ]
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