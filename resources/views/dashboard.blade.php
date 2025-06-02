<!-- filepath: c:\Users\huawei\Documents\erik\admin_perpustakaan\resources\views\dashboard.blade.php -->
@extends('layout.sidebar')

@section('title', 'Dashboard')
@section('pages', 'Home')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">

            <div class="col-xl-3 col-sm-6 mb-4">
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

            <div class="col-xl-3 col-sm-6 mb-4">
                <a href="{{ route('pengajuan.table') }}" style="text-decoration:none;">

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
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                        <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Card Assembly --}}
            <div class="col-xl-3 col-sm-6 mb-4">
                <a href="" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Assembly</p>
                                        </br>
                                        <h5 class="font-weight-bolder">
                                            {{ $bagianCounts['assembly'] ?? 0 }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                        <i class="ni ni-settings text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Card Cutting --}}
            <div class="col-xl-3 col-sm-6 mb-4">
                <a href="" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Cutting</p>
                                        </br>
                                        <h5 class="font-weight-bolder">
                                            {{ $bagianCounts['cutting'] ?? 0 }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                        <i class="ni ni-scissors text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Card Sewing --}}
            <div class="col-xl-3 col-sm-6 mb-4">
                <a href="" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Sewing</p>
                                        </br>
                                        <h5 class="font-weight-bolder">
                                            {{ $bagianCounts['sewing'] ?? 0 }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="ni ni-tie-bow text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Card Stokfitting --}}
            <div class="col-xl-3 col-sm-6 mb-4">
                <a href="" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Stokfitting</p>
                                        </br>
                                        <h5 class="font-weight-bolder">
                                            {{ $bagianCounts['stokfitting'] ?? 0 }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-secondary shadow-secondary text-center rounded-circle">
                                        <i class="ni ni-box-2 text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Card Incoming Bottom --}}
            <div class="col-xl-3 col-sm-6 mb-4">
                <a href="" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Incoming Bottom</p>
                                        </br>
                                        <h5 class="font-weight-bolder">
                                            {{ $bagianCounts['incoming bottom'] ?? 0 }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        <i class="ni ni-archive-2 text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Card Treatment --}}
            <div class="col-xl-3 col-sm-6 mb-4">
                <a href="" style="text-decoration:none;">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Treatment</p>
                                        </br>
                                        <h5 class="font-weight-bolder">
                                            {{ $bagianCounts['treatment'] ?? 0 }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-dark shadow-dark text-center rounded-circle">
                                        <i class="ni ni-palette text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
@endsection
