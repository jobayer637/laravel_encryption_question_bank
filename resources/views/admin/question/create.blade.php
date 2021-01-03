@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.question.index') }}" }}>Question</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ul>
</div>
@endsection

@section('main-content')
    @php
        use App\Helper as RSA;
        use App\Key;
        $key = Key::where('user_id', 1)->first();
        $rsa = new RSA\Encryption($key->private_key, $key->public_key);
    @endphp

   <div class="" id="create">
        <div class="row">
            <div class="col-md-6">
                <div class="card rounded-0">
                    <div class="card-body sticky-top">
                    <form id="createQuestionForm">
                        @csrf
                        <input type="text" name="subject_id" value="{{ $subject_id }}" style="display: none">
                        <div class="form-group">
                            <label for="question">Enter Question Body</label>
                            <textarea name="question" class="form-control summernote" required></textarea>
                        </div>

                            <div class="form-group">
                            <label for="question">Enter First Option</label>
                            <input type="text" name="option1" class="form-control" required>
                        </div>

                            <div class="form-group">
                            <label for="question">Enter Second Option</label>
                            <input type="text" name="option2" class="form-control" required>
                        </div>

                            <div class="form-group">
                            <label for="question">Enter Third Option</label>
                            <input type="text" name="option3" class="form-control" required>
                        </div>

                            <div class="form-group">
                            <label for="question">Enter Fourth Option</label>
                            <input type="text" name="option4" class="form-control" required>
                        </div>

                        <input type="number" value="1" name="marks" style="display: none">
                        <input class="btn btn-primary rounded-0" type="submit" value="Submit">
                    </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                 @foreach ($questions as $key => $question)
                    <div class="card rounded-0">
                        <div class="card-header mb-0 pb-0">
                            <div class="d-flex justify-content-between">
                                <div class="text-capitalize text-left float-left text-bold"><span>Q{{ $key+1 }}.</span>  <span>{!! $rsa->privDecrypt($question->question) !!}</span></div>
                                <div>
                                    <button data-url="{{ route('admin.question.destroy',$question->id) }}" class="deleteQuestion btn btn-danger btn-sm rounded-0">Delete</button>
                                </div>
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
                @endforeach
            </div>
        </div>
   </div>
@endsection


@push('js')
<!-- summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $('.summernote').summernote({
        height: 100,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
        ]
    });
</script>

<script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>

<script>
    $(document).on('submit', '#createQuestionForm', function(event){
        event.preventDefault()
        var data = $(this).serializeArray();
        $.ajax({
            url: "{{ route('admin.question.store')}}",
            type: "POST",
            dataType: "JSON",
            data:data,
            success: function(response){
                console.log(response)
                if (response.success) {
                    swal("Done!", 'Successfully Added New Question', "success")
                    .then(()=>{location.reload()})
                } else {
                    swal("Error!", 'Something went wrong', "error")
                }
            }
        })
    })
</script>

<script>
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
