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

   <div class="container my-5">
       <div class="row">
            <div class="col-3">
                <div class="card rounded-0">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @foreach ($subjects as $subject)
                        <a class="nav-link rounded-0" id="v-pills-profile-tab-{{ $subject->id }}" data-toggle="pill" href="#v-pills-profile-{{ $subject->id }}" role="tab" aria-controls="v-pills-profile" aria-selected="false">{{ $subject->name }}</a>
                    @endforeach
                </div>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    @foreach ($subjects as $subject)
                        <div class="tab-pane fade" id="v-pills-profile-{{ $subject->id }}" role="tabpanel" aria-labelledby="v-pills-profile-tab-{{ $subject->id }}">
                            <div class="card rounded-0">
                                <div class="card-header">
                                   <div class="d-flex justify-content-between">
                                       <div> {{ $subject->name }}</div>
                                       <div>
                                            <a href="{{ route('question.create', ['subject_id'=> $subject->id]) }}" class="btn btn-sm btn-warning rounded-0">Add New Question</a>
                                       </div>
                                   </div>
                                </div>
                                <div class="card-body">
                                    @foreach ($subject->questions as $question)
                                       <div class="list-group rounded-0 mb-2">
                                            <button type="button" class="list-group-item list-group-item-action active">
                                                {{-- {{ $question->question }} --}}
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
                    @endforeach
                </div>
            </div>
        </div>
   </div>
@endsection


@push('js')

@endpush
