<?php

namespace App\Http\Controllers\Admin;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Type;
use Illuminate\Support\Facades\Gate;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $restaurant = $user->restaurant;
        $typeList = Type::all();


        return view('admin.restaurants.index', compact('restaurant', 'typeList', 'user'));
    }
}
