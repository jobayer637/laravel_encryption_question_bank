@component('mail::message')

{{ $user->name }}
@if ($user->status == 1)
    Accept your request. Now You can access your dashboard
@else
    You are temporary blocked. because of security issue
@endif

@component('mail::button', ['url' => url('http://127.0.0.1:8000/moderator/dashboard') ])
Show Details
@endcomponent

Thanks,<br>
Encrypted Questin Bank to Avoid Question Leaking
@endcomponent
