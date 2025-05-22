<!-- filepath: c:\Users\huawei\Documents\erik\admin_perpustakaan\resources\views\dashboard.blade.php -->
@extends('layout.sidebar')

@section('title', 'Dashboard')
@section('pages', 'Home')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">

            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <a href="{{ route('kurang.table') }}" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Kurang Saat Ini</p>
                                        </br>
                                        <h5 class="font-weight-bolder">
                                            {{ $totalKurang }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Daily Pengajuan</p>
                                    </br>
                                    <h5 class="font-weight-bolder">
                                        {{ $totalDailyPengajuan }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card lainnya ... --}}

        </div>
    </div>
@endsection
