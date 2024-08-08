<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dish;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDishRequest;
use App\Http\Requests\UpdateDishRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Models\Type;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user->restaurant) {
            $restaurant = $user->restaurant;
            $typeList = Type::all();

            return view('admin.restaurants.index', compact('restaurant', 'typeList'));
        } else {
            $restaurant_id = $user->restaurant->id;
            $dishes = Dish::where('restaurant_id', $restaurant_id)->orderBy('name', 'asc')->get();

            return view('admin.dishes.index', compact('dishes'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dishes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDishRequest $request)
    {

        $validated = $request->validated();

        $slug = Str::slug($request->name, '-');
        $validated['slug'] = $slug;

        $user_id = Auth::id();
        $user = User::find($user_id);
        $restaurant_id = $user->restaurant->id;

        $validated['restaurant_id'] = $restaurant_id;

        if ($request->has('image')) {
            $image = Storage::put('uploads', $validated['image']);
            $validated['image'] = $image;
        }

        // dd($validated);
        $dish = Dish::create($validated);
        return to_route('admin.dishes.index')->with('message', "Il Piatto: $dish->name è stato aggiuto con Successo!");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dish $dish)
    {
        if (Gate::allows('update-dish', $dish)) {
            return view('admin.dishes.edit', compact('dish'));
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDishRequest $request, Dish $dish)
    {
        if (Gate::allows('update-dish', $dish)) {
            $validated = $request->validated();
            $slug = Str::slug($request->name, '-');
            $validated['slug'] = $slug;

            if ($request->has('image')) {
                if ($dish->image) {
                    Storage::delete($dish->image);
                }
                $image = Storage::put('uploads', $validated['image']);
                $validated['image'] = $image;
            }
            $dish->update($validated);

            return to_route('admin.dishes.index')->with('message', "$dish->name è stato modificato con successo!");
        } else {
            abort(404);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {
        if (Gate::allows('update-dish', $dish)) {
            if ($dish->image) {
                Storage::delete($dish->image);
            }
            $dish->delete();
            return to_route('admin.dishes.index')->with('message', "$dish->name è stato rimosso dal menu.");
        } else {
            abort(404);
        }
    }
}
