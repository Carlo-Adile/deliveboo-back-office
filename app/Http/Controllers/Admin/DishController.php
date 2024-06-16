<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dish;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDishRequest;
use App\Http\Requests\UpdateDishRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dishes = Dish::all();
        return view('admin.dishes.index', compact('dishes'));
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

        $slug = Str::slug($request->title, '-');
        $validated['slug'] = $slug;

        if ($request->has('image')) {
            $image = Storage::put('uploads', $validated['image']);
            $validated['image'] = $image;
        }

        $dish = Dish::create($validated);
        return to_route('admin.dishes.index')->with('message', 'Dish added with Success!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dish $dish)
    {
        return view('admin.dishes.show', compact('dish'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dish $dish)
    {
        return view('admin.dishes.edit', compact('dish'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDishRequest $request, Dish $dish)
    {
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
        return to_route('admin.dishes.index')->with('message', "Piatto modificato con successo");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {
        if ($dish->image) {
            Storage::delete($dish->image);
        }

        $dish->delete();
        return to_route('admin.dishes.index')->with('message', "$dish->name rimosso dal menu");
    }
}
