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

@if(Auth::check() && Auth::user()->status==1 && Auth::user()->permission==1 )
   <div class="">
       <div class="row">
            <div class="col-3">
                <div class="card rounded-0">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @foreach ($subjects as $subject)
                    @if($subject->permission)
                        <a class="nav-link rounded-0" id="v-pills-profile-tab-{{ $subject->id }}" data-toggle="pill" href="#v-pills-profile-{{ $subject->id }}" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                            {{ $subject->name }}
                        </a>
                    @else
                        <h3 class="p-5"><div class="badge badge-info">No Question Available Right Now</div></h3>
                    @endif
                    @endforeach
                </div>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    @foreach ($subjects as $subject)
                    @if($subject->permission)
                        <div class="tab-pane fade" id="v-pills-profile-{{ $subject->id }}" role="tabpanel" aria-labelledby="v-pills-profile-tab-{{ $subject->id }}">
                            <div class="card rounded-0">
                                <div class="card-header">
                                   <div class="d-flex justify-content-between">
                                       <div> <h4>{{ $subject->name }} Question  [total question: {{ count($subject->questions) }}] </h4></div>
                                   </div>
                                </div>
                                <div class="card-body">
                                    @foreach ($subject->questions as $key => $question)
                                        @if($subject->permission && $subject->status)
                                            <div class="card rounded-0">
                                                <div class="card-header mb-0 pb-0">
                                                <div class="d-flex justify-content-between">
                                                    <div class="text-capitalize text-left float-left text-bold"><span>Q{{ $key+1 }}.</span>  <span>{!! $rsa->privDecrypt($question->question) !!}</span></div>
                                                </div>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group ">
                                                        <li class="list-group-item text-capitalize border-0 py-1">(A). &nbsp; {{ $rsa->privDecrypt($question->option1) }}</li>
                                                        <li class="list-group-item text-capitalize py-1 border-0">(B). &nbsp; {{ $rsa->privDecrypt($question->option2) }}</li>
                                                        <li class="list-group-item text-capitalize py-1 border-0">(C). &nbsp; {{ $rsa->privDecrypt($question->option3) }}</li>
                                                        <li class="list-group-item text-capitalize py-1 border-0">(D). &nbsp; {{ $rsa->privDecrypt($question->option4) }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="badge badge-info">The question was published.. Just waiting for admin approval</div>
                                            @break;
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- <div class="badge badge-info">The question was published.. Just waiting for admin approval</div> --}}
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
   </div>
@else
   <div class="badge badge-info">Your Request is pending.......... Please waiting for admin approval</div>
@endif
@endsection


@push('js')
   <script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $(document).on('click', '.deleteQuestion', function(){
        let url = $(this).data('url')
         swal({
            title: "Delete?",
            text: "Please ensure and then confirm!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {
            if (e.value === true) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    success: function (response) {
                        console.log(response)
                        if (response.success) {
                            swal("Done!", 'Successfully Deleted', "success")
                            .then(()=>{location.reload()})
                        } else {
                            swal("Error!", 'Something went wrong', "error")
                        }
                    }
                });
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    })
   </script>
@endpush
