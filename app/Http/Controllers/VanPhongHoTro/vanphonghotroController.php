<?php

namespace App\Http\Controllers\VanPhongHoTro;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\HeThong\dsvanphonghotro;
use Illuminate\Support\Facades\Session;

class vanphonghotroController extends Controller
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

    /**
     * Display a listing of the resource.
     */
    public function ThongTin()
    {
        $model_vp = dsvanphonghotro::orderBy('stt')->get();
        $a_vp = a_unique(array_column($model_vp->toArray(),'vanphong'));
        // $col =(int) 12 / (count($a_vp)>0?count($a_vp) : 1);
        // $col = $col < 4 ? 4 : $col;
        return view('VanPhongHoTro.index')
                ->with('model_vp',$model_vp)
                ->with('a_vp',$a_vp)
                // ->with('col',$col)
                ->with('pageTitle', 'Danh sách văn phòng hỗ trợ');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $check = dsvanphonghotro::where('maso',$inputs['maso'])->first();

        if ($check == null) {
            $inputs['maso'] = getdate()[0];
            dsvanphonghotro::create($inputs);
        } else {
            $check->update($inputs);
        }
        return redirect('/VanPhongHoTro/ThongTin');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $inputs = $request->all();
        $model = dsvanphonghotro::where('maso', $inputs['maso'])->first();
        die($model);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $inputs = $request->all();
        dsvanphonghotro::where('maso', $inputs['maso'])->first()->delete();
        return redirect('/VanPhongHoTro/ThongTin');
    }
}
