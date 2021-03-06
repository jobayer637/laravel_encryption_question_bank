@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.users.index') }}" }}>Users</a></li>
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
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-4">
                    <img src="{{ asset($user->image) }}" class="card-img" alt="...">
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

            @if($user->role_id !=1)
            <div class="card">
               <div class="card-header"><div class="badge badge-danger">User Role</div></div>
               <div class="card-body">
                    <form id="userStatus" action="{{ route('admin.users.update', $user->id) }}" >
                        @csrf
                        <div class="input-group">
                            <select id="inputState" name="role_id" class="form-control">
                                <option value="2" {{ $user->role_id==2?'selected':'' }}>Moderator</option>
                                <option value="3" {{ $user->role_id==3? 'selected':'' }}>Author</option>
                            </select>
                            <button type="submit" class="btn btn-danger rounded-0 px-5 disabled"><i class="fas {{ $user->role_id==2? 'fa-unlock':'fa-lock' }}"></i></button>
                        </div>
                    </form>
               </div>
           </div>

            <div class="card">
               <div class="card-header"><div class="badge badge-danger">Moderator Edit Permission</div></div>
               <div class="card-body">
                    <form id="updatePermission" action="{{ route('admin.users.update', $user->id) }}" >
                        @csrf
                        <div class="input-group">
                            <select id="inputState" name="update_permission" class="form-control">
                                <option value="1" {{ $user->update_permission==1?'selected':'' }}>Permitted</option>
                                <option value="0" {{ $user->update_permission==0? 'selected':'' }}>Blocked</option>
                            </select>
                            <button type="submit" class="btn btn-danger rounded-0 px-5 disabled"><i class="fas {{ $user->update_permission==1? 'fa-unlock':'fa-lock' }}"></i></button>
                        </div>
                    </form>
               </div>
           </div>
           @endif

       </div>
       <div class="col-md-6">
           <div class="card">
               <div class="card-header"><div class="badge badge-danger">User Status</div></div>
               <div class="card-body">
                    <form id="userStatus" action="{{ route('admin.users.update', $user->id) }}" >
                        @csrf
                        <div class="input-group">
                            <select id="inputState" name="status" class="form-control">
                                <option value="1" {{ $user->status==1?'selected':'' }}>Approved</option>
                                <option value="0" {{ $user->status==0? 'selected':'' }}>Pending</option>
                            </select>
                            <button type="submit" class="btn btn-danger rounded-0 px-5 disabled"><i class="fas {{ $user->status? 'fa-unlock':'fa-lock' }}"></i></button>
                        </div>
                    </form>
               </div>
           </div>

           <div class="card">
               <div class="card-header"><div class="badge badge-danger">Moderator Add-New Permission</div></div>
               <div class="card-body">
                    <form id="userPermission" action="{{ route('admin.users.update', $user->id) }}" >
                        @csrf
                        <div class="input-group">
                            <select id="inputState" name="permission" class="form-control">
                                <option value="1" {{ $user->permission==1?'selected':'' }}>Permitted</option>
                                <option value="0" {{ $user->permission==0? 'selected':'' }}>Not Permit</option>
                            </select>
                            <button type="submit" class="btn btn-danger rounded-0 px-5 disabled"><i class="fas {{ $user->permission? 'fa-unlock':'fa-lock' }}"></i></button>
                        </div>
                    </form>
               </div>
           </div>

           <div class="card">
               <div class="card-header"><div class="badge badge-danger">Moderator Subject Permission</div></div>
               <div class="card-body">
                    <form id="userPermission" action="{{ route('admin.users.update', $user->id) }}" >
                        @csrf
                        <div class="input-group">
                            <select id="inputState" name="subject_id" class="form-control">
                                <option value="0" {{ $user->subject_id==0? 'selected':'' }}>Not Permit</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $user->subject_id==$subject->id? 'selected':'' }}>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-danger rounded-0 px-5 disabled"><i class="fas {{ $user->subject_id!=0? 'fa-unlock':'fa-lock' }}"></i></button>
                        </div>
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
    $(document).on('submit', '#updatePermission', function(event){
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
