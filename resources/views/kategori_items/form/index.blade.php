@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ url('kategori-items') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>
            <div class="card">
                @if($method == 'new')
                <div class="card-header">Buat Kategori Baru</div>
                @else
                <div class="card-header">Edit Kategori</div>
                @endif

                <div class="card-body">
                    <form method="POST">
                        @csrf
                        @if($method == 'edit')
                        <div class="form-group mb-2">
                            <label>ID</label>
                            <input type="text" class="form-control" readonly value="{{ $kategori->id }}">
                        </div>
                        @endif

                        <div class="form-group mb-2">
                            <label>Kode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kode" required value="{{ $kategori->kode ?? '' }}">
                        </div>

                        <div class="form-group mb-2">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" required value="{{ $kategori->nama ?? '' }}">
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection