<?php

namespace App\Http\Controllers\HeThong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use Illuminate\Support\Facades\Session;

class dsdonviController extends Controller
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
        if (!chkPhanQuyen('dsdonvi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        $model = getDiaBan(session('admin')->capdo);
        $m_donvi = getDonVi(session('admin')->capdo);
        foreach ($model as $chitiet) {
            $chitiet->sodonvi = $m_donvi->where('madiaban', $chitiet->madiaban)->count();
        }

        return view('HeThongChung.DonVi.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_donvi', array_column($m_donvi->toarray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Danh sách đơn vị');
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        $inputs['url'] = '/DonVi';
        $inputs['tendiaban'] = dsdiaban::where('madiaban', $inputs['madiaban'])->first()->tendiaban ?? '';
        $model = dsdonvi::where('madiaban', $inputs['madiaban'])->get();
        return view('HeThongChung.DonVi.DanhSach')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách đơn vị');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        //$modeldvql = DSDonVi::where('tonghop', '1')->get();
        $model = new dsdonvi();
        $model->madonvi = null;
        $model->madiaban = $inputs['madiaban'];
        return view('HeThongChung.DonVi.Sua')
            ->with('model', $model)
            ->with('pageTitle', 'Tạo mới thông tin đơn vị');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        $model = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        if ($model == null) {
            $inputs['madonvi'] = (string) getdate()[0];
            dsdonvi::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/DonVi/DanhSach?madiaban=' . $inputs['madiaban']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        $model = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('HeThongChung.DonVi.Sua')
            ->with('model', $model)
            ->with('pageTitle', 'Chỉnh sửa thông tin đơn vị');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $id = $request->all()['id'];
        $model = dsdonvi::findorFail($id);
        //dd($model);
        $model->delete();
        return redirect('/DonVi/DanhSach?madiaban=' . $model->madiaban);
    }

    public function QuanLy(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        //dd($inputs);
        $m_donvi = dsdonvi::where('madiaban', $inputs['madiaban'])->get();
        $model = dsdiaban::where('madiaban', $inputs['madiaban'])->first();
        return view('HeThongChung.DonVi.QuanLy')
            ->with('model', $model)
            ->with('a_donvi', array_column($m_donvi->toarray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Tạo mới thông tin đơn vị');
    }

    public function LuuQuanLy(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        dsdiaban::where('madiaban', $inputs['madiaban'])->first()->update($inputs);
        return redirect('DonVi/ThongTin');
    }
}
