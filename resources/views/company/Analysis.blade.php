@extends('layouts.mainCompany')
@section('title','User | Company')
@section('content')
<div class="row form-group">
    <div class="col-6">
        <label for="datasource">Datasource</label>
        <select name="datasource" id="datasource" class="form-control form-control-sm"></select>
    </div>
</div>
<div class="row form-group">
    <div class="col-3">
        <label for="start_date">Start date</label>
        <input type="date" name="start_date" id="start_date" class="form-control form-control-sm">
    </div>
    <div class="col-3">
        <label for="end_date">End date</label>
        <input type="date"  name="end_date" id="end_date" class="form-control form-control-sm">
    </div>
</div>
@endsection
