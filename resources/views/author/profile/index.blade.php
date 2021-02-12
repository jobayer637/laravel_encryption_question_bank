@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('author.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active">Show</li>
    </ul>
</div>
@endsection

@section('main-content')
@php
    use Carbon\Carbon;
@endphp
   <div class="row">
       <div class="col-md-6">
            <div class="card mb-3 p-3">
                <div class="row no-gutters">
                    <div class="col-md-4">
                    <img src="{{ asset($user->image) }}" class="card-img rounded-circle border-dark" alt="...">
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize">{{ $user->name }}</h5>
                        <h6 class="card-title">{{ $user->email }}</h6>
                        {{-- <p class="card-text">{{ $user->about }}</p> --}}
                        <p class="card-text">{{ $user->institute->name }}</p>
                        <p class="card-text">{{ $user->institute->board->name }} Board</p>
                        <p class="card-text">{{ $user->institute->division->name }}, {{ $user->institute->district->name }}, {{ $user->institute->upazila->name }}, {{ $user->institute->union->name }}</p>
                        <p class="card-text"><small class="text-muted">{{ Carbon::parse($user->created_at)->format('d-m-Y') }}</small></p>
                    </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <form action="{{ route('author.profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                    <div class="d-flex justify-content-between">
                            <span class="badge badge-danger">Update About Yourself</span>
                            <button type="submit" class="btn btn-danger btn-sm rounded-0 px-5 disabled">Update</button>
                    </div>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        <textarea id="about" type="about" class="summernote form-control" name="about" required autocomplete="about">
                            {{ $user->about }}
                        </textarea>
                    </div>
                </div>
            </form>
       </div>

       <div class="col-md-6">
           <div class="card">
                <div class="card-header">
                   <div class="badge badge-danger">Update Profile Image</div>
                </div>
                <div class="card-body">
                    <form id="" action="{{ route('author.profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="input-group">
                            <input type="file" name="image" class="form-control">
                            <button type="submit" class="btn btn-danger rounded-0 px-5 disabled">Update</button>
                        </div>
                    </form>
               </div>
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
        height: 180,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link']],
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
</script>
@endpush
