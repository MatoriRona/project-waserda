<div class="nk-sidebar">           
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label"><b>Welcome {{ auth()->user()->name }}</b></li>
            <li>
                <a href="{{ route('dashboard') }}" aria-expanded="false">
                    <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
            @if (auth()->user()->role != 'kasir')
            <li class="nav-label">Apps</li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Data Master</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('jenis-barang.index') }}">Jenis Barang</a></li>
                    <li><a href="{{ route('barang.index') }}">Barang</a></li>
                    <li><a href="{{ route('users.index') }}">User</a></li>
                    <li><a href="{{ route('suplier.index') }}">Suplier</a></li>
                </ul>
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-cubes menu-icon"></i><span class="nav-text">Manajemen Stok</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('stok.masuk.index') }}">Stok Masuk</a></li>
                    <li><a href="{{ route('stok.keluar.index') }}">Stok Keluar</a></li>
                </ul>
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-file menu-icon"></i><span class="nav-text">Laporan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('transaksi.view') }}">Transaksi</a></li>
                </ul>
            </li>
            @endif
            @if (auth()->user()->role != 'pimpinan')
            <li>
                <a href="{{ route('transaksi.index') }}" aria-expanded="false">
                    <i class="fa fa-shopping-cart menu-icon"></i><span class="nav-text">Transaksi</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>