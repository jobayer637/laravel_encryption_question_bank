@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active">Department or Group</li>
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
    <div class="card-header"><h4>All Departments [{{ count($departments) }}] </h4></div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">S/L</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Department Name</th>
                    <th scope="col">Updated</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($departments as $key => $department)

                     <tr>
                        <th>{{ $key+1 }}</th>
                        <td title="{{ $department->user->role->name }}">{{ $department->user->name }}</td>
                        <td>{{ $department->name }}</td>
                        <td>{{ Carbon::parse($department->updated_at == NULL? $department->created_at: $department->updated_at)->format('d-m-Y') }}</td>
                        <td><div class="badge {{ $department->status==true?'badge-warning':'' }}">{{ $department->status==true?'active':'deactive' }}</div></td>
                        <td>
                            <a href="{{ route('admin.department.show', $department->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
                            <button class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></button>
                            <button id="deleteBoard" data-url="{{ route('admin.department.destroy', $department->id) }}" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
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
                <h4>Add New Group/Department</h4>
            </div>
            <div class="card-body">
                <form id="addNewDepartment">
                    @csrf
                    <div class="form-group">
                        <label for="">Enter Group/Department Name</label>
                        <input name="name" type="text" class="form-control" required autocomplete="off">
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
    $(document).on('submit', '#addNewDepartment', function(event){
        event.preventDefault();
        $.ajax({
            url: "{{ route('admin.department.store') }}",
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(response){
                if (response.success) {
                    swal("Done!", 'New Department Successfully Added!', "success")
                   .then(()=>{ location.reload()})
                } else {
                    swal("Error!", 'Something went wrong', "error");
                }
            }
        })
    })
</script>

<script>
    $(document).on('click', '#deleteBoard', function(){
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
