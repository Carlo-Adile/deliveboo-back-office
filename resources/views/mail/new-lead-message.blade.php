<x-mail::message>
@if ($isUser)
Grazie per aver effettuato un ordine su {{ config('app.name') }}, {{ $istance['customer_name'] }}<br>
Ti confermiamo di aver ricevuto l'ordine nr.{{ $istance['id'] }}<br>
contenente i seguenti prodotti:<br>
@foreach ($order as $dish)
- {{ $dish['name'] }} x {{ $dish['quantity'] }}<br>
@endforeach
@else
Gentile {{ $istance['name_restaurant'] }}<br>
Hai appena ricevuto un nuovo ordine.<br>
Clicca il bottone per accedere alla tua area amministrativa!<br>
@endif

@if ($isUser)
Grazie, {{ config('app.name') }}
@else
<x-mail::button :url="'http://127.0.0.1:8000/login'">
Area Amministrativa
</x-mail::button>
<br>
@endif
</x-mail::message>
