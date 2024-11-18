<?php

namespace App\Http\Controllers\ThongBao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class thongbaoController extends Controller
{
    public static $url = '/ThongBao/';
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
        $inputs = $request->all();
        $inputs['phanloai'] = $inputs['phanloai'] ?? '';
        $phanloai = array(
            'phongtraothidua' => 'Phong trào thi đua',
            'quanly' => 'Quản lý khen thưởng',
            'cumkhoi' => 'Cụm khối thi đua'
        );

        return view('ThongBao.ThongTin')
            ->with('inputs', $inputs)
            ->with('phanloai', $phanloai)
            ->with('pageTitle', 'Thông tin thông báo');
    }

    public function getphanloai(Request $request)
    {
        $inputs = $request->all();
         $result['status'] = 'success';
        $a_chucnang = array(
            'phongtraothidua' => [
                'dsphongtraothidua' => 'Phong trào thi đua',
                'khenthuongphongtrao' => 'Khen thưởng theo phong trào thi đua'

            ],
            'quanly' => [
                'congtrang' => 'Khen thưởng công trạng',
                'chuyende' => 'Khen thưởng theo đợt hoặc chuyên đề',
                'dotxuat' => 'Khen thưởng đột xuất',
                'conghien' => 'Khen thưởng theo quá trình cống hiến',
                'doingoai' => 'Khen thưởng đối ngoại'
            ],
            'cumkhoi' => [
                'dsphongtraothiduacumkhoi' => 'Phong trào thi đua cụm khối',
                'khenthuongcumkhoi' => 'Khen thưởng cụm khối'
            ]
        );
        $result['message'] = '<div class="col-md-6" id="phanloai_ct">';
        $result['message'] .= '<label style="font-weight: bold">Chức năng</label>';
        $result['message'] .= '<select name="phanloai-ct" id="phanloai_ct" class="form-control" onchange="getphanloai_ct()">';
        $result['message'] .= '<option value="ALL">Tất cả</option>';
        foreach ($a_chucnang[$inputs['phanloai']] as $key => $ct) {
            $result['message'] .= '<option value="' . $key . '">' . $ct . '</option>';
        }
        $result['message'] .= '</select>';
        $result['message'] .= '</div>';

        return $result;
    }
}
