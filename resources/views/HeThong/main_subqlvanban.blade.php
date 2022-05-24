<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="svg-icon menu-icon">
            <i class="fas fa-folder"></i>
        </span>
        <span class="menu-text font-weight-bold">Quản lý văn bản pháp lý, tài liệu</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            <li class="menu-item" aria-haspopup="true">
                <a href="{{ url('/QuanLyVanBan/VanBanPhapLy/ThongTin') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text font-weight-bold">Văn bản pháp lý</span>
                </a>
            </li>
            <li class="menu-item" aria-haspopup="true">
                <a href="{{ url('/QuanLyVanBan/KhenThuong/ThongTin') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text font-weight-bold">Quyết định khen thưởng</span>
                </a>
            </li>

            {{-- <li class="menu-item" aria-haspopup="true">
                <a href="{{ url('/QuanLyVanBan/VanBanPhapLy/ThongTin') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text font-weight-bold">Hỏi, đáp</span>
                </a>
            </li> --}}
        </ul>
    </div>
</li>
