@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.institutes.index') }}" }}>Institutes</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ul>
</div>
@endsection

@section('main-content')
    @php
        use App\Helper as RSA;
        use App\Key;
        $key = Key::where('user_id', 1)->first();
        $rsa = new RSA\Encryption($key->private_key, $key->public_key);
    @endphp

   <div class="" id="create">
        <div class="row">
            <div class="col-md-7">
                <div class="card rounded-0">
                    <div class="card-body sticky-top">
                    <form method="POST" action="{{ route('admin.institutes.update', $institute->id) }}">
                        @csrf
                        @method("PUT")
                        <div class="form-group">
                            <label for="board">Select Board</label>
                            <select class="form-control" name="board_id" id="board">
                                <option value="">Select Education Board</option>
                                @foreach ($boards as $board)
                                    <option {{ $board->id==$institute->board_id?'selected':'' }} value="{{ $board->id }}">{{ $board->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="board">Select Division/District/Upazila/Union</label>
                            <div class="input-group">
                                <select class="form-control" name="division_id" id="selectDivision">
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $division)
                                        <option {{ $division->id==$institute->division_id?'selected':'' }} value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                </select>

                                <select class="form-control" name="district_id" id="selectDistrict">
                                    <option  value="{{ $institute->district_id }}">{{ $institute->district->name }}</option>
                                </select>

                                <select class="form-control" name="upazila_id" id="selectUpazila">
                                    <option  value="{{ $institute->upazila_id }}">{{ $institute->upazila->name }}</option>
                                </select>

                                <select class="form-control" name="union_id" id="selectUnion">
                                    <option  value="{{ $institute->union_id }}">{{ $institute->union->name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="institute">Enter Institution Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Institution Name" required value="{{ $institute->name }}">
                        </div>

                        <div class="form-group">
                            <label for="eiin">Enter Institution EIIN</label>
                            <input type="text" name="eiin" class="form-control" placeholder="Enter Institution EIIN" required value="{{ $institute->eiin }}">
                        </div>

                        <div class="form-group">
                            <label for="email">Enter Institution Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Enter Institution Email" required value="{{ $institute->email }}">
                        </div>

                         <div class="form-group">
                            <label for="address">Enter Institution Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter Institution Address" required value="{{ $institute->address }}">
                        </div>

                        <input class="btn btn-primary rounded-0" type="submit" value="update">
                    </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">

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
    $(document).on('change', '#selectDivision', function(event){
        let id = $(this).val()
        $.ajax({
            url: "{{ route('admin.districts') }}",
            type: 'get',
            data: {id: id},
            beforeSend: function() {
                 $("#selectDistrict").html(`<option value="">Select District</option>`);
            },
            success: function(response){
                $.each(response, function(i,v){
                    $("#selectDistrict").append(`<option value='${i}'>${v}</option>`);
                })
            }
        })
    })

     $(document).on('change', '#selectDistrict', function(event){
        let id = $(this).val()
        $.ajax({
            url: "{{ route('admin.upazilas') }}",
            type: 'get',
            data: {id: id},
            beforeSend: function() {
                 $("#selectUpazila").html(`<option value="">Select Upazila</option>`);
            },
            success: function(response){
                $.each(response, function(i,v){
                    $("#selectUpazila").append(`<option value='${i}'>${v}</option>`);
                })
            }
        })
    })

    $(document).on('change', '#selectUpazila', function(event){
        let id = $(this).val()
        $.ajax({
            url: "{{ route('admin.unions') }}",
            type: 'get',
            data: {id: id},
            beforeSend: function() {
                 $("#selectUnion").html(`<option value="">Select Union</option>`);
            },
            success: function(response){
                $.each(response, function(i,v){
                    $("#selectUnion").append(`<option value='${i}'>${v}</option>`);
                })
            }
        })
    })
</script>

@endpush
