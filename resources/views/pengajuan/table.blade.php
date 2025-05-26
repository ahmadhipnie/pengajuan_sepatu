@extends('layout.sidebar')

@section('title', 'Tabel Daily Pengajuan')
@section('pages', 'Tabel Daily Pengajuan')

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
            </div>
        </div>
    </div>
@endsection
