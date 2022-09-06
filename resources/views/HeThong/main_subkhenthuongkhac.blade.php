@if (chkPhanQuyen('khenthuongkhac', 'phanquyen'))
    <li class="menu-section">
        <h4 class="menu-text">Khen thưởng khác</h4>
        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>
    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <i class="fas fa-folder"></i>
            </span>
            <span class="menu-text font-weight-bold">{{ chkGiaoDien('khenthuongkhac', 'tenchucnang') }}</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                {{-- <li class="menu-item" aria-haspopup="true">
                <a href="{{ url('/CumKhoiThiDua/DanhSach/ThongTin') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text font-weight-bold">Hiệp y khen thưởng</span>
                </a>
            </li> --}}
                @if (chkPhanQuyen('khenthuongkhangchien', 'phanquyen'))
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text font-weight-bold">{{ chkGiaoDien('khenthuongkhangchien', 'tenchucnang') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('khenthuongchongphapcanhan', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongKhangChien/ChongPhapCaNhan/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('khenthuongchongphapcanhan', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('khenthuongchongmycanhan', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongKhangChien/ChongMyCaNhan/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('khenthuongchongmycanhan', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('khenthuongchongmygiadinh', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongKhangChien/ChongMyGiaDinh/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('khenthuongchongmygiadinh', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('bangkhenthutuong', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongKhangChien/BangKhenThuThuong/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('bangkhenthutuong', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('bangkhenchutichtinh', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongKhangChien/BangKhenTinh/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('bangkhenchutichtinh', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('kyniemchuong', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenThuongKhangChien/KyNiemChuong/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('kyniemchuong', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if (chkPhanQuyen('khencao', 'phanquyen'))
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text font-weight-bold">{{ chkGiaoDien('khencao', 'tenchucnang') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('tracuutimkiem', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/KhenCao/HoSo/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dshosokhencao', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                {{-- <li class="menu-item" aria-haspopup="true">
                            <a href="{{ url('/CumKhoiThiDua/XetDuyetHoSoKhenThuong/ThongTin') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Duyệt hồ sơ đề nghị khen thưởng</span>
                            </a>
                        </li> --}}
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </li>
@endif
