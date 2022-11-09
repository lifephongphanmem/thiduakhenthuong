<?php

namespace App\Http\Controllers\NghiepVu\_DungChung;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dsdonvi;

class dungchung_nghiepvuController extends Controller
{
    public function getDonViKhenThuong_ThemHS(Request $request)
    {
        $inputs = $request->all();
        $donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        if ($donvi != null)
            $model = getDonViQuanLyDiaBan($donvi);
        else
            $model = ['ALL'=>'Chọn đơn vị'];
        $result['status'] = 'success';
        $result['message'] = '<div id="donvikhenthuong" class="col-6">';
        $result['message'] .= '<label>Đơn vị khen thưởng</label>';
        $result['message'] .= '<select id="madonvi_kt_themhs" class="form-control" required="" name="madonvi_kt">';
        foreach ($model as $key => $val) {
            $result['message'] .= '<option value="' . $key . '">' . $val . '</option>';
        }
        $result['message'] .= '</select></div>';
        die(json_encode($result));
    }


}
