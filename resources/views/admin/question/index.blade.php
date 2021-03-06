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
                                           <div class="d-flex justify-content-between">
                                               <div class="text-capitalize text-left float-left text-bold"><span>Q{{ $key+1 }}.</span>  <span>{!! $rsa->privDecrypt($question->question) !!}</span></div>
                                                <div>
                                                    <button class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></button>
                                                    <button class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></button>
                                                    <button data-url="{{ route('admin.question.destroy',$question->id) }}" class="deleteQuestion btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
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
                    @endforeach
                </div>
            </div>
        </div>
   </div>
@endsection


@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

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
@endpush
