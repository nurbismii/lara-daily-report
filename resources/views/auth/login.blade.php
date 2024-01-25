@extends('layouts.auth')

@section('content')
<style>
    #loader {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        background-image: none;
        background: rgba(0, 0, 0, 0.75) url("{{ asset('assets/img/loader/loader-horizontal-unscreen.gif') }}") no-repeat center center;
        z-index: 99999;
    }
</style>
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            @include('message')
            <form class="mb-3 from-prevent-multiple-submits" action="{{ route('login') }}" method="POST">
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="javascript:void(0)" class="app-brand-link gap-2">
                                <img src="{{ asset('logo-hrd.png') }}" style="width: 50; height:60px;" alt="">
                                <span class="app-brand-text demo text-body fw-bolder">Laporan Harian</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Selamat datang! 👋</h4>
                        <span class="text-muted">Silahkan masuk ke akun dan mulai catat kegiatan harian kamu</span>
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Masukan email kamu" autofocus required />
                        </div>
                        <div class="mb-4 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label">Kata sandi</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input id="password-field" type="password" class="form-control" name="password" required>
                                <span toggle="#password-field" class="input-group-text cursor-pointer bx bx-hide toggle-password"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100 from-prevent-multiple-submits" aria-hidden="true" type="submit">Masuk</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="loader"></div>
        </div>
    </div>
</div>

<script>
    $(".toggle-password").click(function() {

        $(this).toggleClass("bx-hide bx-show");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    (function() {
        $('.from-prevent-multiple-submits').on('submit', function() {
            $('.from-prevent-multiple-submits').attr('disabled', 'true');
        })
    })();
</script>



@endsection