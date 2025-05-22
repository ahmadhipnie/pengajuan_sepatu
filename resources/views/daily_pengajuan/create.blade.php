@extends('layout.sidebar')

@section('title', 'Tambah Daily Pengajuan')
@section('pages', 'Tambah Daily Pengajuan')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Step 1: Cari PO --}}
                <form method="GET" action="{{ route('daily_pengajuan.create') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-5 mb-2">
                            <label>No PO</label>
                            <input type="text" name="no_po" class="form-control" value="{{ request('no_po') }}"
                                required>
                        </div>
                        <div class="col-md-5 mb-2">
                            <label>Wide</label>
                            <select name="wide" class="form-control" required>
                                <option value="">Pilih Wide</option>
                                <option value="M" {{ request('wide') == 'M' ? 'selected' : '' }}>M</option>
                                <option value="W" {{ request('wide') == 'W' ? 'selected' : '' }}>W</option>
                                <option value="XW" {{ request('wide') == 'XW' ? 'selected' : '' }}>XW</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2 d-flex align-items-end">
                            <button class="btn btn-info w-100" type="submit">Cek PO</button>
                        </div>
                    </div>
                </form>

                {{-- Step 2: Jika PO ditemukan, tampilkan size order po dan form input daily_pengajuan --}}
                @if ($po)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6>Data PO</h6>
                            <div><strong>No PO:</strong> {{ $po->no_po }}</div>
                            <div><strong>Wide:</strong> {{ $po->wide }}</div>
                            <div><strong>Size Run:</strong> {{ $po->size_run }}</div>
                            <div><strong>Colour Way:</strong> {{ $po->colour_way }}</div>
                            <div><strong>Style:</strong> {{ $po->style ?? '-' }}</div>
                            <div><strong>Market:</strong> {{ $po->market ?? '-' }}</div>
                            <div><strong>Qty Original:</strong> {{ $po->qty_original ?? '-' }}</div>

                            <ul>
                                @foreach ($po->sizeOrderPos as $size)
                                    <li>{{ $size->size }} ({{ $size->total }})</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <form action="{{ route('daily_pengajuan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="no_po" value="{{ $po->no_po }}">
                        <input type="hidden" name="wide" value="{{ $po->wide }}">
                        <div class="row">
                            @foreach ($sizeOrderPo as $size)
                                <div class="col-md-3">
                                    <div class="card mb-2">
                                        <div class="card-body p-2">
                                            <input type="hidden" name="size[]" value="{{ $size->size }}">
                                            <div><strong>Size:</strong> {{ $size->size }}</div>
                                            <div class="mb-2">
                                                <label>Total</label>
                                                <input type="number" name="total[]" class="form-control"
                                                    value="{{ $size->total }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('daily_pengajuan.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                @elseif(request()->filled('no_po') && request()->filled('wide'))
                    <div class="alert alert-danger">PO dengan No dan Wide tersebut tidak ditemukan.</div>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.getElementById('addRow')?.addEventListener('click', function() {
            let table = document.getElementById('sizeOrderTable').getElementsByTagName('tbody')[0];
            let newRow = table.rows[0].cloneNode(true);
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            table.appendChild(newRow);
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('removeRow')) {
                let row = e.target.closest('tr');
                let table = row.closest('tbody');
                if (table.rows.length > 1) {
                    row.remove();
                }
            }
        });
    </script>
@endsection
