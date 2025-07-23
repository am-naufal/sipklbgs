<aside class="main-sidebar sidebar-bg-dark sidebar-color-primary shadow">
    <div class="brand-container">
        <a href="javascript:;" class="brand-link">
            <img src="{{ asset('assets/img/logopkl.png') }}" alt="SIPKL LOGO" class="brand-image opacity-80 shadow" />
            <span class="brand-text fw-light">SIPKL</span>
        </a>
        <a class="pushmenu mx-1" data-lte-toggle="sidebar-mini" href="javascript:;" role="button"><i
                class="fas fa-angle-double-left"></i></a>
    </div>
    <div class="sidebar">
        @if (Auth::user()->role == 'admin')
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.industris.index') }}"
                            class="nav-link {{ request()->is('admin/industris*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-industry"></i>
                            <p>Industri</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.siswas.index') }}"
                            class="nav-link {{ request()->is('admin/siswas*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-graduate"></i>
                            <p>Siswa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pembimbings.index') }}"
                            class="nav-link {{ request()->is('admin/pembimbings*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>Pembimbing</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.penempatans.index') }}"
                            class="nav-link {{ request()->is('admin/penempatans*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-map-marker-alt"></i>
                            <p>Penempatan</p>
                        </a>
                    <li class="nav-item">
                        <a href="{{ route('admin.laporans.index') }}"
                            class="nav-link {{ request()->is('admin/laporans*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Akhir</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.laporan-harian.index') }}"
                            class="nav-link {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Log book siswa</p>
                        </a>
                    </li>


                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                        <button type="submit"> <i class="nav-icon fas fa-sign-out-alt"></i> Logout</button>
                    </form>

                </ul>

            </nav>
        @elseif (Auth::user()->role == 'siswa')
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('siswa.dashboard') }}"
                            class="nav-link {{ request()->is('siswa/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('siswa.list-industri') }}"
                            class="nav-link {{ request()->is('siswa/industris*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-industry"></i>
                            <p>Industri</p>
                        </a>
                    </li>
                    <a href="/siswa/penempatans"
                        class="nav-link {{ request()->is('siswa/penempatans*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map-marker-alt"></i>
                        <p>Penempatan</p>
                    </a>
                    <li class="nav-item">
                        <a href="/siswa/laporan-harian"
                            class="nav-link {{ request()->is('siswa/laporan-harian*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Harian</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/siswa/laporan" class="nav-link {{ request()->is('siswa/laporan') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Akhir</p>
                        </a>
                    </li>


                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                        <button type="submit"> <i class="nav-icon fas fa-sign-out-alt"></i> Logout</button>
                    </form>

                </ul>

            </nav>
        @elseif (Auth::user()->role == 'pembimbing')
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('pembimbing.dashboard') }}"
                            class="nav-link {{ request()->is('pembimbing/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pembimbing.siswas.index') }}"
                            class="nav-link {{ request()->is('pembimbing/siswas*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-graduate"></i>
                            <p>Siswa Bimbingan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pembimbing.penempatans.index') }}"
                            class="nav-link {{ request()->is('pembimbing/penempatans*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-map-marker-alt"></i>
                            <p>Penempatan</p>
                        </a>
                    <li class="nav-item">
                        <a href="{{ route('pembimbing.laporans.index') }}"
                            class="nav-link {{ request()->is('pembimbing/laporans*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Akhir</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pembimbing.laporans.index') }}"
                            class="nav-link {{ request()->is('pembimbing/laporans*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Log Book Siswa</p>
                        </a>
                    </li>


                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                        <button type="submit"> <i class="nav-icon fas fa-sign-out-alt"></i> Logout</button>
                    </form>

                </ul>

            </nav>
        @endif
    </div>
</aside>
