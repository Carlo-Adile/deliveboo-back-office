@extends('layouts.admin')

@section('content')
<div class="container-fluid p-4">
  <div class="row">
    <div class="col-12">
      <h2>Il tuo Menu</h2>
      <h5>
        Aggiungi un nuovo piatto
        <a href="{{ route('admin.dishes.create') }}" class="btn btn-primary btn-sm">
          <i class="fa-solid fa-plus"></i>
        </a>
      </h5>
      @if (session('message'))
      <div class="alert alert-success alert-dismissible fade show p-3 align-middle" role="alert">
      {{ session('message') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
      {{-- counter --}}
      @if ($dishes->isNotEmpty())
      <div class="col-4 py-2">
      <div class="card p-2 shadow-sm">
        <span class="fw-bold">Piatti attualmente caricati - {{ $dishes->count() }}</span>
        <span class="fw-semibold">di cui visibili - {{ $dishes->where('visible', 1)->count() }}</span>
      </div>
      </div>
    @endif
    </div>

    {{-- tabella --}}
    @if ($dishes->isNotEmpty())
    <div class="table-responsive" id="my_table">
      <table class="table table-striped table-hover">
      <thead>
        <tr>
        {{-- <th scope="col">#</th> --}}
        <th scope="col" class="border-0">Immagine</th>
        <th scope="col">Nome</th>
        <th scope="col">Prezzo</th>
        <th class="text-center" scope="col">
          Disponibile
          <span class="position-relative">
          <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top"
            title="Indica se i clienti possono vedere questo prodotto sulla tua pagina e sono in grado di inserirlo nel proprio carrello"></i>
          </span>
        </th>
        <th class="text-center" scope="col">Azioni</th>
        </tr>
      </thead>
      <tbody>

        @foreach ($dishes as $dish)
        <tr>
        {{-- <td scope="row">{{ $dish->id }}</td> --}}
        <td class="ps-3">
          @if ($dish->image != null)
        <img src="{{ asset('storage/' . $dish->image) }}" alt="{{ $dish->name }}"
        style="width: 50px; height: 50px" class="rounded">
      @else
      <img src="https://placehold.co/50x50" alt="restaurant placeholder" class="rounded">
    @endif
        </td>
        <td>
          {{ $dish->name }}
        </td>
        <td>€ {{ $dish->price }}</td>
        <td class="text-center"><input type="checkbox" disabled {{ $dish->visible ? 'checked' : '' }}></td>
        <td class="text-center">
          <a href="{{ route('admin.dishes.edit', $dish) }}">
          <i class="fa-solid fa-pencil"></i>
          </a>
          {{-- bs5-modal-default --}}
          <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal-{{ $dish->id }}">
          <i class="fa-solid fa-trash-can"></i>
          </button>
          <div class="modal fade" id="modal-{{ $dish->id }}" tabindex="-1" data-bs-backdrop="static"
          data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitle-{{ $dish->name }}"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
          <div class="modal-content">
          <div class="modal-header justify-content-center">
            <h5 class="modal-title" id="modalTitleId">
            Vuoi rimuovere {{ $dish->name }} ?
            </h5>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
        data-bs-target="#modal-{{ $dish->id }}"></button> -->
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Annulla
            </button>
            <form action="{{ route('admin.dishes.destroy', $dish) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Conferma</button>
            </form>
          </div>
          </div>
          </div>
          </div>

        </td>
        </tr>
    @endforeach
    @else
      <hr>
      <h5>Nessun piatto aggiunto</h5>
      <p>Attualmente non hai aggiunto nessun piatto al tuo menu.</p>
    @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
@endSection