<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-header bg-white fw-bold">
        <i class="bi bi-person-circle me-2"></i> Perbarui Informasi Profil
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            {{-- Nama --}}
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', Auth::user()->name) }}"
                       class="form-control @error('name') is-invalid @enderror"
                       required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" name="email" id="email"
                       value="{{ old('email', Auth::user()->email) }}"
                       class="form-control @error('email') is-invalid @enderror"
                       required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if (!Auth::user()->hasVerifiedEmail())
                    <div class="alert alert-warning mt-2 p-2 small">
                        <i class="bi bi-exclamation-circle"></i>
                        Email Anda belum terverifikasi.
                        <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                Kirim Ulang Verifikasi
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Tombol Submit --}}
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>