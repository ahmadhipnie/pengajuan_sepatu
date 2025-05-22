@extends('layout.sidebar')

@section('title', 'Tabel Kurang')
@section('pages', 'Tabel Kurang')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Data Kurang</h5>
                <div class="table-responsive">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Size</th>
                                <th>Total</th>
                                <th>No PO</th>
                                <th>Wide</th>
                                <th>Colour Way</th>
                                <th>Style</th>
                                <th>Size Run</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->size }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>{{ $item->dailyPengajuan->po->no_po ?? '-' }}</td>
                                    <td>{{ $item->dailyPengajuan->po->wide ?? '-' }}</td>
                                    <td>{{ $item->dailyPengajuan->po->colour_way ?? '-' }}</td>
                                    <td>{{ $item->dailyPengajuan->po->style ?? '-' }}</td>
                                    <td>{{ $item->dailyPengajuan->po->size_run ?? '-' }}</td>
                                    <td>{{ $item->dailyPengajuan->tanggal_mulai ?? '-' }}</td>
                                    <td>{{ $item->dailyPengajuan->tanggal_selesai ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
                </div>
            </div>
            </div>
        </div>
    @endsection
