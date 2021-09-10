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
        $key = Key::where('user_id', 1)->first();
        $rsa = new RSA\Encryption($key->private_key, $key->public_key);
    @endphp

   <div class="">
       <div class="row">
            <div class="col-3">
                <div class="card rounded-0">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @foreach ($subjects as $subject)
                        <a class="nav-link {{ $subject->status==1?'bg-info':'' }} rounded-0" id="v-pills-profile-tab-{{ $subject->id }}" data-toggle="pill" href="#v-pills-profile-{{ $subject->id }}" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                            {{ $subject->name }}
                        </a>
                    @endforeach
                </div>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    @foreach ($subjects as $subject)
                        <div class="tab-pane fade" id="v-pills-profile-{{ $subject->id }}" role="tabpanel" aria-labelledby="v-pills-profile-tab-{{ $subject->id }}">
                            <div class="card rounded-0">
                                <div class="card-header">
                                   <div class="d-flex justify-content-between">
                                       <div class="d-flex justify-content-between">
                                           <button class="btn btn-secondary mr-1 rounded-0 disabled" disabled>{{ $subject->name }} Question  [total question: {{ count($subject->questions) }}]</button>
                                            <a class="btn btn-warning rounded-0" href="{{ route('admin.question.show', $subject->slug) }}">Show PDF View</a>
                                        </div>
                                       <div class="d-flex justify-content-between">
                                           <form id="userStatus" action="{{ route('admin.subject.update', $subject->id) }}" class="mr-3">
                                                @csrf
                                                <div class="input-group">
                                                    <select id="inputState" name="status" class="form-control">
                                                        <option value="1" {{ $subject->status==1?'selected':'' }}>Approved</option>
                                                        <option value="0" {{ $subject->status==0? 'selected':'' }}>Pending</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-primary rounded-0 disabled"><i class="fas {{ $subject->status? 'fa-unlock':'fa-lock' }}"></i></button>
                                                </div>
                                            </form>

                                           <form id="userPermission" action="{{ route('admin.subject.update', $subject->id) }}" >
                                                @csrf
                                                <div class="input-group">
                                                    <select id="inputState" name="permission" class="form-control">
                                                        <option value="1" {{ $subject->permission==1?'selected':'' }}>Permitted</option>
                                                        <option value="0" {{ $subject->permission==0? 'selected':'' }}>Not Permit</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-primary rounded-0 disabled"><i class="fas {{ $subject->permission? 'fa-unlock':'fa-lock' }}"></i></button>
                                                </div>
                                            </form>
                                            <a href="{{ route('admin.question.create', ['subject_id'=> $subject->id]) }}" class="btn btn-warning rounded-0 ml-3">Add New Question</a>
                                       </div>
                                   </div>
                                </div>
                                <div class="card-body" id="pdf_content">
                                    @foreach ($subject->questions as $key => $question)
                                    <div class="card rounded-0">
                                        <div class="card-header mb-0 pb-0">
                                           <div class="d-flex justify-content-between mb-0 pb-0">
                                               <div class="text-capitalize text-left float-left text-bold"><span>Q{{ $key+1 }}.</span>  <span id="question_{{ $question->id }}">{!! $rsa->privDecrypt($question->question) !!}</span></div>
                                                <div>
                                                    {{-- <button data-route="{{ route('admin.question.update',$question->id)}}" data-id="{{ $question->id }}" class="btn btn-outline-success btn-sm updateModal" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa-eye"></i></button> --}}
                                                    <button data-route="{{ route('admin.question.update',$question->id)}}" data-id="{{ $question->id }}" class="btn btn-outline-info btn-sm updateModal" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa-edit"></i></button>
                                                    <button data-url="{{ route('admin.question.destroy',$question->id) }}" class="deleteQuestion btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                </div>
                                           </div>
                                        </div>
                                        <div class="card-body mt-0 pt-0">
                                            <ul class="list-group mt-0 pt-0">
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
                    @endforeach
                </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

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


<script>
    // User permission
    $(document).on('submit', '#userPermission', function(event){
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serializeArray(),
            success: function(response){
                if (response.success) {
                    swal("Done!", 'Successfully Updated', "success")
                    .then(()=>{location.reload()})
                } else {
                    swal("Error!", 'Something went wrong', "error")
                }
            }
        })
    })

    // User Status
    $(document).on('submit', '#userStatus', function(event){
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serializeArray(),
            success: function(response){
                if (response.success) {
                    swal("Done!", 'Successfully Updated', "success")
                    .then(()=>{location.reload()})
                } else {
                    swal("Error!", 'Something went wrong', "error")
                }
            }
        })
    })
</script>

<script>
    function demoFromHTML() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        source = $('#pdf_content')[0];
        specialElementHandlers = {
            '#bypassme': function (element, renderer) {
                return true
            }
        };
        margins = {
            top: 80,
            bottom: 60,
            left: 40,
            width: 522
        };
        pdf.fromHTML(
            source,
            margins.left,
            margins.top, {
                'width': margins.width,
                'elementHandlers': specialElementHandlers
            },

            function (dispose) {
                pdf.save('Test.pdf');
            }, margins
        );
    }
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
