@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form action="{{route('staff.store')}}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                @include('message')
            </div>
            <div class="col-md-3 col-lg-12">
                <div class="card mb-3">
                    <h5 class="card-header">Form kerja harian
                        <a href="/kegiatan-harian/create" class="text-white btn btn-danger btn-sm float-end">
                            <span class="tf-icons bx bx-back"></span>&nbsp; Tutup
                        </a>
                    </h5>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" value="{{ Auth::user()->name }}" class="form-control" required readonly>
                            </div>
                            <div class="col mb-2">
                                <label for="email">NIK</label>
                                <input type="text" name="nik" value="{{ Auth::user()->nik }}" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="kendala">Posisi</label>
                                <input type="text" name="posisi" value="{{ Auth::user()->posisi }}" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="kendala">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="nama">Jam masuk kerja</label>
                                <input type="text" id="jamMasuk" maxlength="5" name="jam_masuk_kerja" class="form-control" required>
                            </div>
                            <div class="col mb-2">
                                <label for="email">Jam istirahat</label>
                                <input type="text" id="jamIstirahat" maxlength="5" name="jam_istirahat" class="form-control">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="kata-sandi">Jam kembali istirahat</label>
                                <input type="text" id="jamKembaliIstirahat" maxlength="5" name="jam_kembali_istirahat" class="form-control">
                            </div>
                            <div class="col mb-2">
                                <label for="email">Jam pulang kerja</label>
                                <input type="text" id="jamPulang" maxlength="5" name="jam_pulang_kerja" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-body control-group after-add-more">
                        <div class="row">
                            <div class="col mb-2">
                                <label for="kata-sandi">Kegiatan</label>
                                <textarea name="kegiatan[]" class="form-control" id="" cols="30" rows="5" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="email">Jenis Kegiatan</label>
                                <select name="jenis_kegiatan_id[]" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih jenis kegiatan --</option>
                                    @foreach($jenis_kegiatan as $row)
                                    <option value="{{$row->id}}">{{$row->jenis_kegiatan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="kata-sandi">Kategori kegiatan</label>
                                <select name="kategori_kegiatan_id[]" class="form-select" id="" required>
                                    <option value="" disabled selected>-- Pilih kategori kegiatan --</option>
                                    @foreach($kategori_kegiatan as $row)
                                    <option value="{{$row->id}}">{{$row->kategori_kegiatan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mb-2">
                                <label for="email">PIC</label>
                                <select name="pic_id[]" class="form-select" id="" required>
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
                                <textarea name="kendala[]" class="form-control" id="" cols="30" rows="5 "></textarea>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="nama">Mulai mengerjakan</label>
                                <input type="text" id="mulaiMengerjakan" maxlength="5" name="mulai[]" class="form-control" required>
                            </div>
                            <div class="col mb-2">
                                <label for="email">Selesai mengerjakan</label>
                                <input type="text" id="selesaiMengerjakan" maxlength="5" name="selesai[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="nama">Status Kegiatan</label>
                                <select name="status_kegiatan[]" class="form-select" id="" required>
                                    <option value="" disabled selected>-- Pilih status kegiatan --</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="tidak selesai">Tidak selesai</option>
                                </select>
                            </div>
                            <div class="col mb-2">
                                <label for="email">Deadline penyelesaian</label>
                                <input type="date" name="deadline[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="status-akhir">Status akhir</label>
                                <select name="status_akhir[]" class="form-select" id="" required>
                                    <option value="" disabled selected>-- Pilih status akhir --</option>
                                    <option value="sesuai">Sesuai</option>
                                    <option value="tidak sesuai">Tidak sesuai</option>
                                </select>
                            </div>
                            <div class="col mb-2">
                                <label for="kuantitas">Kuantitas</label>
                                <input type="number" name="kuantitas[]" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                        <a type="button" href="#form-kegiatan" class="btn btn-success float-end mx-2 add-more">
                            <span class="tf-icons bx bx-plus"></span>
                            Tambah kegiatan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="copy" style="display: none;">
    <div id="form-kegiatan" class="card-body control-group count">
        <div class="row">
            <div class="col mb-2">
                <label for="kegiatan">Kegiatan</label>
                <textarea class="form-control" name="kegiatan[]" cols="30" rows="5" required></textarea>
            </div>
        </div>
        <div class="row mb-3 g-2">
            <div class="col mb-2">
                <label for="email">Jenis Kegiatan</label>
                <select name="jenis_kegiatan_id[]" class="form-select" required>
                    <option value="" disabled selected>-- Pilih jenis kegiatan --</option>
                    @foreach($jenis_kegiatan as $row)
                    <option value="{{$row->id}}">{{$row->jenis_kegiatan}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3 g-2">
            <div class="col mb-2">
                <label for="kata-sandi">Kategori kegiatan</label>
                <select name="kategori_kegiatan_id[]" class="form-select" id="" required>
                    <option value="" disabled selected>-- Pilih kategori kegiatan --</option>
                    @foreach($kategori_kegiatan as $row)
                    <option value="{{$row->id}}">{{$row->kategori_kegiatan}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col mb-2">
                <label for="email">PIC</label>
                <select name="pic_id[]" class="form-select" id="" required>
                    <option value="" disabled selected>-- Pilih PIC --</option>
                    @foreach($pic as $row)
                    <option value="{{$row->id}}">{{$row->pic}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="kendala">Kendala/Masalah</label>
                <textarea name="kendala[]" class="form-control" id="" cols="30" rows="5 "></textarea>
            </div>
        </div>
        <div class="row mb-3 g-2">
            <div class="col mb-2">
                <label class="mb-1" for="nama">Mulai</label>
                <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" title="format harus HH:mm" maxlength="5" placeholder="Format HH:mm" name="mulai[]" class="form-control timepicker2" required>
                <span><small><i><b>Contoh 08:50</b></i></small></span>
            </div>
            <div class="col mb-2">
                <label for="email">Selesai</label>
                <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" title="format harus HH:mm" maxlength="5" placeholder="Format HH:mm" name="selesai[]" class="form-control timepicker2" required>
                <span><small><i><b>Contoh 09:50</b></i></small></span>
            </div>
        </div>

        <div class="row mb-3 g-2">
            <div class="col mb-2">
                <label for="nama">Status Kegiatan</label>
                <select name="status_kegiatan[]" class="form-select" id="" required>
                    <option value="" disabled selected>-- Pilih status kegiatan --</option>
                    <option value="selesai">Selesai</option>
                    <option value="tidak selesai">Tidak selesai</option>
                </select>
            </div>
            <div class="col mb-2">
                <label for="deadline">Deadline penyelesaian</label>
                <input type="date" name="deadline[]" class="form-control" required>
            </div>
        </div>
        <div class="row mb-3 g-2">
            <div class="col mb-2">
                <label for="nama">Status akhir</label>
                <select name="status_akhir[]" class="form-select" id="" required>
                    <option value="" disabled selected>-- Pilih status akhir --</option>
                    <option value="sesuai">Sesuai</option>
                    <option value="tidak sesuai">Tidak sesuai</option>
                </select>
            </div>
            <div class="col mb-2">
                <label for="kuantitas">Kuantitas</label>
                <input type="number" name="kuantitas[]" class="form-control">
            </div>
        </div>
        <button type="button" class="btn btn-danger remove btn-sm">
            <span class="tf-icons bx bx-trash"></span>
            Hapus form kegiatan
        </button>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('.timepicker').timepicker({
            minuteStep: 60,
            showMeridian: false,
            format: 'hh:mm',
            defaultTime: '00:00',
            use24hours: true
        });

        $('.timepicker2').timepicker({
            minuteStep: 60,
            showMeridian: false,
            format: 'hh:mm',
            defaultTime: '00:00',
            use24hours: true
        });

        $(".add-more").click(function() {
            var count = $(".count").length;
            var html = $(".copy").html();
            $(".after-add-more").after(html);
        });

        // saat tombol remove dklik control group akan dihapus 
        $("body").on("click", ".remove", function() {
            $(this).parents(".control-group").remove();
        });
    });

    const jamMasuk = document.getElementById("jamMasuk");
    jamMasuk.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const jamIstirahat = document.getElementById("jamIstirahat");
    jamIstirahat.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const jamKembaliIstirahat = document.getElementById("jamKembaliIstirahat");
    jamKembaliIstirahat.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const jamPulang = document.getElementById("jamPulang");
    jamPulang.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const mulaiMengerjakan = document.getElementById("mulaiMengerjakan");
    mulaiMengerjakan.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const selesaiMengerjakan = document.getElementById("selesaiMengerjakan");
    selesaiMengerjakan.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });
</script>

@endsection