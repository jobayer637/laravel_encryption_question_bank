@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('moderator.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('moderator.notice.index') }}" }}>Notice</a></li>
        <li class="breadcrumb-item active">Show</li>
    </ul>
</div>
@endsection

@section('main-content')
@php
    use Carbon\Carbon;
@endphp

<div class="row">
    <div class="col-md-7">
        <div class="card rounded-0">
            <div class="card-header d-flex justify-content-between">
                <h4 class="text-primary">Create New Notice </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('moderator.notice.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Enter Notice Title</label>
                        <input type="text" name="title" class="form-control rounded-0" placeholder="Enter Notice Title" required>
                    </div>
                    <div class="form-group">
                        <label for="body">Enter Notice Body</label>
                        <textarea class="summernote" name="body" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark rounded-0">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
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
                            <th class="border border-dark" scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notices as $key => $item)
                            <tr class="border">
                                <th class="border border-dark">{{ $key+1 }}</th>
                                <td class="border border-dark"><a href="{{ route('moderator.notice.show', $item->id) }}">{{ $item->title }}</a></td>
                                <td class="border border-dark">{{ $item->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $('.summernote').summernote({
        height: 200,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            // ['insert', ['link', 'picture', 'video']],
            ['insert', ['link', 'picture']],
        ],
        popover: {
           image: [
                ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
            link: [
                ['link', ['linkDialogShow', 'unlink']]
            ],
            table: [
                ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
            ],
            air: [
                ['color', ['color']],
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']]
            ]
        }
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
    $(document).on('submit', '#addNewSubject', function(event){
        event.preventDefault();
        $.ajax({
            url: "{{ route('admin.subject.store') }}",
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(response){
                if (response.success) {
                    swal("Done!", 'New Subject Successfully Added!', "success")
                   .then(()=>{
                       window.location.href = "{{ route('moderator.notice.index') }}"
                   })
                } else {
                    swal("Error!", 'Something went wrong', "error");
                }
            }
        })
    })
</script>

<script>
    $(document).on('click', '#deleteQuestion', function(){
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

{{-- Search value --}}
<script>
    $( document ).ready(function() {
        let filter = document.getElementsByClassName("filterData");
        $(document).on('keyup', '#searchValue', function(){
            let value = $(this).val().toLowerCase()
            $("tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        })
    });
</script>
@endpush
