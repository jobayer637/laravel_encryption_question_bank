@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.subject.index') }}" }}>Subject</a></li>
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
            <div class="card">
               <div class="card-header"><div class="badge badge-danger">Update Status</div></div>
               <div class="card-body">
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
               </div>
           </div>

           <div class="card">
               <div class="card-header"><div class="badge badge-danger">Update Permission</div></div>
               <div class="card-body">
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
               </div>
           </div>
       </div>

       <div class="col-md-6">
            <div class="card rounded-0">
                <div class="card-header">
                    <div class="badge badge-danger">Update Subject and Department</div>
                </div>
                <div class="card-body">
                    <form id="updateSubject" action="{{ route('admin.subject.update', $subject->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="inputState">Select Department</label>
                            <select name="department_id" id="inputState" class="form-control">
                                @foreach ($departments as $department)
                                    <option {{ $subject->department->name==$department->name?'selected':'' }} value="{{ $department->id }}"> {{ $department->name }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Enter Subject Name</label>
                            <input name="name" type="text" class="form-control" value="{{ $subject->name }}">
                        </div>

                        <input type="submit" value="update" class="btn btn-primary rounded-0">

                    </form>
                </div>
            </div>
       </div>
   </div>
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

     // User Status
    $(document).on('submit', '#updateSubject', function(event){
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
