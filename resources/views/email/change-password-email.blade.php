@component('mail::message')
Dear  {{$name}},

You have requested to change password.

@component('mail::button', ['url' => url("Account/VerifyChangePasswordRequest?mint=$id&email_token=$token")])
Verify
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
