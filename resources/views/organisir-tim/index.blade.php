@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <h4 class="fw-bold py-2 mb-2">Organisir Tim</h4>
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-header">Tabel tim
          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-tambah-tim" class="text-white btn btn-primary btn-sm float-end">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Tim
          </a>
        </h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>Tim</th>
                <th>Asmen</th>
                <th>SPV</th>
                <th>Anggota</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @php
              $no = 1;
              @endphp
              @foreach($organisir_tim as $data)
              <tr>
                <td>{{ $data->nama_tim }}</td>
                <td>{{ $data->getKetua->name }}</td>
                <td>{{ $data->getSpv->name }}</td>
                <td>
                  @foreach($data->anggotaTim as $anggota)
                  - {{$anggota->getAnggota->name}} <br>
                  @endforeach
                </td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-horizontal-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalTambahAnggotaTim{{$data->id}}"><i class="bx bx-plus me-1"></i> Anggota</a>
                      <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalEditTim{{$data->id}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                      <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalHapusTim{{$data->id}}"><i class="bx bx-trash me-1"></i> Hapus</a>
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

<!-- Modal tambah tim -->

<div class="modal fade" id="modal-tambah-tim" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Form tim</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('store.organisir')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nik">Nama tim</label>
              <input type="text" name="nama_tim" class="form-control" required />
            </div>
          </div>
          <div class="row mb-3 g-2">
            <div class="col mb-2">
              <label for="ketua-tim">Asisten Manager</label>
              <select name="ketua_tim_id" class="form-select" required>
                <option value="" selected>-- Pilih ketua tim --</option>
                @foreach($pengguna as $row)
                <option value="{{ $row->id }}">{{$row->name}} | {{$row->nik}}</option>
                @endforeach
                <option value="1101">Tidak ada asisten manager</option>
              </select>
            </div>
            <div class="col mb-2">
              <label for="spv">Supervisor (SPV)</label>
              <select name="supervisor_id" class="form-select" required>
                <option value="" selected>-- Pilih supervisor --</option>
                @foreach($pengguna as $row)
                <option value="{{ $row->id }}">{{$row->name}} | {{$row->nik}}</option>
                @endforeach
                <option value="1101">Tidak ada supervisor</option>
              </select>
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

<!-- Modal tambah tim end -->

<!-- Modal tambah anggota tim -->
@foreach($organisir_tim as $data)
<div class="modal fade" id="modalTambahAnggotaTim{{$data->id}}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Form anggota tim</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('store.anggotatim')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <input type="hidden" class="form-control" name="tim_id" value="{{$data->id}}">
              <label for="spv">Anggota Tim</label>
              <select name="user_id" class="form-select" required>
                <option value="" selected>-- Pilih anggota tim --</option>
                @foreach($pengguna as $row)
                <option value="{{ $row->id }}">{{$row->name}} | {{$row->nik}}</option>
                @endforeach
              </select>
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
<!-- Modal tambah anggota tim end -->

<!-- Modal edit anggota tim -->
@foreach($organisir_tim as $data)
<div class="modal fade" id="modalEditTim{{$data->id}}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Form edit tim</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form action="{{route('update.organisir', $data->id)}}" method="post">
            <input type="hidden" name="tipe" value="asisten">
            <div class="mb-3 mt-3 row">
              <label for="html5-text-input" class="col-md-2 col-form-label">Asisten Manager</label>
              <div class="col-md-10">
                <div class="input-group">
                  <select name="ketua_tim_id" class="form-select">
                    <option value="{{$data->ketua_tim_id}}">{{$data->getKetua->name}}</option>
                    @foreach($pengguna as $row)
                    @if($row->id != $data->ketua_tim_id ?? '')
                    <option value="{{$row->id}}">{{$row->name}}</option>
                    @endif
                    @endforeach
                  </select>
                  <button class="btn btn-outline-primary" type="submit">Simpan perubahan</button>
                </div>
              </div>
            </div>
          </form>
          <div class="dropdown-divider"></div>
          <form action="{{route('update.organisir', $data->id)}}" method="post">
            <input type="hidden" name="tipe" value="spv">
            <div class="mb-3 mt-3 row">
              <label for="html5-text-input" class="col-md-2 col-form-label">Supervisor</label>
              <div class="col-md-10">
                <div class="input-group">
                  <select name="supervisor_id" class="form-select">
                    <option value="{{$data->supervisor_id}}">{{$data->getSpv->name}}</option>
                    @foreach($pengguna as $row)
                    @if($row->id != $data->supervisor_id)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                    @endif
                    @endforeach
                  </select>
                  <button class="btn btn-outline-primary" type="submit">Simpan perubahan</button>
                </div>
              </div>
            </div>
          </form>
          <div class="dropdown-divider"></div>
          <div class="col-md-12">
            @php
            $no = 1;
            @endphp
            @foreach($data->anggotaTim as $anggota)
            <form action="{{route('update.anggotatim', $anggota->id)}}" method="post">
              @csrf
              {{method_field('patch')}}
              <div class="mb-3 mt-3 row">
                <label for="html5-text-input" class="col-md-2 col-form-label">Anggota tim {{$no++}}</label>
                <div class="col-md-10">
                  <div class="input-group">
                    <select name="user_id" class="form-select">
                      <option value="{{$anggota->user_id}}">{{$anggota->getAnggota->name}}</option>
                      @foreach($pengguna as $row)
                      @if($row->id != $anggota->user_id)
                      <option value="{{$row->id}}">{{$row->name}}</option>
                      @endif
                      @endforeach
                    </select>
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Opsi
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li><button type="submit" class="dropdown-item">Simpan perubahan</button></li>
                      <li><a class="dropdown-item" href="{{route('delete.anggotatim', $anggota->id)}}" onclick="return confirm('Kamu yakin ingin anggota tim ini [ {{$anggota->getAnggota->name}} ]')">Hapus anggota</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </form>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach
<!-- Modal edit anggota tim -->

@foreach($organisir_tim as $data)
<div class="modal modal-top fade" id="modalHapusTim{{$data->id}}" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{route('delete.organisir', $data->id)}}" method="post" class="modal-content">
      @csrf
      {{method_field('delete')}}
      <div class="modal-header">
        <h5 class="modal-title" id="modalTopTitle">Konfirmasi permintaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Kamu yakin ingin menghapus tim ini [ {{$data->nama_tim}} ] ?
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