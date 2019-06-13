@component('mail::message')
# Order has been placed.

Please verify your order.

@component('mail::button', ['url' => 'http://localhost:8000/Test2'])
Verify Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
