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
                                <div class="text-capitalize text-left float-left text-bold"><span>Q{{ $key+1 }}.</span>  <span id="question_{{ $question->id }}">{!! $rsa->privDecrypt($question->question) !!}</span></div>
                                <div>
                                    <button data-route="{{ route('admin.question.update',$question->id)}}" data-id="{{ $question->id }}" class="btn btn-outline-info btn-sm updateModal" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa-edit"></i></button>
                                    <button data-url="{{ route('admin.question.destroy',$question->id) }}" class="deleteQuestion btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group ">
                                <li class="list-group-item text-capitalize border-0 py-1">(A). &nbsp; <span id="option1_{{ $question->id }}">{{ $rsa->privDecrypt($question->option1) }}</span> </li>
                                <li class="list-group-item text-capitalize py-1 border-0">(B). &nbsp; <span id="option2_{{ $question->id }}">{{ $rsa->privDecrypt($question->option2) }}</span> </li>
                                <li class="list-group-item text-capitalize py-1 border-0">(C). &nbsp; <span id="option3_{{ $question->id }}">{{ $rsa->privDecrypt($question->option3) }}</span> </li>
                                <li class="list-group-item text-capitalize py-1 border-0">(D). &nbsp; <span id="option4_{{ $question->id }}">{{ $rsa->privDecrypt($question->option4) }}</span> </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
   </div>

   {{-- Question Update Modal --}}
<!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Question Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateQuestionForm">
                        @csrf
                        @method("PUT")
                        <div class="form-group">
                            <label for="question">Enter Question Body</label>
                            <textarea id="editQuForm" name="question" class="form-control summernote" required></textarea>
                        </div>

                            <div class="form-group">
                            <label for="question">Enter First Option</label>
                            <input id="editOp1Form" type="text" name="option1" class="form-control" required>
                        </div>

                            <div class="form-group">
                            <label for="question">Enter Second Option</label>
                            <input id="editOp2Form" type="text" name="option2" class="form-control" required>
                        </div>

                            <div class="form-group">
                            <label for="question">Enter Third Option</label>
                            <input id="editOp3Form" type="text" name="option3" class="form-control" required>
                        </div>

                            <div class="form-group">
                            <label for="question">Enter Fourth Option</label>
                            <input id="editOp4Form" type="text" name="option4" class="form-control" required>
                        </div>

                        <input type="number" value="1" name="marks" style="display: none">
                        <input id="quesUpdateBtn" class="btn btn-primary rounded-0" type="submit" value="update">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
{{-- End Question Update Modal --}}
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

{{-- question update script --}}
<script>
    var updateQuId;
    var updateRoute = "";
    $(".updateModal").on('click', function(){
        var id = $(this).data('id');
        updateQuId = id
        updateRoute = $(this).data('route')
        var question = $("#question_"+id).html()
        var option1 = $("#option1_"+id).text();
        var option2 = $("#option2_"+id).text();
        var option3 = $("#option3_"+id).text();
        var option4 = $("#option4_"+id).text();

        $("#editQuForm").summernote('code', question);
        $("#editOp1Form").val(option1)
        $("#editOp2Form").val(option2)
        $("#editOp3Form").val(option3)
        $("#editOp4Form").val(option4)
    })

    $(document).on('click','#quesUpdateBtn', function(){
        event.preventDefault()

        var q = $("#editQuForm").val();
        var o1 = $("#editOp1Form").val()
        var o2 = $("#editOp2Form").val()
        var o3 = $("#editOp3Form").val()
        var o4 = $("#editOp4Form").val()

        $("#question_"+updateQuId).text(q)
        $("#option1_"+updateQuId).text(o1);
        $("#option2_"+updateQuId).text(o2);
        $("#option3_"+updateQuId).text(o3);
        $("#option4_"+updateQuId).text(o4);

        var data = $("#updateQuestionForm").serializeArray();
        $.ajax({
            url: updateRoute,
            type: "PUT",
            dataType: "JSON",
            data:data,
            success: function(response){
                console.log(response)
                if (response.success) {
                    swal("Done!", 'Successfully Updated', "success")
                    .then(()=>{
                        // location.reload()
                        $('#staticBackdrop').modal('hide')
                    })
                } else {
                    swal("Error!", 'Something went wrong', "error")
                }
            }
        })
    })
</script>
@endpush
