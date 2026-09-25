@extends('layouts.app')

@section('content')
<div class="card">
    <h2 style="margin-bottom: 1.25rem;">Tambah Kegiatan Baru</h2>

    <form action="{{ route('activities.store') }}" method="POST">
        @include('activities._form')

        <div class="actions">
            <button type="submit" class="btn btn-primary">Simpan Kegiatan</button>
            <a href="{{ route('activities.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
