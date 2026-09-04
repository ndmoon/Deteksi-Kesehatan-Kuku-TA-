<div class="header">
    <!-- Tombol toggle sidebar -->
    <button id="sidebarToggle" class="btn btn-outline-secondary d-lg-none">
        <i class="bi bi-list"></i> <!-- Bootstrap Icons -->
    </button>

    <h4 class="ms-2">Admin Panel</h4>

    <div>
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="btn btn-danger btn-sm">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>
