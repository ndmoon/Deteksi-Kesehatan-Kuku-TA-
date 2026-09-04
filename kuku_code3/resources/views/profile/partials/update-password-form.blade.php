<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-header bg-white fw-bold">
        <i class="bi bi-shield-lock me-2"></i> Ubah Password
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            {{-- Password Lama --}}
            <div class="mb-3">
                <label for="current_password" class="form-label fw-semibold">Password Lama</label>
                <input type="password" name="current_password" id="current_password"
                       class="form-control @error('current_password') is-invalid @enderror"
                       required autocomplete="current-password">
                @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password Baru</label>
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control"
                       required autocomplete="new-password">
            </div>

            {{-- Tombol Simpan --}}
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-key-fill"></i> Perbarui Password
                </button>
            </div>
        </form>
    </div>
</div>