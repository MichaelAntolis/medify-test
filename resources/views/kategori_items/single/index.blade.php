@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ url('kategori-items') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>
            <div class="card mb-3">
                <div class="card-header">Detail Kategori</div>
                <div class="card-body">
                    <table>
                        <tr>
                            <th>Kode</th>
                            <td>:</td>
                            <td>{{ $kategori->kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{ $kategori->nama }}</td>
                        </tr>
                    </table>
                    <div class="mt-3">
                        <a href="{{ url('kategori-items/form/edit/' . $kategori->id) }}" class="btn btn-info">Edit</a>
                        <a href="{{ url('kategori-items/delete/' . $kategori->id) }}"
                            class="btn btn-danger"
                            onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                    </div>
                    <div class="mt-3">
                        <a href="{{ url('kategori-items/pdf/' . $kategori->id) }}" class="btn btn-success">
                            ⬇ Download PDF
                        </a>
                        <a href="{{ url('kategori-items/form/edit/' . $kategori->id) }}" class="btn btn-info">Edit</a>
                        <a href="{{ url('kategori-items/delete/' . $kategori->id) }}"
                            class="btn btn-danger"
                            onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Items dalam Kategori "{{ $kategori->nama }}"</div>
                <div class="card-body">
                    @if($kategori->masterItems->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Harga Beli</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategori->masterItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->jenis }}</td>
                                <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ url('master-items/view/' . $item->kode) }}" class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-muted">Belum ada item dalam kategori ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection