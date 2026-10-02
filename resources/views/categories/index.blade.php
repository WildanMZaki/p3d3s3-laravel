@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h2>Kelola Kategori</h2>
    <a href="{{ route('activities.index') }}" class="btn btn-secondary">&larr; Kembali ke Kegiatan</a>
</div>

<div class="card" style="margin-bottom: 2rem;">
    <h3 style="margin-bottom: 1rem;">Tambah Kategori Baru</h3>
    <form action="{{ route('categories.store') }}" method="POST" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
        @csrf
        <div style="flex: 1; min-width: 250px;">
            <label for="name">Nama Kategori</label>
            <input type="text" id="name" name="name" placeholder="Misal: Webinar, Sertifikasi" required>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">+ Simpan Kategori</button>
        </div>
    </form>
</div>

<div class="card">
    <h3 style="margin-bottom: 1rem;">Daftar Kategori</h3>
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid var(--border-color);">
                <th style="padding: 0.75rem;">ID</th>
                <th style="padding: 0.75rem;">Nama</th>
                <th style="padding: 0.75rem;">Slug</th>
                <th style="padding: 0.75rem;">Jumlah Kegiatan Terkait</th>
                <th style="padding: 0.75rem; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $cat)
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 0.75rem;">{{ $cat->id }}</td>
                    <td style="padding: 0.75rem; font-weight: 600;">{{ $cat->name }}</td>
                    <td style="padding: 0.75rem; color: var(--text-muted);">{{ $cat->slug }}</td>
                    <td style="padding: 0.75rem;">
                        <span style="background: #e2e8f0; padding: 2px 8px; border-radius: 4px; font-size: 0.85rem;">
                            {{ $cat->activities_count }} kegiatan
                        </span>
                    </td>
                    <td style="padding: 0.75rem; text-align: right;">
                        <form action="{{ route('categories.destroy', $cat) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $cat->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 1rem; text-align: center; color: var(--text-muted);">
                        Belum ada kategori yang terdaftar.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
