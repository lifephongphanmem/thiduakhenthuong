@if (chkPhanQuyen('qlkhenthuong', 'phanquyen'))
    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <i class="fas fa-folder"></i>
            </span>
            <span class="menu-text font-weight-bold">{{ chkGiaoDien('qlkhenthuong', 'tenchucnang') }}</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">

                @if (chkPhanQuyen('khenthuongcongtrang', 'phanquyen'))
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('khenthuongcongtrang', 'tenchucnang') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('dshosokhenthuongcongtrang', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongCongTrang/HoSoKT/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dshosokhenthuongcongtrang', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('dshosodenghikhenthuongcongtrang', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongCongTrang/HoSo/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dshosodenghikhenthuongcongtrang', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('xdhosodenghikhenthuongcongtrang', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongCongTrang/XetDuyet/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('xdhosodenghikhenthuongcongtrang', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('qdhosodenghikhenthuongcongtrang', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongCongTrang/KhenThuong/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('qdhosodenghikhenthuongcongtrang', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if (chkPhanQuyen('khenthuongchuyende', 'phanquyen'))
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('khenthuongchuyende', 'tenchucnang') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('dshosokhenthuongchuyende', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongChuyenDe/HoSo/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dshosokhenthuongchuyende', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('xdhosokhenthuongchuyende', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongChuyenDe/XetDuyet/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('xdhosokhenthuongchuyende', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('qdhosokhenthuongchuyende', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongChuyenDe/KhenThuong/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('qdhosokhenthuongchuyende', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if (chkPhanQuyen('khenthuongdotxuat', 'phanquyen'))
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('khenthuongdotxuat', 'tenchucnang') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('dshosokhenthuongdotxuat', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongDotXuat/HoSo/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dshosokhenthuongdotxuat', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('xdhosokhenthuongdotxuat', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongDotXuat/XetDuyet/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('xdhosokhenthuongdotxuat', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('qdhosokhenthuongdotxuat', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongDotXuat/KhenThuong/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('qdhosokhenthuongdotxuat', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if (chkPhanQuyen('khenthuongconghien', 'phanquyen'))
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('khenthuongconghien', 'tenchucnang') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('dshosokhenthuongconghien', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongCongHien/HoSo/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dshosokhenthuongconghien', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('xdhosokhenthuongconghien', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongCongHien/XetDuyet/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('xdhosokhenthuongconghien', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('qdhosokhenthuongconghien', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongCongHien/KhenThuong/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('qdhosokhenthuongconghien', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if (chkPhanQuyen('khenthuongnienhan', 'phanquyen'))
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('khenthuongnienhan', 'tenchucnang') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('dshosokhenthuongnienhan', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongNienHan/HoSo/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dshosokhenthuongnienhan', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('xdhosokhenthuongnienhan', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongNienHan/XetDuyet/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('xdhosokhenthuongnienhan', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('qdhosokhenthuongnienhan', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongNienHan/KhenThuong/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('qdhosokhenthuongnienhan', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if (chkPhanQuyen('khenthuongdoingoai', 'phanquyen'))
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('khenthuongdoingoai', 'tenchucnang') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('dshosokhenthuongdoingoai', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongDoiNgoai/HoSo/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dshosokhenthuongdoingoai', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('xdhosokhenthuongdoingoai', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongDoiNgoai/XetDuyet/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('xdhosokhenthuongdoingoai', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('qdhosokhenthuongdoingoai', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongDoiNgoai/KhenThuong/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('qdhosokhenthuongdoingoai', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </li>
@endif
