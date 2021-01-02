@extends('custom_layouts.app')

@push('css')

@endpush

@section('content')
    @php
        use App\Helper as RSA;
        use App\Key;
        $key = Key::where('user_id', 1)->first();
        $rsa = new RSA\Encryption($key->private_key, $key->public_key);
    @endphp

   <div class="container" id="create">
        <div class="row">
            <div class="col-md-6">
                <div class="card rounded-0">
            <div class="card-body">
               <form id="createQuestionForm">
                   @csrf
                   <input type="text" name="subject_id" value="{{ $subject_id }}" style="display: none">
                   <div class="form-group">
                       <label for="question">Enter Question Body</label>
                       <textarea name="question" class="form-control summernote" required></textarea>
                   </div>

                    <div class="form-group">
                       <label for="question">Enter First Option</label>
                       <input type="text" name="option1" class="form-control" required>
                   </div>

                    <div class="form-group">
                       <label for="question">Enter Second Option</label>
                       <input type="text" name="option2" class="form-control" required>
                   </div>

                    <div class="form-group">
                       <label for="question">Enter Third Option</label>
                       <input type="text" name="option3" class="form-control" required>
                   </div>

                    <div class="form-group">
                       <label for="question">Enter Fourth Option</label>
                       <input type="text" name="option4" class="form-control" required>
                   </div>

                   <input type="number" value="1" name="marks" style="display: none">
                   <input class="btn btn-primary rounded-0" type="submit" value="Submit">
               </form>
            </div>
        </div>
            </div>
            <div class="col-md-6">
                 @foreach ($questions as $question)
                    <div class="list-group rounded-0 mb-2">
                        <button type="button" class="list-group-item list-group-item-action active">
                            {!! $rsa->privDecrypt($question->question) !!}
                        </button>
                        <button type="button" class="list-group-item list-group-item-action">{{ $rsa->privDecrypt($question->option1) }}</button>
                        <button type="button" class="list-group-item list-group-item-action">{{ $rsa->privDecrypt($question->option2) }}</button>
                        <button type="button" class="list-group-item list-group-item-action">{{ $rsa->privDecrypt($question->option3) }}</button>
                        <button type="button" class="list-group-item list-group-item-action">{{ $rsa->privDecrypt($question->option4) }}</button>
                    </div>
                @endforeach
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
        height: 100,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
        ]
    });
</script>

<script>
    $(document).on('submit', '#createQuestionForm', function(event){
        event.preventDefault()
        var data = $(this).serializeArray();
        $.ajax({
            url: "{{ route('question.store')}}",
            type: "POST",
            dataType: "JSON",
            data:data,
            success: function(response){
                if(response.success){
                    location.reload()
                }
            }
        })
    })
</script>
@endpush
