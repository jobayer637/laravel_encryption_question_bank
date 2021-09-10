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
                    <form method="POST" action="{{ route('admin.institutes.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="board">Select Board</label>
                            <select class="form-control" name="board_id" id="board">
                                <option value="">Select Education Board</option>
                                @foreach ($boards as $board)
                                    <option value="{{ $board->id }}">{{ $board->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="board">Select Division/District/Upazila/Union</label>
                            <div class="input-group">
                                <select class="form-control" name="division_id" id="selectDivision">
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                </select>

                                <select class="form-control" name="district_id" id="selectDistrict">
                                    <option value="">Select District</option>
                                </select>

                                <select class="form-control" name="upazila_id" id="selectUpazila">
                                    <option value="">Select Upazila</option>
                                </select>

                                <select class="form-control" name="union_id" id="selectUnion">
                                    <option value="">Select Union</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="institute">Enter Institution Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Institution Name" required>
                        </div>

                        <div class="form-group">
                            <label for="eiin">Enter Institution EIIN</label>
                            <input type="text" name="eiin" class="form-control" placeholder="Enter Institution EIIN" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Enter Institution Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Enter Institution Email" required>
                        </div>

                         <div class="form-group">
                            <label for="address">Enter Institution Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter Institution Address" required>
                        </div>

                        <textarea id="pr_key" name="pr_key" style="display: none"></textarea>
                        <textarea id="pu_key" name="pu_key" style="display: none"></textarea>

                        <input class="btn btn-primary rounded-0" type="submit" value="Submit">
                    </form>
                    </div>
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

<script>
    function arrayBufferToBase64(arrayBuffer) {
        var byteArray = new Uint8Array(arrayBuffer);
        var byteString = '';
        for (var i = 0; i < byteArray.byteLength; i++) {
            byteString += String.fromCharCode(byteArray[i]);
        }
        var b64 = window.btoa(byteString);
        return b64;
    }
    function addNewLines(str) {
        var finalString = '';
        while (str.length > 0) {
            finalString += str.substring(0, 64) + '\n';
            str = str.substring(64);
        }
        return finalString;
    }
    function toPem(privateKey) {
        var b64 = addNewLines(arrayBufferToBase64(privateKey));
        var pem = "-----BEGIN PRIVATE KEY-----\n" + b64 + "-----END PRIVATE KEY-----";
        return pem;
    }
    function toPem2(publicKey) {
        var b64 = addNewLines(arrayBufferToBase64(publicKey));
        var pems = "-----BEGIN PUBLIC KEY-----\n" + b64 + "-----END PUBLIC KEY-----";
        return pems;
    }
        window.crypto.subtle.generateKey(
        {
            name: "RSA-OAEP",
            modulusLength: 8192, //4096 or 8192
            publicExponent: new Uint8Array([0x01, 0x00, 0x01]),
            hash: { name: "SHA-256" } // or SHA-512
        },
        true,
        ["encrypt", "decrypt"]
        ).then(function (keyPair) {
            window.crypto.subtle.exportKey(
                "pkcs8",
                keyPair.privateKey,
            ).then(function (exportedPrivateKey) {
                $("#pr_key").val(toPem(exportedPrivateKey))
            })
            window.crypto.subtle.exportKey(
                "spki",
                keyPair.publicKey,
            ).then(function (exportedPublicKey) {
                $("#pu_key").val(toPem2(exportedPublicKey))
            })
        });
    </script>
@endpush
