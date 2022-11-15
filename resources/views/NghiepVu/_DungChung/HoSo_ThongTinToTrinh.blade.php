

<div class="form-group row">
    <div class="col-lg-6">
        <label>Số tờ trình</label>
        {!! Form::text('sototrinhdenghi', null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-lg-6">
        <label>Ngày tháng trình<span class="require">*</span></label>
        {!! Form::input('date', 'ngaythangtotrinhdenghi', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<div class="form-group row">
    {{-- <div class="col-lg-6">
        <label>Chức vụ người ký tờ trình</label>
        {!! Form::text('chucvutotrinhdenghi', null, ['class' => 'form-control']) !!}
    </div> --}}
    <div class="col-5">
        <label>Chức vụ người ký</label>
        {!! Form::select(
            'chucvutotrinhdenghi',
            array_unique(array_merge([$model->chucvutotrinhdenghi => $model->chucvutotrinhdenghi], getChucVuKhenThuong())),
            null,
            ['class' => 'form-control', 'id' => 'chucvunguoikyqd'],
        ) !!}
    </div>
    <div class="col-1">
        <label>Thêm</label>
        <button type="button" data-target="#modal-chucvu" data-toggle="modal" class="btn btn-light-dark btn-icon">
            <i class="fa fa-plus"></i></button>
    </div>

    <div class="col-lg-6">
        <label>Họ tên người ký tờ trình</label>
        {!! Form::text('nguoikytotrinhdenghi', null, ['class' => 'form-control']) !!}
    </div>
</div>


<div class="form-group row">
    <div class="col-6">
        <label>Tờ trình kết quả khen thưởng: </label>
        {!! Form::file('totrinhdenghi', null, ['id' => 'totrinhdenghi', 'class' => 'form-control']) !!}
        @if ($model->totrinhdenghi != '')
            <span class="form-control" style="border-style: none">
                <a href="{{ url('/data/totrinh/' . $model->totrinhdenghi) }}" target="_blank">{{ $model->totrinhdenghi }}</a>
            </span>
        @endif
    </div>
</div>
