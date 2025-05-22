@extends('layout.sidebar')

@section('title', 'Edit Daily Pengajuan')
@section('pages', 'Edit Daily Pengajuan')

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

            <form action="{{ route('daily_pengajuan.update', $pengajuan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>No PO</label>
                    <input type="text" class="form-control" value="{{ $pengajuan->po->no_po ?? '-' }}" readonly>
                </div>
                <div class="mb-3">
                    <label>Wide</label>
                    <input type="text" class="form-control" value="{{ $pengajuan->po->wide ?? '-' }}" readonly>
                </div>
                <div class="mb-3">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $pengajuan->tanggal_mulai }}" required>
                </div>
                <div class="mb-3">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ $pengajuan->tanggal_selesai }}" required>
                </div>
                <hr>
                <h6>Edit Size Order Daily</h6>
                <table class="table" id="sizeOrderTable">
                    <thead>
                        <tr>
                            <th>Size</th>
                            <th>Total</th>
                            <th>
                                {{-- <button type="button" class="btn btn-success btn-sm" id="addRow">+</button> --}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengajuan->sizeOrderDailies as $size)
                        <tr>
                            <td><input type="text" name="size[]" class="form-control" value="{{ $size->size }}" required readonly></td>
                            <td><input type="number" name="total[]" class="form-control" value="{{ $size->total }}" required readonly></td>
                            {{-- <td><button type="button" class="btn btn-danger btn-sm removeRow">-</button></td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('daily_pengajuan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('addRow').addEventListener('click', function() {
        let table = document.getElementById('sizeOrderTable').getElementsByTagName('tbody')[0];
        let newRow = table.rows[0].cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        table.appendChild(newRow);
    });

    document.addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('removeRow')) {
            let row = e.target.closest('tr');
            let table = row.closest('tbody');
            if(table.rows.length > 1) {
                row.remove();
            }
        }
    });
</script>
@endsection
