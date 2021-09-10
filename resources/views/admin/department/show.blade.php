@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.department.index') }}" }}>Departments</a></li>
        <li class="breadcrumb-item active">{{ $department->name }}</li>
    </ul>
</div>
@endsection

@section('main-content')
@php
    use Carbon\Carbon;
@endphp

    <div class="col-md-4">
        <div class="card rounded-0">
            <div class="card-header">
                <h4>Update Department</h4>
            </div>
            <div class="card-body">
                <form id="addNewBoard" method="post" action="{{ route('admin.department.update', $department->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Enter Department Name</label>
                        <input name="name" type="text" class="form-control" required autocomplete="off" value="{{ $department->name }}">
                    </div>
                    <input type="submit" value="update" class="btn btn-primary rounded-0">
                </form>
            </div>
        </div>
    </div>

@endsection


@push('js')

@endpush
