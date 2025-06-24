@extends('layout.sidebar')

@section('title', 'Data PO')
@section('pages', 'Data PO')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('po.create') }}" class="btn btn-primary mb-3">Tambah PO</a>

                <form method="GET" action="{{ route('po.index') }}" class="mb-3" style="max-width:400px;">
                    <div class="row g-2" style="max-width:400px;">
                        <div class="col">
                            <input type="text" name="search" class="form-control" placeholder="Cari No PO..."
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        </div>
                    </div>
                </form>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No PO</th>
                                <th>Wide</th>
                                <th>Size Run</th>
                                <th>Colour Way</th>
                                <th>Style</th>
                                <th>Market</th>
                                <th>Qty Original</th>
                                <th>Size Order</th>
                                <th>Updated at</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($po as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->no_po }}</td>
                                    <td>{{ $item->wide }}</td>
                                    <td>{{ $item->size_run }}</td>
                                    <td>{{ $item->colour_way }}</td>
                                    <td>{{ $item->style }}</td>
                                    <td>{{ $item->market }}</td>
                                    <td>{{ $item->updated_at ? $item->updated_at->format('H:i:s') : '-' }}</td>
                                    <td>{{ $item->qty_original }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($item->sizeOrderPos as $size)
                                                <li>{{ $size->size }} : {{ $size->total }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <a href="{{ route('po.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('po.destroy', $item->id) }}" method="POST"
                                            class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Event delegation untuk tombol hapus
        document.querySelectorAll('.btn-delete').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                let form = this.closest('form');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data PO dan Size Order PO akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
