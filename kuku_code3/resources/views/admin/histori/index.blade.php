@extends('admin.be.app')

@section('content')
<div class="container py-4">
    <h1 class="fw-bold mb-4">Histori</h1>

    <!-- Filter -->
    <div class="row mb-3 g-3">
        <div class="col-md-4">
            <label for="userFilter" class="form-label fw-medium">Filter User</label>
            <select id="userFilter" class="form-select">
                <option value="">-- Semua User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="startDate" class="form-label fw-medium">Dari Tanggal</label>
            <input type="date" id="startDate" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="endDate" class="form-label fw-medium">Sampai Tanggal</label>
            <input type="date" id="endDate" class="form-control">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button id="filterBtn" class="btn btn-primary w-100">
                <i class="bi bi-funnel-fill me-1"></i> Filter
            </button>
        </div>
    </div>

    <!-- Tabel histori -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <!-- <th>Nama</th> -->
                            <!-- <th>Usia</th> -->
                            <th>Kondisi Kuku</th>
                            <th>Gambar</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="historisTable">
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">
                                Silakan pilih filter untuk melihat histori
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <nav id="paginationLinks" class="d-flex justify-content-center mt-3"></nav>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function loadHistori(userId = '', start = '', end = '', pageUrl = "{{ route('admin.histori.filter') }}") {
        $.ajax({
            url: pageUrl,
            type: "GET",
            data: { user_id: userId, start_date: start, end_date: end },
            success: function(response) {
                let rows = '';
                if (response.data.length > 0) {
                    response.data.forEach(h => {
                        rows += `
                            <tr data-id="${h.id}">
                                <td>${h.user?.name ?? '-'}</td>
                                <td><span class="badge bg-secondary">${h.kondisi_kuku?.name ?? '-'}</span></td>
                                <td><img src="/storage/${h.image_path}" width="80" class="rounded"></td>
                                <td>${new Date(h.created_at).toLocaleString()}</td>
                                <td class="text-center">
                                    <a href="/admin/histori/${h.id}/edit" class="btn btn-outline-warning btn-sm me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm btn-delete" data-id="${h.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    rows = `<tr><td colspan="7" class="text-center py-3 text-muted">Tidak ada data histori</td></tr>`;
                }
                $('#historisTable').html(rows);

                // Pagination
                let pagination = '';
                if (response.links.prev) pagination += `<button class="btn btn-outline-primary me-2 page-btn" data-url="${response.links.prev}">« Prev</button>`;
                pagination += `<span class="mx-2">Halaman ${response.meta.current_page} dari ${response.meta.last_page}</span>`;
                if (response.links.next) pagination += `<button class="btn btn-outline-primary ms-2 page-btn" data-url="${response.links.next}">Next »</button>`;
                $('#paginationLinks').html(pagination);
            }
        });
    }

    // Event filter
    $('#filterBtn').on('click', function() {
        loadHistori($('#userFilter').val(), $('#startDate').val(), $('#endDate').val());
    });

    // Pagination
    $(document).on('click', '.page-btn', function() {
        loadHistori($('#userFilter').val(), $('#startDate').val(), $('#endDate').val(), $(this).data('url'));
    });

    // Hapus histori AJAX
    $(document).on('click', '.btn-delete', function() {
        let id = $(this).data('id');
        if (confirm('Yakin ingin menghapus data ini?')) {
            $.ajax({
                url: `/admin/histori/${id}`,
                type: 'POST',
                data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                success: function(res) {
                    if (res.success) {
                        $(`tr[data-id="${id}"]`).fadeOut(500, function(){ $(this).remove(); });
                        alert(res.message);
                    }
                }
            });
        }
    });

    // Load awal histori
    $(document).ready(function() {
        loadHistori();
    });
</script>
@endsection
