@extends('layouts.app')

@section('content')
    <!--wrapper-->
    <div class="wrapper-main">
        <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="text-center">
                    <!-- Banner Container -->
                    <div
                        class="d-flex align-items-center justify-content-center flex-column flex-md-row mb-4 position-relative">
                        <div class="banner-container">
                            <img src="{{ asset('public/assets/images/banner.png') }}" class="banner-main img-fluid rounded"
                                alt="banner">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <h3 class="text-center text-uppercase mb-4">REKOD KEHADIRAN</h3>
                        <!-- Form for Checking Staff ID -->
                        <form action="{{ route('attendance.store') }}" method="POST" class="d-flex">
                            {{ csrf_field() }}
                            <div class="form-group flex-grow-1 me-2">
                                <input type="text" class="form-control custom-placeholder" id="no_pekerja"
                                    name="no_pekerja" placeholder="Sila Masukkan No. Pekerja Anda"
                                    value="{{ old('no_pekerja') }}" autofocus>
                            </div>
                            <button type="submit" class="btn btn-primary">HANTAR</button>
                        </form>

                        @if ($errors->any())
                            <div id="error-alert" class="alert alert-danger mt-3 fade-out">
                                {{ $errors->first('no_pekerja') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div id="success-alert" class="alert alert-success mt-3 fade-out">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        function fadeOut(elementId) {
            var element = document.getElementById(elementId);
            if (element) {
                setTimeout(function() {
                    element.style.opacity = '0';
                    setTimeout(function() {
                        element.style.display = 'none';
                    }, 1000); 
                }, 3000); 
            }
        }

        fadeOut('error-alert');
        fadeOut('success-alert');
    });
</script>
@endsection
