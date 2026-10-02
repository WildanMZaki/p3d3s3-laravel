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
            <p style="color: #334155;">
                <strong>{{ $activity->registered_count }}</strong> / {{ $activity->capacity }} peserta terdaftar
                @if ($activity->capacity > 0)
                    <span style="font-size: 0.85rem; color: var(--text-muted);">
                        ({{ round(($activity->registered_count / $activity->capacity) * 100) }}% terisi)
                    </span>
                @endif
            </p>
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

    {{-- Pendaftaran Peserta --}}
    <div style="border-top: 2px solid var(--border-color); padding-top: 1.5rem; margin-top: 1.5rem; margin-bottom: 1.5rem;">
        <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #0f172a;">Pendaftaran Peserta</h3>

        @if ($activity->status === 'published')
            @if ($activity->start_at && \Illuminate\Support\Carbon::parse($activity->start_at)->isPast())
                <div style="background: #f1f5f9; border-left: 4px solid #64748b; padding: 0.75rem 1rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.9rem;">
                    Pendaftaran telah ditutup karena waktu kegiatan sudah lewat atau sedang berlangsung.
                </div>
            @elseif ($activity->registered_count >= $activity->capacity)
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 0.75rem 1rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.9rem; color: #991b1b;">
                    Kuota pendaftaran untuk kegiatan ini telah penuh ({{ $activity->capacity }} peserta).
                </div>
            @else
                <form action="{{ route('activities.registrations.store', $activity) }}" method="POST" style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: 8px; padding: 1.25rem; margin-bottom: 1.5rem;">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 0.75rem; align-items: flex-end;">
                        <div>
                            <label for="participant_name" style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem; display: block;">Nama Lengkap Peserta</label>
                            <input type="text" name="participant_name" id="participant_name" value="{{ old('participant_name') }}" placeholder="Contoh: Budi Santoso" required style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.9rem;">
                        </div>
                        <div>
                            <label for="email" style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem; display: block;">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="budi@example.com" required style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.9rem;">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary" style="white-space: nowrap; height: 38px;">
                                Daftar Kegiatan
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        @elseif ($activity->status === 'draft')
            <div style="background: #fefce8; border-left: 4px solid #eab308; padding: 0.75rem 1rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.9rem; color: #854d0e;">
                Kegiatan masih berstatus <strong>Draft</strong>. Publikasikan kegiatan terlebih dahulu agar peserta dapat mendaftar.
            </div>
        @else
            <div style="background: #f1f5f9; border-left: 4px solid #64748b; padding: 0.75rem 1rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.9rem; color: #334155;">
                Kegiatan ini telah selesai (<strong>Completed</strong>). Pendaftaran peserta sudah tidak aktif.
            </div>
        @endif

        {{-- Daftar Peserta yang Sudah Mendaftar --}}
        <div style="margin-top: 1.25rem;">
            <h4 style="font-size: 1rem; margin-bottom: 0.5rem; color: #334155;">Daftar Peserta Terdaftar ({{ $activity->registrations->count() }})</h4>
            @if ($activity->registrations->isNotEmpty())
                <div style="overflow-x: auto; border: 1px solid var(--border-color); border-radius: 6px; background: #fff;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left;">
                        <thead>
                            <tr style="background-color: #f1f5f9; border-bottom: 1px solid var(--border-color);">
                                <th style="padding: 0.5rem 0.75rem; width: 40px;">#</th>
                                <th style="padding: 0.5rem 0.75rem;">Nama Peserta</th>
                                <th style="padding: 0.5rem 0.75rem;">Email</th>
                                <th style="padding: 0.5rem 0.75rem;">Waktu Pendaftaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activity->registrations as $index => $registration)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 0.5rem 0.75rem; color: var(--text-muted);">{{ $index + 1 }}</td>
                                    <td style="padding: 0.5rem 0.75rem; font-weight: 500;">{{ $registration->participant_name }}</td>
                                    <td style="padding: 0.5rem 0.75rem; color: var(--text-muted);">{{ $registration->email }}</td>
                                    <td style="padding: 0.5rem 0.75rem; color: var(--text-muted);">{{ $registration->registered_at?->format('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="color: var(--text-muted); font-size: 0.875rem; font-style: italic;">Belum ada peserta yang mendaftar pada kegiatan ini.</p>
            @endif
        </div>
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
