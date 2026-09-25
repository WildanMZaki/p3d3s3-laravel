@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
        <div>
            <h2>{{ $activity->title }}</h2>
            <span style="color: var(--text-muted); font-size: 0.875rem;">
                Kategori: <strong>{{ $activity->category }}</strong>
            </span>
        </div>
        <span class="badge badge-{{ strtolower($activity->status) }}">
            {{ $activity->status }}
        </span>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <p><strong>Tanggal Pelaksanaan:</strong> {{ $activity->activity_date->format('d F Y') }}</p>
        <p style="margin-top: 0.75rem;"><strong>Deskripsi:</strong></p>
        <p style="color: #334155; margin-top: 0.25rem;">
            {{ $activity->description ?: 'Tidak ada deskripsi tambahan.' }}
        </p>
    </div>

    <div style="font-size: 0.8rem; color: var(--text-muted); border-top: 1px solid var(--border-color); padding-top: 0.75rem; margin-bottom: 1.5rem;">
        <p>Dibuat: {{ $activity->created_at->format('d M Y H:i') }} | Terakhir diupdate: {{ $activity->updated_at->format('d M Y H:i') }}</p>
    </div>

    <div class="actions">
        <a href="{{ route('activities.edit', $activity) }}" class="btn btn-primary">Ubah Kegiatan</a>
        <form action="{{ route('activities.destroy', $activity) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
        <a href="{{ route('activities.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>
</div>
@endsection
