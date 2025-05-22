@extends('layout.sidebar')

@section('title', 'Edit PO')
@section('pages', 'Edit PO')

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
                <form action="{{ route('po.update', $po->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label>No PO</label>
                        <input type="text" name="no_po" class="form-control" value="{{ $po->no_po }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Wide</label>
                        <select name="wide" class="form-control" required>
                            <option value="">Pilih Wide</option>
                            <option value="M" {{ $po->wide == 'M' ? 'selected' : '' }}>M</option>
                            <option value="W" {{ $po->wide == 'W' ? 'selected' : '' }}>W</option>
                            <option value="XW" {{ $po->wide == 'XW' ? 'selected' : '' }}>XW</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Size Run</label>
                        <select name="size_run" class="form-control" required>
                            <option value="" disabled selected>Pilih Size Run</option>
                            <option value="I" {{ $po->size_run == 'I' ? 'selected' : '' }}>I</option>
                            <option value="C" {{ $po->size_run == 'C' ? 'selected' : '' }}>C</option>
                            <option value="K" {{ $po->size_run == 'K' ? 'selected' : '' }}>K</option>
                            <option value="J" {{ $po->size_run == 'J' ? 'selected' : '' }}>J</option>
                            <option value="M" {{ $po->size_run == 'M' ? 'selected' : '' }}>M</option>
                            <option value="W" {{ $po->size_run == 'W' ? 'selected' : '' }}>W</option>
                            <option value="U" {{ $po->size_run == 'U' ? 'selected' : '' }}>U</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Colour Way</label>
                        <input type="text" name="colour_way" class="form-control" value="{{ $po->colour_way }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label>Style</label>
                        <input type="text" name="style" class="form-control" value="{{ $po->style }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Market</label>
                        <input type="text" name="market" class="form-control" value="{{ $po->market }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Qty Original</label>
                        <input type="text" name="qty_original" class="form-control" value="{{ $po->qty_original }}"
                            required>
                    </div>
                    <hr>
                    <h5>Size Order PO</h5>
                    <table class="table" id="sizeOrderTable">
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>Total</th>
                                <th>
                                    <button type="button" class="btn btn-success btn-sm" id="addRow">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($po->sizeOrderPos as $size)
                                <tr>
                                    <td><input type="text" name="size[]" class="form-control"
                                            value="{{ $size->size }}" required></td>
                                    <td><input type="number" name="total[]" class="form-control total-input"
                                            value="{{ $size->total }}" required></td>
                                    <td><button type="button" class="btn btn-danger btn-sm removeRow">-</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                     <div class="mb-3">
                        <strong>Total Size Order PO Sementara: <span id="totalSementara">0</span></strong>
                    </div>
                    <button type="submit" class="btn btn-primary d-inline btn-update" >Update</button>
                    <a href="{{ route('po.index') }}" class="btn btn-secondary">Kembali</a>
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
            if (e.target && e.target.classList.contains('removeRow')) {
                let row = e.target.closest('tr');
                let table = row.closest('tbody');
                if (table.rows.length > 1) {
                    row.remove();
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Event delegation untuk tombol hapus
        document.querySelectorAll('.btn-update').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                let form = this.closest('form');
                Swal.fire({
                    title: 'Yakin ingin mengubah data?',
                    text: "Data PO dan Size Order PO akan diubah!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, ubah!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script>
        function updateTotalSementara() {
            let total = 0;
            document.querySelectorAll('.total-input').forEach(function(input) {
                let val = parseInt(input.value);
                if (!isNaN(val)) total += val;
            });
            document.getElementById('totalSementara').textContent = total;
        }

        document.getElementById('addRow').addEventListener('click', function() {
            let table = document.getElementById('sizeOrderTable').getElementsByTagName('tbody')[0];
            let newRow = table.rows[0].cloneNode(true);
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            table.appendChild(newRow);
            // Tambahkan event listener untuk input baru
            newRow.querySelector('.total-input').addEventListener('input', updateTotalSementara);
            updateTotalSementara();
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('removeRow')) {
                let row = e.target.closest('tr');
                let table = row.closest('tbody');
                if (table.rows.length > 1) {
                    row.remove();
                    updateTotalSementara();
                }
            }
        });

        // Event listener untuk semua input total
        document.addEventListener('input', function(e) {
            if (e.target && e.target.classList.contains('total-input')) {
                updateTotalSementara();
            }
        });

        // Inisialisasi pertama kali
        updateTotalSementara();
    </script>
@endsection
