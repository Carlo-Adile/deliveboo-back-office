@extends('layouts.admin')

@section('content')
  <div class="container-fluid p-4">
    <div class="row p-2" id="stats">
      <div class="col-12">
        <h2>Statistiche</h2>

        <form action="{{ route('admin.stats.index') }}" method="GET">
          <label for="period">Seleziona il periodo da esaminare</label>
          <select name="period" id="period">
            <option value="last12" {{ $selectedPeriod == 'last12' ? 'selected' : '' }}>
              Ultimi 12 mesi
            </option>
            <option value="last13-24" {{ $selectedPeriod == 'last13-24' ? 'selected' : '' }}>
              Ultimi 13-24 mesi
            </option>
            <option value="last25-36" {{ $selectedPeriod == 'last25-36' ? 'selected' : '' }}>
              Ultimi 25-36 mesi
            </option>
          </select>
          <div class="p-2">
            <button type="submit" class="btn btn-primary rounded border">filtra risultati</button>
            <a href="{{ route('admin.stats.index') }}" class="btn btn-secondary rounded border">Resetta filtri</a>
          </div>
        </form>
      </div>
    </div>

    <div class="row py-3">
      <div class="col-8 mb-4">
        <div class="card p-3 chart_card">
          {!! $chartjs->render() !!}
        </div>
      </div>
      <div class="col-4 mb-4 p-1 h-100 align-self-end">
        <p class="fw-light">Questo grafico mostra lo storico degli ordini al nostro ristorante. Gli ordini sono raggruppati per mese e rappresentano il numero totale di ordini ricevuti con il relativo incasso. Attraverso questo grafico è possibile analizzare sia la quantità di ordini che le entrare mensili.</p>
      </div>
      <div class="col-8">
        <div class="card p-3 chart_card">
          {!! $chartjs2->render() !!}
        </div>
      </div>
      <div class="col-4 p-1 h-100 align-self-end">
        <p class="fw-light">Questo grafico mostra i piatti più venduti nel periodo selezionato, con la quantità di ogni piatto. Dalla lista si nota il numero di ordini ricevuti per ogni piatto e permette di vedere i piatti che vengono acquistati maggiormente</p>
      </div>
    </div>

  </div>
@endsection
