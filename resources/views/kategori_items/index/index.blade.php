@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="form-group mb-2">
                <a href="{{ url('kategori-items/form/new') }}" class="btn btn-secondary">+ Kategori Baru</a>
            </div>
            <div class="card">
                <div class="card-header">Daftar Kategori Items</div>

                <div class="card-body">
                    <form method="GET" action="{{ url('kategori-items') }}" class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Kode</label>
                                    <input type="text" class="form-control" name="kode" value="{{ $filter_kode ?? '' }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" value="{{ $filter_nama ?? '' }}">
                                </div>
                            </div>
                            <div class="col-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ url('kategori-items') }}" class="btn btn-outline-secondary ms-2">Reset</a>
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategori_list as $index => $kategori)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kategori->kode }}</td>
                                <td>{{ $kategori->nama }}</td>
                                <td>
                                    <a href="{{ url('kategori-items/view/' . $kategori->id) }}" class="btn btn-primary btn-sm">View</a>
                                    <a href="{{ url('kategori-items/form/edit/' . $kategori->id) }}" class="btn btn-info btn-sm">Edit</a>
                                    <a href="{{ url('kategori-items/delete/' . $kategori->id) }}"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Tidak ada data kategori.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection