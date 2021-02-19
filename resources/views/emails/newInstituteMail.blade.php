@component('mail::message')
Registered a New Institute and Want to Access Permission

Name: {{ $institute['name'] }} <br>
Email: {{ $institute['email'] }}

@component('mail::button', ['url' => route('admin.institutes.show', $institute->id)])
Show Details
@endcomponent

Thanks,<br>
Encrypted Questin Bank to Avoid Question Leaking
@endcomponent
