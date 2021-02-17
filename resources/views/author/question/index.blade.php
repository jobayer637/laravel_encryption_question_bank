@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active">Question</li>
    </ul>
</div>
@endsection

@section('main-content')
 @php
    use App\Helper as RSA;
    use App\Key;
    $userId = Auth::check()? Auth::user()->id : 0;
    $key = Key::where('user_id', $userId )->first();
    $rsa = new RSA\Encryption($key->private_key, $key->public_key);
@endphp

@if(Auth::check() && Auth::user()->status==1 )
   <div class="">
        @foreach ($subjects as $subject)
            @if($subject->status == 1)
                <div>
                    <div class="card rounded-0">
                        <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div> <h4>{{ $subject->name }} Question  [total question: {{ count($subject->questions) }}] </h4></div>
                            <a class="btn btn-warning rounded-0" href="{{ route('author.question.show', $subject->slug) }}">Show PDF View</a>
                        </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
   </div>
@else
   <div class="badge badge-info">Your Request is pending.......... Please waiting for admin approval</div>
@endif
@endsection


@push('js')

@endpush
