@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h2>Data Kegiatan Terhapus (Trash)</h2>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Kegiatan yang di-soft delete dapat dipulihkan kembali ke daftar aktif.</p>
    </div>
    <a href="{{ route('activities.index') }}" class="btn btn-secondary">&larr; Kembali ke Daftar Kegiatan</a>
</div>

<div class="card">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid var(--border-color);">
                <th style="padding: 0.75rem;">Kode</th>
                <th style="padding: 0.75rem;">Judul Kegiatan</th>
                <th style="padding: 0.75rem;">Kategori</th>
                <th style="padding: 0.75rem;">Dihapus Pada</th>
                <th style="padding: 0.75rem; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($trashedActivities as $item)
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 0.75rem;">
                        <span style="font-size: 0.75rem; font-weight: 700; background: #f1f5f9; padding: 2px 8px; border-radius: 4px; border: 1px solid #cbd5e1;">
                            {{ $item->code }}
                        </span>
                    </td>
                    <td style="padding: 0.75rem; font-weight: 600;">
                        {{ $item->title }}
                    </td>
                    <td style="padding: 0.75rem; color: var(--text-muted);">
                        {{ $item->category?->name ?? 'Tanpa Kategori' }}
                    </td>
                    <td style="padding: 0.75rem; font-size: 0.85rem; color: var(--text-muted);">
                        {{ $item->deleted_at?->format('d M Y H:i') }}
                    </td>
                    <td style="padding: 0.75rem; text-align: right;">
                        <form action="{{ route('activities.restore', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Pulihkan kegiatan ini ke daftar aktif?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary" style="padding: 0.35rem 0.75rem; font-size: 0.85rem;">
                                Pulihkan
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 2.5rem; text-align: center; color: var(--text-muted);">
                        <p style="font-size: 1rem; margin-bottom: 0.25rem;">Tidak ada kegiatan di tong sampah.</p>
                        <p style="font-size: 0.85rem;">Seluruh kegiatan yang dihapus dengan soft delete akan muncul di sini.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-container">
    {{ $trashedActivities->links() }}
</div>
@endsection
