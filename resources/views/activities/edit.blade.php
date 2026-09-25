@extends('layouts.app')

@section('content')
<div class="card">
    <h2 style="margin-bottom: 1.25rem;">Ubah Kegiatan: {{ $activity->title }}</h2>

    <form action="{{ route('activities.update', $activity) }}" method="POST">
        @method('PUT')
        @include('activities._form')

        <div class="actions">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('activities.show', $activity) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
