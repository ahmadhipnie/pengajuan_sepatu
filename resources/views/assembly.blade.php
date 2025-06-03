@extends('layout.sidebar')

@section('title', 'Detail Assembly')
@section('pages', 'Detail Assembly')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Data Daily Pengajuan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Cell</th>
                                <th>Bagian</th>
                                <th>XFD</th>
                                <th>BM</th>
                                <th>No PO</th>
                                <th>Wide</th>
                                <th>Size Order Checklist</th>
                                <th>Size Order Daily</th>
                                <th>Balance</th>
                                <th>MLT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal_mulai }}</td>
                                    <td>{{ $item->tanggal_selesai }}</td>
                                    <td>{{ $item->cell }}</td>
                                    <td>{{ $item->bagian }}</td>
                                    <td>{{ $item->xfd }}</td>
                                    <td>{{ $item->bm }}</td>
                                    <td>{{ $item->po->no_po ?? '-' }}</td>
                                    <td>{{ $item->po->wide ?? '-' }}</td>
                                    <td>
                                        <ul class="mb-0">
                                            @foreach ($item->po->sizeOrderPos as $sod)
                                                <li>{{ $sod->size }} : {{ $sod->total }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <ul class="mb-0">
                                            @foreach ($item->sizeOrderDailies as $sod)
                                                <li>{{ $sod->size }} : {{ $sod->total }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <ul class="mb-0">
                                            @if ($item->kurangs->isEmpty())
                                                <li>Semua Terchecklist✅</li>
                                            @else
                                                @foreach ($item->kurangs as $kurang)
                                                    <li>{{ $kurang->size }} : {{ $kurang->total }}</li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($item->tanggal_selesai)) + 1 }}
                                        hari
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
                </div>

                <h5 class="mb-4">Grafik Size Order PO, Size Order Daily, dan Kurang per Bulan</h5>
                <canvas id="barChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                        label: 'Size Order PO',
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        data: {!! json_encode($poData) !!}
                    },
                    {
                        label: 'Size Order Daily',
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        data: {!! json_encode($dailyData) !!}
                    },
                    {
                        label: 'Kurang',
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        data: {!! json_encode($kurangData) !!}
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: false,
                    }
                },
                scales: {
                    x: { // hilangkan stacked: true
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
