<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;



class OrderController extends Controller
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
            $orders = Order::where('restaurant_id', $restaurant_id)->orderByDesc('id')->get();


            return view('admin.orders.index', compact('orders'));
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if (Gate::allows('update-order', $order)) {
            $order->load([
                'dishes' => function ($query) {
                    $query->withTrashed();
                }
            ]);

            return view('admin.orders.show', compact('order'));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return to_route('admin.orders.index')->with('message', "L\' ordine: $order è stato eliminato");
    }
}
