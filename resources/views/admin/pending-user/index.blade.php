@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ul>
</div>
@endsection

@section('main-content')
<div class="card">
    <div class="card-close">
        <div class="dropdown">
        <button type="button" id="closeCard4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user-cog"></i></button>
        <div aria-labelledby="closeCard4" class="dropdown-menu dropdown-menu-right has-shadow">
            <a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
            <a href="#" class="dropdown-item edit"> <i class="fas fa-question-circle"></i> Permission All</a>
        </div>
        </div>
    </div>

    <div class="card-header d-flex justify-content-between">
        <h3 class="h4">Users Management</h3>
        <input type="text" id="searchValue" class="form-control col-md-4" placeholder="Search Here .... ">
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Institute</th>
                <th>Status</th>
                <th>Permission</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
            @if($user->status == 0)
            <tr>
                <th>{{ $user->name }}</th>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->name }}</td>
                <td>{{ $user->institute->name }}</td>
                <td><div class="badge {{ $user->status==1?'badge-warning':'' }}">{{ $user->status==1?'Active':'Pending' }}</div></td>
                <td><div class="badge {{ $user->permission==1?'badge-danger':'' }}">{{ $user->permission==1?'Permitted': 'Not Permit' }}</div></td>
                <td>
                    @if($user->role_id!==1)
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
                        {{-- <a href="" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a> --}}
                        <a data-url="{{ route('admin.users.destroy',$user->id) }}" class="deleteUser btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></a>
                    @endif
                </td>
            </tr>
            @endif
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection

@push('js')
{{-- token --}}
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
    // Delete user
        $(document).on('click', '.deleteUser', function(){
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
