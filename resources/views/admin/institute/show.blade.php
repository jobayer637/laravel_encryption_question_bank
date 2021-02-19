@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.institutes.index') }}" }}>Institutes</a></li>
        <li class="breadcrumb-item active">{{ $institute->name }}</li>
    </ul>
</div>
@endsection

@section('main-content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
       <div> <h3 class="h4">{{ $institute->name }} ({{ $institute->eiin }})</h3></div>
        <div class="">
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.institutes.create') }}" class="btn btn-outline-warning rounded-0">Add New Institute</a>
            </div>
        </div>
    </div>
    <div class="card-body">

    </div>
</div>
@endsection

@push('js')
{{-- token --}}
<script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@endpush
