@component('mail::message')
{{ $notice['title'] }}

@component('mail::button', ['url' => 'http://127.0.0.1:8000/admin/notice/'.$notice['id']])
Click Here
@endcomponent

Thanks,<br>
Encrypted Questin Bank to Avoid Question Leaking
@endcomponent
