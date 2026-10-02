@extends('layouts.app')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h2>Daftar Kegiatan</h2>
</div>

{{-- Bar Pencarian, Filter Kombinasi, dan Pengurutan --}}
<div class="search-filter-card">
    <form method="GET" action="{{ route('activities.index') }}" class="filter-grid">
        <div>
            <label for="search" style="font-size: 0.8rem; margin-bottom: 0.25rem;">Cari Kegiatan</label>
            <input
                type="text"
                id="search"
                name="search"
                placeholder="Judul atau kode kegiatan..."
                value="{{ request('search') }}"
            >
        </div>

        <div>
            <label for="category_id" style="font-size: 0.8rem; margin-bottom: 0.25rem;">Kategori</label>
            <select name="category_id" id="category_id">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected(request('category_id') == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="status" style="font-size: 0.8rem; margin-bottom: 0.25rem;">Status</label>
            <select name="status" id="status">
                <option value="">Semua Status</option>
                <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                <option value="published" @selected(request('status') === 'published')>Published</option>
                <option value="completed" @selected(request('status') === 'completed')>Completed</option>
            </select>
        </div>

        <div>
            <label for="sort" style="font-size: 0.8rem; margin-bottom: 0.25rem;">Urutan Waktu</label>
            <select name="sort" id="sort">
                <option value="latest" @selected(request('sort') === 'latest' || !request('sort'))>Terbaru</option>
                <option value="oldest" @selected(request('sort') === 'oldest')>Terlama</option>
            </select>
        </div>

        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn btn-primary" style="height: 42px;">Terapkan</button>
            @if (request()->hasAny(['search', 'category_id', 'status', 'sort']))
                <a href="{{ route('activities.index') }}" class="btn btn-secondary" style="height: 42px; display: inline-flex; align-items: center;">Reset</a>
            @endif
        </div>
    </form>
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

            {{-- Tombol Transisi Status Eksplisit --}}
            @if ($activity->status === 'draft')
                <form action="{{ route('activities.publish', $activity) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Publikasikan kegiatan ini agar peserta dapat mendaftar?');">
                        Publish
                    </button>
                </form>
            @elseif ($activity->status === 'published')
                <form action="{{ route('activities.complete', $activity) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Tandai kegiatan ini sebagai selesai? Status completed tidak dapat dibatalkan.');">
                        Selesaikan
                    </button>
                </form>
            @endif

            <form action="{{ route('activities.destroy', $activity) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </article>
@empty
    <div class="card" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
        <p style="font-size: 1.1rem; margin-bottom: 0.5rem;">Tidak ada kegiatan yang sesuai kriteria pencarian.</p>
        <p style="font-size: 0.875rem;">Coba ubah kata kunci atau reset filter pencarian Anda.</p>
    </div>
@endforelse

{{-- Pagination Links --}}
<div class="pagination-container">
    {{ $activities->links() }}
</div>
@endsection
