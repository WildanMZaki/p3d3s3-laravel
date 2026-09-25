@csrf

<div class="form-group">
    <label for="title">Judul Kegiatan</label>
    <input
        type="text"
        id="title"
        name="title"
        value="{{ old('title', $activity->title ?? '') }}"
        placeholder="Masukkan judul kegiatan (5-100 karakter)"
        required
    >
    @error('title')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="category">Kategori</label>
    <input
        type="text"
        id="category"
        name="category"
        value="{{ old('category', $activity->category ?? '') }}"
        placeholder="Contoh: Workshop, Seminar, Praktikum"
        required
    >
    @error('category')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="activity_date">Tanggal Kegiatan</label>
    <input
        type="date"
        id="activity_date"
        name="activity_date"
        value="{{ old('activity_date', isset($activity->activity_date) ? $activity->activity_date->format('Y-m-d') : '') }}"
        required
    >
    @error('activity_date')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select name="status" id="status" required>
        @foreach (['Planned', 'Ongoing', 'Done'] as $optStatus)
            <option
                value="{{ $optStatus }}"
                @selected(old('status', $activity->status ?? 'Planned') === $optStatus)
            >
                {{ $optStatus }}
            </option>
        @endforeach
    </select>
    @error('status')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="description">Deskripsi Ringkas (Opsional)</label>
    <textarea
        id="description"
        name="description"
        rows="4"
        placeholder="Tuliskan keterangan kegiatan jika ada"
    >{{ old('description', $activity->description ?? '') }}</textarea>
    @error('description')
        <p class="error">{{ $message }}</p>
    @enderror
</div>
