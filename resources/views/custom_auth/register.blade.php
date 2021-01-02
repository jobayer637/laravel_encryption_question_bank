@extends('custom_layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Register page
            </div>
            <div class="card-body">
            <form id="registerForm" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <small class="text-danger" id="nameMsg"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                <small class="text-danger" id="emailMsg"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phopne" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                                <small class="text-danger" id="phoneMsg"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">
                                <small class="text-danger" id="addressMsg"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="age" class="col-md-4 col-form-label text-md-right">{{ __('Age') }}</label>

                            <div class="col-md-6">
                                <input id="age" type="number" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required autocomplete="age">
                                <small class="text-danger" id="ageMsg"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="about" class="col-md-4 col-form-label text-md-right">{{ __('About') }}</label>

                            <div class="col-md-6">
                                <textarea id="about" type="about" class="summernote form-control @error('about') is-invalid @enderror" name="about" value="{{ old('about') }}" required autocomplete="about"> </textarea>
                                <small class="text-danger" id="aboutMsg"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>

                            <div class="col-md-6">
                                <input id="image" type="file" class=" @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" required autocomplete="address">
                                <small class="text-danger" id="imageMsg"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <small class="text-danger" id="passwordMsg"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
@endsection


@push('js')
<!-- summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $('.summernote').summernote({
        height: 200,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link']],
        ]
    });
</script>

<script>
    let pr_key = ""
    let pu_key = ""
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
                            pr_key = toPem(exportedPrivateKey);
                        })
                        window.crypto.subtle.exportKey(
                            "spki",
                            keyPair.publicKey,
                        ).then(function (exportedPublicKey) {
                            pu_key = toPem2(exportedPublicKey)
                        })
                    });

    </script>

<script>
    $(document).on('submit', '#registerForm', function(event){
        event.preventDefault()
        var data = $(this).serializeArray(); // convert form to array
        data.push({name: "pr_key", value: pr_key});
        data.push({name: "pu_key", value: pu_key});
        $.ajax({
            url: "{{ route('custom-register-create')}}",
            type: "POST",
            dataType: "JSON",
            data:data,
            beforeSend: function() {
                 $("#nameMsg ,#emailMsg, #ageMsg, #phoneMsg, #aboutMsg, #passwordMsg, #addressMsg, #imageMsg").text('')
            },
            success: function(response){
                if(response.success){
                    alert('new users added')
                } else {
                    console.log(response.errors)
                    if(response.errors.name) {
                        $("#nameMsg").text(response.errors.name)
                    }
                    if(response.errors.email[response.errors.email.length-1]) {
                        $("#emailMsg").text(response.errors.email[response.errors.email.length-1])
                    }
                    if(response.errors.phone[response.errors.phone.length-1]) {
                        $("#phoneMsg").text(response.errors.phone[response.errors.phone.length-1])
                    }
                    if(response.errors.about) {
                        $("#aboutMsg").text(response.errors.about)
                    }
                    if(response.errors.age) {
                        $("#ageMsg").text(response.errors.age)
                    }
                    if(response.errors.password[response.errors.password.length-1]) {
                        $("#passwordMsg").text(response.errors.password[response.errors.password.length-1])
                    }
                    // console.log(response.errors.phone[response.errors.phone.length-1])
                }

            }
        })
    })
</script>

@endpush

