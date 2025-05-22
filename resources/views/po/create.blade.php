@extends('layout.sidebar')

@section('title', 'Tambah PO')
@section('pages', 'Tambah PO')

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
                <form action="{{ route('po.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>No PO</label>
                        <input type="text" name="no_po" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Wide</label>
                        <select name="wide" class="form-control" required>
                            <option value="" disabled selected>Pilih Wide</option>
                            <option value="M">M</option>
                            <option value="W">W</option>
                            <option value="XW">XW</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Size Run</label>
                        <select name="size_run" class="form-control" required>
                            <option value="" disabled selected>Pilih Size Run</option>
                            <option value="I">I</option>
                            <option value="C">C</option>
                            <option value="K">K</option>
                            <option value="J">J</option>
                            <option value="M">M</option>
                            <option value="W">W</option>
                            <option value="U">U</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Colour Way</label>
                        <input type="text" name="colour_way" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Style</label>
                        <input type="text" name="style" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Market</label>
                        <input type="text" name="market" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Qty Original</label>
                        <input type="text" name="qty_original" class="form-control" required>
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
                            <tr>
                                <td><input type="text" name="size[]" class="form-control" required></td>
                                <td><input type="number" name="total[]" class="form-control total-input" required></td>
                                <td><button type="button" class="btn btn-danger btn-sm removeRow">-</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mb-3">
                        <strong>Total Size Order PO Sementara: <span id="totalSementara">0</span></strong>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('po.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
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
