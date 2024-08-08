<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Type;
use App\Models\Dish;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    public function index()


    /* 
    la query usata: 
        SELECT * FROM `restaurants`
        JOIN `dishes` ON `restaurants`.`id` = `dishes`.`restaurant_id`
        WHERE `dishes`.`visible` = 1;
    */
    {
        $restaurants = Restaurant::with('types', 'dishes')
            // ->whereHas('dishes', function ($query) {
            //     $query->where('visible', 1);
            // })
            ->orderByDesc('id')
            ->paginate(9);
        $types = Type::all();
        $dishes = Dish::all();

        return response()->json([
            "success" => true,
            "restaurants" => $restaurants,
            "types" => $types,
            "dishes" => $dishes
        ]);
    }

    public function getSingleRestaurant($id)
    {
        $restaurant = Restaurant::with([
            'user',
            'types',
            'dishes' => function ($query) {
                $query->where('visible', 1);
            }
        ])->where('id', $id)->first();

        if ($restaurant) {
            return response()->json([
                'success' => true,
                'restaurant' => $restaurant
            ]);
        } else {
            return response()->json([
                'success' => false,
                'restaurant' => 'Sorry nothing found!'
            ]);
        }
    }

    public function filteredType(Request $request)
    {
        $typesList = $request['typesList'];
        $filteredList = count($typesList);

        /* la query usata: */
        /* SELECT `name_restaurant`,`restaurants`.`id` FROM `restaurants`
        JOIN `restaurant_type` ON `restaurants`.`id` = `restaurant_type`.`restaurant_id`
        JOIN `types` ON `restaurant_type`.`type_id` = `types`.`id`
        WHERE `types`.`id` IN (2,4,5)
        GROUP BY `restaurants`.`id`
        HAVING COUNT(`types`.`id`) = 3; */

        $query = DB::table('restaurants')
            ->select('restaurants.name_restaurant', 'restaurants.slug', 'restaurants.logo', 'restaurants.address', 'restaurants.thumb', 'restaurants.id')
            ->join('restaurant_type', 'restaurants.id', '=', 'restaurant_type.restaurant_id')
            ->join('types', 'restaurant_type.type_id', '=', 'types.id')
            ->whereIn('types.id', $typesList)
            ->groupBy('restaurants.id')
            ->havingRaw('COUNT(types.id) = ?', [$filteredList]);

        $restaurants = $query->paginate(9);

        $restaurantIds = $restaurants->pluck('id');

        $types = DB::table('restaurant_type')
            ->select('restaurant_type.restaurant_id', 'types.id as type_id', 'types.name as type_name')
            ->join('types', 'restaurant_type.type_id', '=', 'types.id')
            ->whereIn('restaurant_type.restaurant_id', $restaurantIds)
            ->get()
            ->groupBy('restaurant_id');

        foreach ($restaurants as $restaurant) {
            $restaurant->types = $types->get($restaurant->id) ?? collect();
        }

        return response()->json([
            'success' => true,
            'restaurants' => $restaurants,
            'lunghezza' => $filteredList,
        ]);
    }
}
