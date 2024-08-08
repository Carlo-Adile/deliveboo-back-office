<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class PivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
    
        foreach (Order::all() as $order) { 
            $restaurant = $order->restaurant; //mi recupero così il ristorante associato all'ordine
            $dishes = $restaurant->dishes; //allo stesso modo tramite la relazione mi recupero i piatti di quel singolo ristorante
        
            $number = rand(1, 6); //genero un numero di piatti random 
         
            $DishesList = $dishes->random($number); //random mi permette di selezionare dalla collezione di piatti un numero indicato che passo come parametro
        
            foreach ($DishesList as $dish) {
                $order->dishes()->attach($dish->id, [
                    'dish_name' => $dish->name,
                    'dish_quantity' => $faker->numberBetween(1, 5), 
                    'dish_price' => $dish->price,
                ]);
            }
        }
    }
}
