@extends('layout.sidebar')

@section('title', 'Detail Daily Pengajuan')
@section('pages', 'Detail Daily Pengajuan')

@section('content')
    <div class="container-fluid py-4">
        <div class="card mb-3">
            <div class="card-body">
                <h5>Detail Daily Pengajuan</h5>
                <p><strong>Tanggal Mulai:</strong> {{ $pengajuan->tanggal_mulai }}</p>
                <p><strong>Tanggal Selesai:</strong> {{ $pengajuan->tanggal_selesai }}</p>
                <p>
                    <strong>Jumlah Hari:</strong>
                    {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($pengajuan->tanggal_selesai)) + 1 }}
                    hari
                </p>
                <p><strong>Cell:</strong> {{ $pengajuan->cell }}</p>
                <p><strong>bagian:</strong> {{ $pengajuan->bagian }}</p>
                <p><strong>xfd:</strong> {{ $pengajuan->xfd }}</p>
                <p><strong>bm:</strong> {{ $pengajuan->bm }}</p>
                <p><strong>Colour Way:</strong> {{ $pengajuan->po->colour_way ?? '-' }}</p>
                <p><strong>Style:</strong> {{ $pengajuan->po->style ?? '-' }}</p>
                <p><strong>Market:</strong> {{ $pengajuan->po->market ?? '-' }}</p>
                <p><strong>No PO:</strong> {{ $pengajuan->po->no_po ?? '-' }}</p>
                <h6>Original Size Order Qty</h6>
                <ul>
                    @foreach ($pengajuan->po->sizeOrderPos as $size)
                        <li>{{ $size->size }} ({{ $size->total }})</li>
                    @endforeach
                </ul>
                <hr>
                <h6>Size Order Checklist</h6>
                <ul>
                    @foreach ($pengajuan->sizeOrderDailies as $s)
                        <li>{{ $s->size }} : {{ $s->total }}</li>
                    @endforeach
                </ul>
                <hr>
                <h6>Data Balance</h6>
                <ul>
                    @foreach ($pengajuan->po->sizeOrderPos as $poSize)
                        @php
                            $daily = $pengajuan->sizeOrderDailies->firstWhere('size', $poSize->size);
                            $balance = $poSize->total - ($daily->total ?? 0);
                        @endphp
                        <li>
                            Size {{ $poSize->size }}: {{ $poSize->total }} - {{ $daily->total ?? 0 }} =
                            <strong>{{ $balance }}</strong>
                        </li>
                    @endforeach
                </ul>
                <form action="{{ route('daily_pengajuan.kurang.update', $pengajuan->id) }}" method="POST">
                    @csrf
                    <table class="table" id="kurangTable">
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>Total</th>
                                {{-- <th>
                                    <button type="button" class="btn btn-success btn-sm" id="addRow">+</button>
                                </th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuan->kurangs as $kurang)
                                <tr>
                                    <td><input type="text" name="size[]" class="form-control" value="{{ $kurang->size }}"
                                            required></td>
                                    <td><input type="number" name="total[]" class="form-control"
                                            value="{{ $kurang->total }}" required></td>
                                    {{-- <td><button type="button" class="btn btn-danger btn-sm removeRow">-</button></td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td><input type="text" name="size[]" class="form-control" required></td>
                                    <td><input type="number" name="total[]" class="form-control" required></td>
                                    <td><button type="button" class="btn btn-danger btn-sm removeRow">-</button></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Simpan/Update Kurang</button>
                </form>
                <hr>
                <a href="{{ route('daily_pengajuan.edit', $pengajuan->id) }}" class="btn btn-warning">Edit</a>
                {{-- <form action="{{ route('daily_pengajuan.destroy', $pengajuan->id) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form> --}}
                <a href="{{ route('daily_pengajuan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('addRow').addEventListener('click', function() {
            let table = document.getElementById('kurangTable').getElementsByTagName('tbody')[0];
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
