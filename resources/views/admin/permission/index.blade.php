@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header">
                            <div class="badge badge-danger">User Registration Permission</div>
                        </div>
                        <div class="card-body">
                            <form id="registerPermission" action="{{ route('admin.permission.update')}}">
                                @csrf
                                <div class="input-group">
                                    <select id="inputRegister" name="register" class="form-control">
                                        <option value="1" {{ $permission->register==1?'selected':'' }}>Permitted</option>
                                        <option value="0" {{ $permission->register==0? 'selected':'' }}>Blocked</option>
                                    </select>
                                    <button type="submit" class="btn btn-danger rounded-0 px-5 disabled"><i class="fas {{ $permission->register != 0? 'fa-unlock':'fa-lock' }}"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
     // User Status
    $(document).on('submit', '#registerPermission', function(event){
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
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
