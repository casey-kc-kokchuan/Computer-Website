@component('mail::message')
Dear {{ $order->name }},

Your order has been confirmed. Order detail is as follow:


@component('mail::table')

|||
|:----------------------------------------|-------------------------:|
|<span style="font-weight:700;font-size:1.5em">{{ config('app.name')}}</span>| Order ID: {{ $order->id }}|

@endcomponent

@component('mail::table')
| Product             | Qty                  | Unit Price(RM)         | Price(RM)                              |
|:--------------------|---------------------:|-----------------------:|---------------------------------------:|
@foreach($orderlist as $product)
| {{ $product->name}} | {{ $product->qty}}   | {{ $product->price}}   | {{ $product->qty * $product->price }}  |
@endforeach
|                     |                      | <strong>Total Price:<strong>           | {{$order->total_price}}|
@endcomponent



Thanks,<br>
{{ config('app.name') }}
@endcomponent
