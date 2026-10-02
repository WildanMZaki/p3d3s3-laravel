@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                <span style="font-size: 0.8rem; font-weight: 700; background: #f1f5f9; padding: 2px 8px; border-radius: 4px; border: 1px solid #cbd5e1;">
                    {{ $activity->code }}
                </span>
                <h2 style="margin: 0;">{{ $activity->title }}</h2>
            </div>
            <span style="color: var(--text-muted); font-size: 0.875rem;">
                Kategori: <strong>{{ $activity->category?->name ?? 'Tanpa Kategori' }}</strong>
            </span>
        </div>
        <span class="badge badge-{{ strtolower($activity->status) }}">
            {{ $activity->status }}
        </span>
    </div>

    <div style="margin-bottom: 1.5rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
        <div>
            <p><strong>Waktu Pelaksanaan:</strong></p>
            <p style="color: #334155;">{{ $activity->start_at?->format('d F Y') }} s.d. {{ $activity->end_at?->format('d F Y') }}</p>
        </div>
        <div>
            <p><strong>Lokasi:</strong></p>
            <p style="color: #334155;">{{ $activity->location ?: 'Belum ditentukan' }}</p>
        </div>
        <div>
            <p><strong>Kapasitas Peserta:</strong></p>
            <p style="color: #334155;">{{ $activity->capacity }} peserta</p>
        </div>
        <div>
            <p><strong>Status Saat Ini:</strong></p>
            <p style="color: #334155; text-transform: capitalize;">{{ $activity->status }}</p>
        </div>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <p><strong>Deskripsi Kegiatan:</strong></p>
        <p style="color: #334155; margin-top: 0.25rem; white-space: pre-line;">
            {{ $activity->description ?: 'Tidak ada deskripsi tambahan.' }}
        </p>
    </div>

    <div style="font-size: 0.8rem; color: var(--text-muted); border-top: 1px solid var(--border-color); padding-top: 0.75rem; margin-bottom: 1.5rem;">
        <p>Dibuat: {{ $activity->created_at?->format('d M Y H:i') }} | Terakhir diupdate: {{ $activity->updated_at?->format('d M Y H:i') }}</p>
    </div>

    <div class="actions">
        @if ($activity->status === 'draft')
            <form action="{{ route('activities.publish', $activity) }}" method="POST" style="display: inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-primary" onclick="return confirm('Publikasikan kegiatan ini agar peserta dapat mendaftar?');">
                    Publikasikan Kegiatan
                </button>
            </form>
        @elseif ($activity->status === 'published')
            <form action="{{ route('activities.complete', $activity) }}" method="POST" style="display: inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-primary" onclick="return confirm('Tandai kegiatan ini sebagai selesai? Status completed tidak dapat dibatalkan.');">
                    Tandai Selesai
                </button>
            </form>
        @endif

        <a href="{{ route('activities.edit', $activity) }}" class="btn btn-secondary">Ubah Kegiatan</a>
        <form action="{{ route('activities.destroy', $activity) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
        <a href="{{ route('activities.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>
</div>
@endsection
