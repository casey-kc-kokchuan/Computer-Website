@component('mail::message')
Dear {{ $name }},

We have received your order. Please verify your order.

@component('mail::button', ['url' => url("Order/ConfirmOrder?email_token=$token&id=$id")])
Verify Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
