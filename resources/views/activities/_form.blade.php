@csrf

<div class="form-row-2">
    <div class="form-group">
        <label for="code">Kode Kegiatan</label>
        <input
            type="text"
            id="code"
            name="code"
            value="{{ old('code', $activity->code ?? '') }}"
            placeholder="Contoh: ACT-001"
            required
        >
        @error('code')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="category_id">Kategori Kegiatan</label>
        <select name="category_id" id="category_id" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(old('category_id', $activity->category_id ?? '') == $category->id)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="form-group">
    <label for="title">Judul Kegiatan</label>
    <input
        type="text"
        id="title"
        name="title"
        value="{{ old('title', $activity->title ?? '') }}"
        placeholder="Masukkan judul kegiatan (5-150 karakter)"
        required
    >
    @error('title')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="form-row-2">
    <div class="form-group">
        <label for="start_at">Tanggal Mulai</label>
        <input
            type="date"
            id="start_at"
            name="start_at"
            value="{{ old('start_at', isset($activity->start_at) ? $activity->start_at->format('Y-m-d') : '') }}"
            required
        >
        @error('start_at')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="end_at">Tanggal Selesai</label>
        <input
            type="date"
            id="end_at"
            name="end_at"
            value="{{ old('end_at', isset($activity->end_at) ? $activity->end_at->format('Y-m-d') : '') }}"
            required
        >
        @error('end_at')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="form-row-2-1">
    <div class="form-group">
        <label for="location">Lokasi Kegiatan</label>
        <input
            type="text"
            id="location"
            name="location"
            value="{{ old('location', $activity->location ?? '') }}"
            placeholder="Contoh: Auditorium Gedung D / Daring Zoom"
        >
        @error('location')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="capacity">Kapasitas Peserta (Maks. 500)</label>
        <input
            type="number"
            id="capacity"
            name="capacity"
            min="1"
            max="500"
            value="{{ old('capacity', $activity->capacity ?? 50) }}"
            required
        >
        @error('capacity')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="form-group">
    <label for="description">Deskripsi Lengkap (Opsional)</label>
    <textarea
        id="description"
        name="description"
        rows="4"
        placeholder="Tuliskan keterangan detail mengenai kegiatan ini..."
    >{{ old('description', $activity->description ?? '') }}</textarea>
    @error('description')
        <p class="error">{{ $message }}</p>
    @enderror
</div>
