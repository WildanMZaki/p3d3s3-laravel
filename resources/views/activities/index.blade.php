@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h2>Daftar Kegiatan</h2>
    <a href="{{ route('activities.create') }}" class="btn btn-primary">+ Buat Kegiatan Baru</a>
</div>

<div class="filter-bar">
    <span style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted);">Filter Status:</span>
    <a href="{{ route('activities.index') }}" class="filter-link {{ empty($status) ? 'active' : '' }}">Semua</a>
    <a href="{{ route('activities.index', ['status' => 'Planned']) }}" class="filter-link {{ $status === 'Planned' ? 'active' : '' }}">Planned</a>
    <a href="{{ route('activities.index', ['status' => 'Ongoing']) }}" class="filter-link {{ $status === 'Ongoing' ? 'active' : '' }}">Ongoing</a>
    <a href="{{ route('activities.index', ['status' => 'Done']) }}" class="filter-link {{ $status === 'Done' ? 'active' : '' }}">Done</a>
</div>

@forelse ($activities as $activity)
    <article class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
            <div>
                <h3 style="margin-bottom: 0.25rem;">
                    <a href="{{ route('activities.show', $activity) }}" style="color: #0f172a; text-decoration: none;">
                        {{ $activity->title }}
                    </a>
                </h3>
                <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 0.5rem;">
                    Kategori: <strong>{{ $activity->category }}</strong> &bull; Tanggal: <strong>{{ $activity->activity_date->format('d M Y') }}</strong>
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
