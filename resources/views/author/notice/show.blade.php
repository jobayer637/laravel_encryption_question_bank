@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('author.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('author.notice.index') }}" }}>Notice</a></li>
        <li class="breadcrumb-item active">Show</li>
    </ul>
</div>
@endsection

@section('main-content')
@php
    use Carbon\Carbon;
@endphp

<div class="row">
    <div class="col-md-8">
        <div class="card rounded-0">
            <div class="card-header d-flex justify-content-between">
                <h4 class="text-primary">{{ $notice->title }}</h4>
            </div>
            <div class="card-body">
                {!! $notice->body !!}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card rounded-0">
            <div class="card-header">
                <h4>Latest 10 notices</h4>
            </div>
            <div class="card-body">
                <table class="table border border-dark">
                    <thead class="thead-light">
                        <tr class="border border-dark">
                            <th class="border border-dark" scope="col">#</th>
                            <th class="border border-dark" scope="col">Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notices as $key => $item)
                        @if($notice->id != $item->id)
                            <tr class="border">
                                <th class="border border-dark">{{ $key+1 }}</th>
                                <td class="border border-dark"><a href="{{ route('author.notice.show', $item->id) }}">{{ $item->title }}</a></td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')

@endpush
