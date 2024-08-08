@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Registrazione') }}</div>


                    <div class="card-body">
                        <form method="post" action="{{ route('register') }}" enctype="multipart/form-data" name="registerForm"
                            onsubmit="return validateRegisterForm(event)">
                            @csrf

                            <!--name-->
                            <div class="mb-4 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nome *') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!--email-->
                            <div class="mb-4 row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail *') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            {{-- Password --}}
                            <div class="mb-4 row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password *') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Conferma Password --}}
                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password *') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- 
                                <div class="card">
                                    <div class="card-header">{{ __('Dati del Ristorante') }}</div>
                                </div>
                            -->
                            
                            <!-- need to fix this cause its ugly -->
                            <hr>
                            <strong class="">{{ __('Dati del Ristorante') }}</strong>
                            <hr>
                        
                            <!--nome ristorante-->
                            <div class="mb-4 row">
                                <label for="name_restaurant"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nome *') }}</label>

                                <div class="col-md-6">
                                    <input id="name_restaurant" type="type"
                                    class="form-control @error('name_restaurant') is-invalid @enderror"
                                        name="name_restaurant" value="{{ old('name_restaurant') }}">

                                    @error('name_restaurant')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!--indirizzo-->
                            <div class="mb-4 row">
                                <label for="address"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo *') }}</label>

                                <div class="col-md-6">
                                    <input id="address" type="type"
                                        class="form-control @error('address') is-invalid @enderror" name="address"
                                        value="{{ old('address') }}">

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!--Email Ristorante-->
                            <!-- <div class="mb-4 row">
                                <label for="contact_email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Email Ristorante *') }}</label>

                                <div class="col-md-6">
                                    <input id="contact_email" type="email"
                                        class="form-control @error('contact_email') is-invalid @enderror"
                                        name="contact_email" value="{{ old('contact_email') }}">

                                    @error('contact_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> -->

                            <!--vat-->
                            <div class="mb-4 row">
                                <label for="vat"
                                    class="col-md-4 col-form-label text-md-right">{{ __('P.IVA *') }}</label>

                                <div class="col-md-6">
                                    <input id="vat" type="text"
                                        class="form-control @error('vat') is-invalid @enderror" name="vat"
                                        value="{{ old('vat') }}">

                                    @error('vat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <!--phone number-->
                            <div class="mb-4 row">
                                <label for="phone_number"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Numero Telefono') }}</label>

                                <div class="col-md-6">
                                    <input id="phone_number" type="tel"
                                        class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                        value="{{ old('phone_number') }}">

                                    @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <!--thumb--> --}}
                            <div class="mb-4 row">
                                <label for="thumb"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Immagine Ristorante') }}</label>

                                <div class="col-md-6">

                                    <input type="file" class="form-control @error('thumb') is-invalid @enderror"
                                        id="thumb" name="thumb">

                                    @error('thumb')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- logo --}}
                            <div class="mb-4 row">
                                <label for="logo"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Logo Ristorante') }}</label>

                                <div class="col-md-6">
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                        id="logo" name="logo">
                                    @error('logo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!--types-->
                            <div class="mb-4 row">
                                <label class="form-label col-md-4">{{ __('Categorie *') }}</label>
                            
                                <div class="d-flex flex-wrap gap-3 col-md-6">
                            
                                    @foreach ($typeList as $type)
                                        <div id="{{ $loop->last ? 'type-error' : '' }}" class="form-check text-center">
                                            <input name="typeList[]" class="form-check-input " type="checkbox"
                                                value="{{ $type->id }}" id="type-{{ $type->id }}"
                                                {{ in_array($type->id, old('typeList', [])) ? 'checked' : '' }} />
                                            <label class="form-check-label"
                                                for="type-{{ $type->id }}">{{ $type->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    @error('typeList')
                                        <span>
                                            <strong class="text-danger"
                                                style="font-size: 0.875em;">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/validations/registerForm.js') }}"></script>
    @endpush
@endsection
