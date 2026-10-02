@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <h2>Daftar Kegiatan</h2>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kelola Kategori</a>
        <a href="{{ route('activities.create') }}" class="btn btn-primary">+ Tambah Kegiatan</a>
    </div>
</div>

<div class="filter-bar">
    <span style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted);">Filter Status:</span>
    <a href="{{ route('activities.index') }}" class="filter-link {{ empty($status) ? 'active' : '' }}">Semua</a>
    <a href="{{ route('activities.index', ['status' => 'draft']) }}" class="filter-link {{ $status === 'draft' ? 'active' : '' }}">Draft</a>
    <a href="{{ route('activities.index', ['status' => 'published']) }}" class="filter-link {{ $status === 'published' ? 'active' : '' }}">Published</a>
    <a href="{{ route('activities.index', ['status' => 'completed']) }}" class="filter-link {{ $status === 'completed' ? 'active' : '' }}">Completed</a>
</div>

@forelse ($activities as $activity)
    <article class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
            <div>
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                    <span style="font-size: 0.75rem; font-weight: 700; background: #f1f5f9; padding: 2px 8px; border-radius: 4px; border: 1px solid #cbd5e1;">
                        {{ $activity->code }}
                    </span>
                    <h3 style="margin: 0;">
                        <a href="{{ route('activities.show', $activity) }}" style="color: #0f172a; text-decoration: none;">
                            {{ $activity->title }}
                        </a>
                    </h3>
                </div>
                <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 0.5rem;">
                    Kategori: <strong>{{ $activity->category?->name ?? 'Tanpa Kategori' }}</strong> &bull; 
                    Waktu: <strong>{{ $activity->start_at?->format('d M Y') }}</strong> s.d. <strong>{{ $activity->end_at?->format('d M Y') }}</strong> &bull;
                    Kapasitas: <strong>{{ $activity->capacity }} peserta</strong>
                    @if ($activity->location)
                        &bull; Lokasi: <strong>{{ $activity->location }}</strong>
                    @endif
                </p>
                @if ($activity->description)
                    <p style="font-size: 0.925rem; color: #334155; margin-bottom: 0.5rem;">
                        {{ $activity->description }}
                    </p>
                @endif
            </div>
            <div>
                <span class="badge badge-{{ strtolower($activity->status) }}">
                    {{ $activity->status }}
                </span>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('activities.show', $activity) }}" class="btn btn-secondary">Detail</a>
            <a href="{{ route('activities.edit', $activity) }}" class="btn btn-secondary">Ubah</a>
            <form action="{{ route('activities.destroy', $activity) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </article>
@empty
    <div class="card" style="text-align: center; padding: 2rem; color: var(--text-muted);">
        <p>Belum ada kegiatan.</p>
    </div>
@endforelse
@endsection
