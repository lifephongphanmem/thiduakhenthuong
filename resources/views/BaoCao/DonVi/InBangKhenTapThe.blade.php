@extends('BaoCao.main_inphoi')

@section('content')
    @foreach ($model as $doituong)
        <table cellspacing="0" cellpadding="0" border="0" background="{{ url('/assets/media/phoi/BangKhen.jpg') }}"
            style="height: 297mm;width: 420mm;background-repeat: no-repeat;background-size: 100% 100%;">

            <tr>
                <td colspan="2">
                    <button style="{{ $doituong->toado_tendoituong }}" id="toado_tendoituong">
                        {{ $doituong->tentapthe }}
                    </button>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <button style="{{ $doituong->toado_noidungkhenthuong }}" id="toado_noidungkhenthuong" ondblclick="setNoiDung()">
                        {!! $doituong->noidungkhenthuong !!}
                    </button>
                </td>
            </tr>

            <tr>
                <td style="width: 60%;"></td>
                <td>
                    <button style="{{ $doituong->toado_ngayqd }}" id="toado_ngayqd">
                        {!! $doituong->ngayqd !!}
                    </button>
                </td>
            </tr>

            <tr>
                <td style="width: 50%;"></td>

                <td style="text-align: center">
                    <button style="{{ $doituong->toado_chucvunguoikyqd }}" id="toado_chucvunguoikyqd">
                        {{ $doituong->chucvunguoikyqd }}
                    </button>
                </td>
            </tr>

            <tr>
                <td style="width: 50%;"></td>

                <td style="text-align: center">
                    <button style="{{ $doituong->toado_hotennguoikyqd }}" style="" id="toado_hotennguoikyqd">
                        {{ $doituong->hotennguoikyqd }}
                    </button>
                </td>
            </tr>
        </table>
        <p style="page-break-before: always">
    @endforeach

@stop
