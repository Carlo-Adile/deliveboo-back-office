@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- my restaurant --}}
            <div id="my_restaurant">
                <div class="row p-2">
                    {{-- thumb image --}}
                    <div class="col-auto py-2">
                        @if ($restaurant->thumb != null)
                            <img src="{{ asset('storage/' . $restaurant->thumb) }}" alt="{{ $restaurant->name }}"
                                style="width: 200px; height: 200px" class="rounded">
                        @else
                            <img src="https://placehold.co/200x200" alt="restaurant placeholder" class="rounded">
                        @endif
                    </div>

                    {{-- name and contacts --}}
                    <div class="col-auto d-flex py-3">
                        <div class="col-auto">
                            <h2 class="text-left">{{ $restaurant->name_restaurant }}</h2>
                            <div class="contacts">
                                <p><i class="fa-solid fa-location-dot"></i>{{ $restaurant->address }}</p>
                                <p><i class="fa-solid fa-envelope"></i>{{ $user->email }}</p>
                                @if ($restaurant->phone_number)
                                    <p><i class="fa-solid fa-phone"></i> {{ $restaurant->phone_number }}</p>
                                @endif
                                <p><span class="fw-bold">VAT </span>{{ $restaurant->vat }}</p>
                                <p>
                                    <i class="fa-solid fa-bowl-food"></i>
                                    @foreach ($restaurant->types as $type)
                                        <span> {{ $type->name }};</span>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection