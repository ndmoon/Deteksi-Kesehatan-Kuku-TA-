<div class="mt-4">
    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger"
                onclick="return confirm('Apakah kamu yakin ingin menghapus akun ini?')">
            Hapus Akun
        </button>
    </form>
</div>
