@extends('custom_layouts.admin.app')

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active">Index</a></li>
        {{-- <li class="breadcrumb-item active">Home</li> --}}
    </ul>
</div>
@endsection

@php
    use Carbon\Carbon;
@endphp

@section('main-content')
<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-close">
                <div class="dropdown">
                <button type="button" id="closeCard4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user-cog"></i></button>
                <div aria-labelledby="closeCard4" class="dropdown-menu dropdown-menu-right has-shadow">
                    <a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a>
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
                        <th>Status</th>
                        <th>Permission</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <th>{{ $user->name }}</th>
                        <td>{{ $user->email }}</td>
                        <td><div class="badge {{ $user->role->id==2?'badge-warning':'' }}">{{ $user->role->name }}</div></td>
                        <td><div class="badge {{ $user->status?'badge-warning':'' }}">{{ $user->status==true?'Active':'Pending' }}</div></td>
                        <td><div class="badge {{ $user->permission?'badge-danger':'' }}">{{ $user->permission==true?'Permitted': 'Not Permit' }}</div></td>
                        <td>
                            @if($user->role_id!==1)
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-success btn-sm mb-1"><i class="fas fa-eye"></i></a>
                                <a href="" class="btn btn-outline-info btn-sm mb-1"><i class="fas fa-edit"></i></a>
                                <a data-url="{{ route('admin.users.destroy',$user->id) }}" class="deleteUser btn btn-outline-danger btn-sm mb-1"><i class="fas fa-trash"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>


    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="card rounded-0">
            <div class="card-header d-flex justify-content-between">
                <h4>All Subjects [{{ count($subjects) }}] </h4>
                <input type="text" id="searchValue" class="form-control col-md-4" placeholder="Search Here .... ">
            </div>
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

                            <tr class="filterData">
                                <th>{{ $key+1 }}</th>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->department->name }}</td>
                                <td>{{ Carbon::parse($subject->updated_at == NULL? $subject->created_at: $subject->updated_at)->format('d-m-Y') }}</td>
                                <td><span class="badge {{ $subject->status==true?'badge-warning':'' }}">{{ $subject->status==true?'active':'blocked' }}</span></td>
                                <td><span class="badge {{ $subject->permission==true?'badge-danger':'' }}">{{ $subject->permission==true?'permitted': 'not permit' }}</span></td>
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

</div>


@endsection
