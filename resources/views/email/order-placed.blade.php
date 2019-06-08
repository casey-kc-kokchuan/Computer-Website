@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => 'http://localhost:8000/Test2'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
