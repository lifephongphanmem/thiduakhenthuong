@extends('BaoCao.main_inphoi')

@section('content')
    @foreach ($model as $doituong)
        <table cellspacing="0" cellpadding="0" border="0" background="{{ url('/assets/media/phoi/BangKhen.jpg') }}"
            style="height: 297mm;width: 420mm;background-repeat: no-repeat;background-size: 100% 100%;">
            {{-- <tr style="height: 10.5cm"> --}}
            <tr>
                <td colspan="2">
                    <button style="" id="flying1">
                        <p>{{ $doituong->tentapthe }}</p>
                    </button>
                </td>
            </tr>
            {{-- <tr style="height: 2cm"> --}}
            <tr>
                <td colspan="2">
                    <button style="" id="flying2" ondblclick="setNoiDung()">
                        <p>{{ $doituong->noidungkhenthuong }}</p>
                    </button>
                </td>
            </tr>
            {{-- <tr style="height: 2cm"> --}}
            <tr>
                <td style="width: 60%;"></td>
                <td>
                    <button style="" id="flying3">
                        <p>{{ $m_hoso->diadanh . ', ' . Date2Str($m_hoso->ngayhoso) }}</p>
                    </button>
                </td>
            </tr>
            {{-- <tr style="height: 1cm"> --}}
            <tr>
                <td style="width: 50%;">

                </td>
                <td>
                    <button style="" id="flying4">
                        <p>{{ $m_hoso->chucvunguoiky }}</p>
                    </button>
                </td>
            </tr>
            {{-- <tr style="height: 5cm"> --}}
            <tr>
                <td style="width: 50%;">

                </td>
                <td style="text-align: center; font-size: 20px;">
                    <button style="" id="flying5">
                        <p>{{ $m_hoso->hotennguoiky }}</p>
                    </button>
                </td>
            </tr>
        </table>
        <p style="page-break-before: always">
    @endforeach

@stop
