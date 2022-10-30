<h4 class="text-dark font-weight-bold mb-5">Thông tin quyết định khen thưởng</h4>
<div class="form-group row">
    <div class="col-6">
        <label>Tên đơn vị quyết định khen thưởng</label>
        {!! Form::text('donvikhenthuong', null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-6">
        <label>Cấp độ khen thưởng</label>
        {!! Form::select('capkhenthuong', getPhamViApDung(), null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row">
    <div class="col-6">
        <label>Số quyết định</label>
        {!! Form::text('soqd', null, ['class' => 'form-control']) !!}
    </div>

    <div class="col-6">
        <label>Ngày ra quyết định</label>
        {!! Form::input('date', 'ngayqd', date('Y-m-d'), ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row">
    <div class="col-6">
        <label>Chức vụ người ký</label>
        {!! Form::text('chucvunguoikyqd', null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-6">
        <label>Họ tên người ký</label>
        {!! Form::text('hotennguoikyqd', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row">
    <div class="col-6">
        <label>Quyết định khen thưởng: </label>
        {!! Form::file('quyetdinh', null, ['id' => 'quyetdinh', 'class' => 'form-control']) !!}
        @if ($model->quyetdinh != '')
            <span class="form-control" style="border-style: none">
                <a href="{{ url('/data/quyetdinh/' . $model->quyetdinh) }}" target="_blank">{{ $model->quyetdinh }}</a>
            </span>
        @endif
    </div>
</div>
