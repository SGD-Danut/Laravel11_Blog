<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">Admin</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pagini
            </li>

            <li class="sidebar-item active">
                <a class="sidebar-link" href="{{ route('admin.home') }}">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Acasa</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.users') }}">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Utilizatori</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.categories') }}">
                    <i class="align-middle" data-feather="list"></i> <span class="align-middle">Categorii</span>
                </a>
            </li>
        </ul>
    </div>
</nav>