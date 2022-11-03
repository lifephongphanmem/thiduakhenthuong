@if (chkPhanQuyen('cumkhoithidua', 'phanquyen'))
    <li class="menu-section">
        <h4 class="menu-text">Cụm khối thi đua</h4>
        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>

    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <i class="fas fa-folder"></i>
            </span>
            <span class="menu-text font-weight-bold">{{ chkGiaoDien('cumkhoithidua', 'tenchucnang') }}</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                @if (chkPhanQuyen('quanlycumkhoi', 'phanquyen'))


                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('quanlycumkhoi', 'tenchucnang') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('dscumkhoithidua', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/CumKhoiThiDua/CumKhoi/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dscumkhoithidua', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('dstruongcumkhoi', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/CumKhoiThiDua/TruongCumKhoi/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dstruongcumkhoi', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if (chkPhanQuyen('dsphongtraothiduacumkhoi', 'phanquyen'))
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ url('/CumKhoiThiDua/PhongTraoThiDua/ThongTin') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('dsphongtraothiduacumkhoi', 'tenchucnang') }}</span>
                        </a>
                    </li>
                @endif

                @if (chkPhanQuyen('giaouocthiduacumkhoi', 'phanquyen'))
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('giaouocthiduacumkhoi', 'tenchucnang') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('dsgiaouocthiduacumkhoi', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/GiaoUocThiDua/HoSo/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dsgiaouocthiduacumkhoi', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('xdgiaouocthiduacumkhoi', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/GiaoUocThiDua/XetDuyet/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('xdgiaouocthiduacumkhoi', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif

                @if (chkPhanQuyen('khenthuongcumkhoi', 'phanquyen'))
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('khenthuongcumkhoi', 'tenchucnang') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('dshosokhenthuongcumkhoi', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/CumKhoiThiDua/KTCumKhoi/HoSoKT/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dshosokhenthuongcumkhoi', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/CumKhoiThiDua/KTCumKhoi/HoSo/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dshosodenghikhenthuongcumkhoi', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('xdhosokhenthuongcumkhoi', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/CumKhoiThiDua/KTCumKhoi/XetDuyet/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('xdhosokhenthuongcumkhoi', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('qdhosokhenthuongcumkhoi', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/CumKhoiThiDua/KTCumKhoi/KhenThuong/ThongTin') }}"
                                            class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('qdhosokhenthuongcumkhoi', 'tenchucnang') }}</span>
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
