@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active">Subject</li>
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
    <div class="card-header"><h4>All Subjects [{{ count($subjects) }}] </h4></div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">S/L</th>
                    <th scope="col">Subject Name</th>
                    <th scope="col">Department</th>
                    <th scope="col">Updated</th>
                    <th scope="col">Status</th>
                    <th scope="col">Permission</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($subjects as $key => $subject)

                     <tr>
                        <th>{{ $key+1 }}</th>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->department->name }}</td>
                        <td>{{ Carbon::parse($subject->updated_at == NULL? $subject->created_at: $subject->updated_at)->format('d-m-Y') }}</td>
                        <td><div class="badge {{ $subject->status==true?'badge-warning':'' }}">{{ $subject->status==true?'active':'deactive' }}</div></td>
                        <td><div class="badge {{ $subject->permission==true?'badge-danger':'' }}">{{ $subject->permission==true?'permitted': 'not permit' }}</div></td>
                        <td>
                            <a href="{{ route('admin.subject.show', $subject->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
                            <button class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></button>
                            <button id="deleteQuestion" data-url="{{ route('admin.subject.destroy', $subject->id) }}" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
               @endforeach
            </tbody>
        </table>
    </div>
</div>
    </div>
    <div class="col-md-4">
        <div class="card rounded-0">
            <div class="card-header">
                <h4>Add New Subject</h4>
            </div>
            <div class="card-body">
                <form id="addNewSubject">
                    @csrf
                     <div class="form-group">
                        <label for="inputState">Select Department</label>
                        <select name="department" id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"> {{ $department->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Enter Subject Name</label>
                        <input name="subject" type="text" class="form-control">
                    </div>

                    <input type="submit" value="submit" class="btn btn-primary rounded-0">

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
    $(document).on('submit', '#addNewSubject', function(event){
        event.preventDefault();
        $.ajax({
            url: "{{ route('admin.subject.store') }}",
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(response){
                if (response.success) {
                    swal("Done!", 'New Subject Successfully Added!', "success")
                   .then(()=>{ location.reload()})
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
@endpush
