@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('moderator.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active">Institutes</li>
    </ul>
</div>
@endsection

@section('main-content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
       <div> <h3 class="h4">institute Management</h3></div>
        <div class="mr-5">
            <div class="d-flex justify-content-between">
                @if(Auth::user()->role_id == 2 && Auth::user()->permission == 1)
                    <input type="text" id="searchValue" class="form-control col-md-6 mr-2" placeholder="Search Here .... ">
                    <a href="{{ route('moderator.institutes.create') }}" class="btn btn-warning  rounded-0">Add New Institute</a>
                @else
                    <input type="text" id="searchValue" class="form-control" placeholder="Search Here .... ">
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>S/L</th>
                <th>Name</th>
                <th>Email</th>
                <th>Board</th>
                <th>District</th>
                <th>Thana</th>
                <th>Status</th>
                <th>Permission</th>
                @if(Auth::user()->update_permission == 1)
                <th>Active</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach ($institutes as $key => $institute)
            <tr>
                <th>{{ $key+1 }}</th>
                <th>{{ $institute->name }}</th>
                <td>{{ $institute->email }}</td>
                <td>{{ $institute->board->name }}</td>
                <td>{{ $institute->district->name }}</td>
                <td>{{ $institute->upazila->name }}</td>
                <td><div class="badge badge-warning">{{ $institute->status==true?'active':'deactive' }}</div></td>
                <td><div class="badge badge-danger">{{ $institute->permission==true?'permitted': 'not permit' }}</div></td>
                @if(Auth::user()->update_permission == 1)
                <td>
                    <a href="{{ route('admin.users.show', $institute->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
                    <a href="" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                    <a data-url="{{ route('admin.users.destroy',$institute->id) }}" class="deleteUser btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></a>
                </td>
                @endif
            </tr>
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
