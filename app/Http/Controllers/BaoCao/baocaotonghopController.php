<?php

namespace App\Http\Controllers\BaoCao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class baocaotonghopController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('baocaotapthe', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'baocaotapthe')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = '/BaoCao/TongHop/';
        $m_donvi = getDonVi(session('admin')->capdo, 'baocaotapthe');
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $m_diaban = getDiaBanBaoCaoTongHop($donvi);
        return view('BaoCao.TongHop.ThongTin')
            ->with('m_diaban', $m_diaban)
            ->with('m_donvi', $m_donvi)
            ->with('inputs', $inputs)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_diaban', array_column($m_diaban->toArray(), 'tendiaban', 'madiaban'))
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_phamvithongke', getPhamViThongKe($donvi->capdo))
            ->with('pageTitle', 'Báo cáo tổng hợp');
    }

    public function PhongTrao(Request $request)
    {
        $inputs = $request->all();
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_diaban = getDiaBanBaoCaoTongHop($donvi);
        // if ($inputs['madiaban'] != 'ALL') {
        //     $m_diaban = $m_diaban->where('madiaban', $inputs['madiaban']);
        // }
        $a_donvi = dsdonvi::wherein('madiaban', array_column($m_diaban->toarray(), 'madiaban'))->get('madonvi');
        $model = getDSPhongTrao($donvi);
        //dd($inputs);
        //Lọc thời gian khen thưởng
        //ngayqd
        $m_hoso = dshosothiduakhenthuong::wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))
            //->wherein('madonvi',$a_donvi) //bỏ thống theo từng địa bàn
            ->wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])
            ->where('trangthai', 'DKT')->get();

        //dd($m_hoso);
        //hình thức khen thưởng cấp xã
        $m_hoso_xa = $m_hoso->where('capkhenthuong', 'X');
        $m_chitiet_xa_canhan = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($m_hoso_xa->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $m_chitiet_xa_tapthe = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($m_hoso_xa->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();

        $a_hinhthuckt_xa = array_unique(
            array_merge(
                array_column($m_chitiet_xa_canhan->toarray(), 'mahinhthuckt'),
                array_column($m_chitiet_xa_tapthe->toarray(), 'mahinhthuckt')
            )
        );
        //Hình thức khent thưởng cấp Huyện
        $m_hoso_huyen = $m_hoso->where('capkhenthuong', 'H');
        $m_chitiet_huyen_canhan = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($m_hoso_huyen->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $m_chitiet_huyen_tapthe = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($m_hoso_huyen->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();

        $a_hinhthuckt_huyen = array_unique(
            array_merge(
                array_column($m_chitiet_huyen_canhan->toarray(), 'mahinhthuckt'),
                array_column($m_chitiet_huyen_tapthe->toarray(), 'mahinhthuckt')
            )
        );
        //Hình thức khen thưởng cấp Tỉnh
        $m_hoso_tinh = $m_hoso->where('capkhenthuong', 'T');
        $m_chitiet_tinh_canhan = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($m_hoso_tinh->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $m_chitiet_tinh_tapthe = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($m_hoso_tinh->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();

        $a_hinhthuckt_tinh = array_unique(
            array_merge(
                array_column($m_chitiet_tinh_canhan->toarray(), 'mahinhthuckt'),
                array_column($m_chitiet_tinh_tapthe->toarray(), 'mahinhthuckt')
            )
        );
        foreach ($model as $ct) {
            $ct->tongcong = 0;
            //Thống kê khen thưởng cấp Xã
            foreach ($a_hinhthuckt_xa as $ma) {
                $ct->$ma = $m_chitiet_xa_canhan->where('mahinhthuckt', $ma)->count()
                    + $m_chitiet_xa_tapthe->where('mahinhthuckt', $ma)->count();

                $ct->tongcong += $ct->$ma;
            }
            //Thống kê khen thưởng cấp Huyện
            foreach ($a_hinhthuckt_huyen as $ma) {
                $ct->$ma = $m_chitiet_huyen_canhan->where('mahinhthuckt', $ma)->count()
                    + $m_chitiet_huyen_tapthe->where('mahinhthuckt', $ma)->count();

                $ct->tongcong += $ct->$ma;
            }
            //Thống kê khen thưởng cấp Tỉnh
            foreach ($a_hinhthuckt_tinh as $ma) {
                $ct->$ma = $m_chitiet_tinh_canhan->where('mahinhthuckt', $ma)->count()
                    + $m_chitiet_tinh_tapthe->where('mahinhthuckt', $ma)->count();

                $ct->tongcong += $ct->$ma;
            }
        }
        //Thông tin đơn vị
        $m_donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.PhongTrao')
            ->with('model', $model)
            ->with('a_hinhthuckt_xa', $a_hinhthuckt_xa)
            ->with('a_hinhthuckt_huyen', $a_hinhthuckt_huyen)
            ->with('a_hinhthuckt_tinh', $a_hinhthuckt_tinh)
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('m_donvi', $m_donvi)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }

    public function HoSo(Request $request)
    {
        $inputs = $request->all();
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_diaban = getDiaBanBaoCaoTongHop($donvi);
        if ($inputs['madiaban'] != 'ALL') {
            $m_diaban = $m_diaban->where('madiaban', $inputs['madiaban']);
        }
        $model = viewdiabandonvi::wherein('madiaban', array_column($m_diaban->toArray(), 'madiaban'))->get();
        if ($inputs['phamvithongke'] != 'ALL') {
            $model = $model->where('capdo', $inputs['phamvithongke']);
        }
        $m_hoso = dshosothiduakhenthuong::wherenotin('trangthai', ['CC', 'BTL'])
            ->wherebetween('ngayhoso', [$inputs['ngaytu'], $inputs['ngayden']])
            ->wherein('madonvi', array_column($model->toArray(), 'madonvi'))->get();

        $m_loaihinhkt = getLoaiHinhKhenThuong();
        $a_diaban = array_column($model->toArray(), 'tendiaban', 'madiaban');
        foreach ($model as $ct) {
            foreach ($m_loaihinhkt as $loaihinh) {
                $maloaihinhkt = $loaihinh->maloaihinhkt;
                $ct->$maloaihinhkt = $m_hoso->where('madonvi', $ct->madonvi)->where('maloaihinhkt', $maloaihinhkt)->count();
            }
        }

        //Thông tin đơn vị
        $m_donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.HoSo')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('a_diaban', $a_diaban)
            ->with('a_loaihinhkt', array_column($m_loaihinhkt->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp hồ sơ thi đua, khen thưởng');
    }

    //bỏ
    public function DanhHieu(Request $request)
    {
        //Không bao gồm các hồ sơ cụm khối thi đua
        $inputs = $request->all();
        $m_hoso = dshosothiduakhenthuong::wherenotin('trangthai', ['CC', 'BTL'])->get();
        $m_khenthuong = dshosokhenthuong_khenthuong::all();
        foreach ($m_khenthuong as $khenthuong) {
            $khenthuong->madonvi = $m_hoso->where('mahosotdkt', $khenthuong->mahosotdkt)->first()->madonvi ?? null;
        }
        $m_khenthuong = $m_khenthuong->where('madonvi', '<>', null);
        $model = viewdiabandonvi::wherein('madonvi', array_column($m_khenthuong->toArray(), 'madonvi'))->get();
        $m_danhhieu = dmdanhhieuthidua::wherein('madanhhieutd', array_column($m_khenthuong->toArray(), 'madanhhieutd'))->get();

        //$m_loaihinhkt = getLoaiHinhKhenThuong();
        $a_diaban = array_column($model->toArray(), 'tendiaban', 'madiaban');
        foreach ($model as $ct) {
            foreach ($m_danhhieu as $danhhieu) {
                $madanhhieutd = (string)$danhhieu->madanhhieutd;
                $ct->$madanhhieutd = $m_khenthuong->where('madonvi', $ct->madonvi)->where('madanhhieutd', $madanhhieutd)->count();
            }
        }
        //dd($model);
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.DanhHieu')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('a_diaban', $a_diaban)
            ->with('a_danhhieutd', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp danh hiệu thi đua');
    }

    public function KhenThuong_m1(Request $request)
    {
        $inputs = $request->all();
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_diaban = getDiaBanBaoCaoTongHop($donvi);
        if ($inputs['madiaban'] != 'ALL') {
            $m_diaban = $m_diaban->where('madiaban', $inputs['madiaban']);
        }
        $model = viewdiabandonvi::wherein('madiaban', array_column($m_diaban->toArray(), 'madiaban'))->get();
        if ($inputs['phamvithongke'] != 'ALL') {
            $model = $model->where('capdo', $inputs['phamvithongke']);
        }
        $m_hoso = dshosothiduakhenthuong::wherenotin('trangthai', ['CC', 'BTL'])
            ->wherebetween('ngayhoso', [$inputs['ngaytu'], $inputs['ngayden']])
            ->wherein('madonvi', array_column($model->toArray(), 'madonvi'))->get();
        $m_hoso_canhan = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->get();
        $m_hoso_tapthe = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->get();
        $m_hinhthuckt = dmhinhthuckhenthuong::all();
        $a_diaban = array_column($model->toArray(), 'tendiaban', 'madiaban');
        // dd($m_hinhthuckt);
        foreach ($model as $ct) {
            $hoso = $m_hoso->where('madonvi', $ct->madonvi);
            $m_canhan = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($hoso->toarray(), 'mahosotdkt'))->get();
            $m_tapthe = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($hoso->toarray(), 'mahosotdkt'))->get();
            $ct->tongso = $m_canhan->count() + $m_tapthe->count();
            // if($m_canhan->count() > 0){
            //     dd($m_canhan);
            // }

            foreach ($m_hinhthuckt as $loaihinh) {
                $mahinhthuckt = $loaihinh->mahinhthuckt;
                $ct->$mahinhthuckt = $m_canhan->where('mahinhthuckt', $mahinhthuckt)->count() + $m_tapthe->where('mahinhthuckt', $mahinhthuckt)->count();
            }
        }
        $m_hinhthuc = dmhinhthuckhenthuong::wherein('mahinhthuckt', array_merge(array_column($m_hoso_canhan->toarray(), 'mahinhthuckt'), array_column($m_hoso_tapthe->toarray(), 'mahinhthuckt')))->get();

        //dd($model);
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.KhenThuong')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('a_diaban', $a_diaban)
            ->with('a_danhhieutd', array_column($m_hinhthuc->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp danh hiệu thi đua');
    }

    public function KhenThuong_m2(Request $request)
    {
        $inputs = $request->all();
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_diaban = getDiaBanBaoCaoTongHop($donvi);
        if ($inputs['madiaban'] != 'ALL') {
            $m_diaban = $m_diaban->where('madiaban', $inputs['madiaban']);
        }
        $m_donvi = viewdiabandonvi::wherein('madiaban', array_column($m_diaban->toArray(), 'madiaban'))->get();
        if ($inputs['phamvithongke'] != 'ALL') {
            $m_donvi = $m_donvi->where('capdo', $inputs['phamvithongke']);
        }
        $m_hoso = dshosothiduakhenthuong::wherenotin('trangthai', ['CC', 'BTL'])
            ->wherebetween('ngayhoso', [$inputs['ngaytu'], $inputs['ngayden']])
            ->wherein('madonvi', array_column($m_donvi->toArray(), 'madonvi'))
            ->wherein('maloaihinhkt', ['1650358223', '1650358255', '1650358265', '1650358310'])
            ->get();
        $m_hoso_canhan = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->get();
        $m_hoso_tapthe = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->get();
        $model = dmhinhthuckhenthuong::wherein('mahinhthuckt', array_unique(array_merge(array_column($m_hoso_canhan->toarray(), 'mahinhthuckt'), array_column($m_hoso_tapthe->toarray(), 'mahinhthuckt'))))->get();
        $m_loaihinhkt = dmloaihinhkhenthuong::wherein('maloaihinhkt', array_unique(array_column($m_hoso->toarray(), 'maloaihinhkt')))->get();

        //tạm thời fix cứng sau làm lại để tự động
        //Loại hình khen thưởng -- maloaihinhkt
        // 1650358223	Khen thưởng theo công trạng và thành tích
        // 1650358255	Khen thưởng theo đợt (hoặc chuyên đề)
        // 1650358265	Khen thưởng đột xuất
        // 1650358282	Khen thưởng theo quá trình cống hiến
        // 1650358297	Khen thưởng theo niên hạn
        // 1650358310	Khen thưởng đối ngoại

        //Phân loại cán bộ
        // manhomphanloai	tennhomphanloai
        // TAPTHE	Tập thể
        // HOGIADINH	Hộ gia đình
        // CANHAN	Cá nhân


        //manhomphanloai	maphanloai	tenphanloai
        // TAPTHE	1660638226	Cơ quan hành chính, sự nghiệp
        // TAPTHE	1660638247	Doanh nghiệp
        // HOGIADINH	1660638538	Hộ gia đình
        // CANHAN	1660638808	Lãnh đạo cấp bộ, cấp tỉnh và tương đương trở lên
        // CANHAN	1660638843	Lãnh đạo cấp vụ, sở, ngành và tương đương
        // CANHAN	1660638864	Doanh nhân
        // CANHAN	1660638930	Các cấp lãnh đạo từ phó phòng trở lên
        // CANHAN	1660638976	Người trực tiếp công tác, lao động, học tập, chiến đấu và phục vụ chiến đấu

        foreach ($model as $chitiet) {
            //Nhóm công trạng
            $hoso_congtrang = $m_hoso->wherein('maloaihinhkt', ['1650358223']);
            $canhan_congtrang = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($hoso_congtrang->toarray(), 'mahosotdkt'))
                ->where('mahinhthuckt', $chitiet->mahinhthuckt)->get();
            $tapthe_congtrang = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($hoso_congtrang->toarray(), 'mahosotdkt'))
                ->where('mahinhthuckt', $chitiet->mahinhthuckt)->get();

            $chitiet->tongso_cotr = $canhan_congtrang->count() + $tapthe_congtrang->count();
            $chitiet->canhan_lada_cotr = $canhan_congtrang->wherein('maphanloaicanbo', ['1660638930', '1660638843', '1660638808'])->count();
            $chitiet->canhan_lado_cotr = $canhan_congtrang->wherein('maphanloaicanbo', ['1660638976'])->count();
            //Nhóm chuyên đề, đột xuất
            $hoso_chuyende = $m_hoso->wherein('maloaihinhkt', ['1650358255', '1650358265']);
            $canhan_chuyende = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($hoso_chuyende->toarray(), 'mahosotdkt'))
                ->where('mahinhthuckt', $chitiet->mahinhthuckt)->get();
            $tapthe_chuyende = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($hoso_chuyende->toarray(), 'mahosotdkt'))
                ->where('mahinhthuckt', $chitiet->mahinhthuckt)->get();

            $chitiet->tongso_chde = $canhan_chuyende->count() + $tapthe_chuyende->count();
            $chitiet->canhan_lada_chde = $canhan_chuyende->wherein('maphanloaicanbo', ['1660638930', '1660638843', '1660638808'])->count();
            $chitiet->canhan_lado_chde = $canhan_chuyende->wherein('maphanloaicanbo', ['1660638976'])->count();
            //Nhóm đối ngoại
            $hoso_dongo = $m_hoso->wherein('maloaihinhkt', ['1650358297']);
            $canhan_dongo = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($hoso_dongo->toarray(), 'mahosotdkt'))
                ->where('mahinhthuckt', $chitiet->mahinhthuckt)->get();
            $tapthe_dongo = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($hoso_dongo->toarray(), 'mahosotdkt'))
                ->where('mahinhthuckt', $chitiet->mahinhthuckt)->get();

            $chitiet->tongso_dongo = $canhan_dongo->count() + $tapthe_dongo->count();

            //Gán tổng cộng
            $chitiet->tongso = $chitiet->tongso_cotr + $chitiet->tongso_chde + $chitiet->tongso_dongo;
            $chitiet->tongdn = $tapthe_congtrang->where('maphanloaitapthe', '1660638247')->count()
                + $tapthe_chuyende->where('maphanloaitapthe', '1660638247')->count()
                + $tapthe_dongo->where('maphanloaitapthe', '1660638247')->count();
            $chitiet->tongcn = $canhan_congtrang->count() + $canhan_chuyende->count() +  $canhan_dongo->count();
        }


        //dd($model);
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.KhenThuong_m2')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            //->with('a_diaban', $a_diaban)
            //->with('a_danhhieutd', array_column($m_hinhthuc->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp hình thức khen thưởng');
    }

    public function Mau0701(Request $request)
    {
        $inputs = $request->all();
        $model = dsphongtraothidua::all();
        $m_donvi = viewdiabandonvi::wherein('madonvi', array_column($model->toArray(), 'madonvi'))->get();
        $a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');
        foreach ($model as $ct) {
            $ct->madiaban = $m_donvi->where('madonvi', $ct->madonvi)->first()->madiaban;
        }
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.Mau0701TT03')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('a_diaban', $a_diaban)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }

    public function Mau0702(Request $request)
    {
        $inputs = $request->all();
        $model = dsphongtraothidua::all();
        $m_donvi = viewdiabandonvi::wherein('madonvi', array_column($model->toArray(), 'madonvi'))->get();
        $a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');
        foreach ($model as $ct) {
            $ct->madiaban = $m_donvi->where('madonvi', $ct->madonvi)->first()->madiaban;
        }
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.Mau0702TT03')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('a_diaban', $a_diaban)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }

    public function Mau0703(Request $request)
    {
        $inputs = $request->all();
        $model = dsphongtraothidua::all();
        $m_donvi = viewdiabandonvi::wherein('madonvi', array_column($model->toArray(), 'madonvi'))->get();
        $a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');
        foreach ($model as $ct) {
            $ct->madiaban = $m_donvi->where('madonvi', $ct->madonvi)->first()->madiaban;
        }
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.Mau0703TT03')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('a_diaban', $a_diaban)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }
}
