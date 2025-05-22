@extends('layout.sidebar')

@section('title', 'Data Daily Pengajuan')
@section('pages', 'Data Daily Pengajuan')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('daily_pengajuan.create') }}" class="btn btn-primary mb-3">Tambah Data</a>

                <form method="GET" action="{{ route('daily_pengajuan.index') }}" class="mb-3">
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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>No PO</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal_mulai }}</td>
                                <td>{{ $item->tanggal_selesai }}</td>
                                <td>{{ $item->po->no_po ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('daily_pengajuan.show', $item->id) }}"
                                        class="btn btn-info btn-sm">Detail</a>
                                    <a href="{{ route('daily_pengajuan.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    {{-- <form action="{{ route('daily_pengajuan.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
