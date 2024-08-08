@extends('layouts.admin')

@section('content')
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-6">
                <p class="mt-4"><strong>Prezzo totale: </strong>€ {{ $order->total_price }}</p>
                <p><strong>Data dell'ordine: </strong>{{ \Carbon\Carbon::parse($order->date)->format('d-m-Y H:i') }}</p>
                <p><strong>Stato dell'ordine: </strong>{{ $order->status }}</p>
            </div>
            <div class="col-6">
                <h3>Dati cliente</h3>
                <p><strong>Nome: </strong>{{ $order->customer_name }}</p>
                <p><strong>Cognome: </strong>{{ $order->customer_lastname }}</p>
                <p><strong>Email: </strong>{{ $order->customer_email }}</p>
                <p><strong>Numero di telefono: </strong>{{ $order->customer_phone_number }}</p>
                <p><strong>Indirizzo: </strong>{{ $order->customer_address }}</p>
            </div>
            <div class="col-12">
                <h3>Piatti</h3>
                @foreach ($order->dishes as $dish)
                    <div class="card my-3">
                        <div class="card-body">
                            <h4 class="card-title mb-3">{{ $dish->name }}</h4>
                            <p class="card-text">Quantità: {{ $dish->pivot->dish_quantity }}</p>
                            <p class="card-text">Prezzo: € {{ $dish->price }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
