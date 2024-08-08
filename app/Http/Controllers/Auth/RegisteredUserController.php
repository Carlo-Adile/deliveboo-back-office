<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Type;
use App\Models\Restaurant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;



class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $typeList = Type::all();
        return view('auth.register', compact('typeList'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // dd(($request->all()));
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'name_restaurant' => 'required|min:4|max:255',
            // 'contact_email' => 'required|email|max:255|unique:restaurants,contact_email',
            'address' => 'required|min:4|max:255',
            'phone_number' => 'nullable|numeric|max_digits:20|min_digits:3',
            'logo' => 'image|mimes:png,jpg|max:2048',
            'thumb' => 'image|mimes:png,jpg|max:2048',
            'vat' => 'required|numeric|max_digits:11|min_digits:11',
            'typeList' => 'required|exists:types,id',
        ]);

        //dd($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $restaurant = Restaurant::create([
            'user_id' => $user->id,
            'name_restaurant' => $request->name_restaurant,
            'slug' => Str::slug($request->name_restaurant, '-'),
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'vat' => $request->vat,
            'logo' => $request->has('logo') ? Storage::put('uploads', $request->logo) : null,
            'thumb' => $request->has('thumb') ? Storage::put('uploads', $request->thumb) : null,
        ]);

        if ($request->has('typeList')) {
            $restaurant->types()->attach($request['typeList']);
        }

        //dd($user, $restaurant);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
